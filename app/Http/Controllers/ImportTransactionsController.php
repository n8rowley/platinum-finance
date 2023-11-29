<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\BankAccount;
use App\Models\Transaction;
use Carbon\Carbon;

class ImportTransactionsController extends Controller
{
    public function uploadTransactions(Request $request)
    {
        $validated = $request->validate([
            'transactions.*.bank_account_id' => 'required|exists:bank_accounts,id',
            'transactions.*.date' => 'required|date',
            'transactions.*.amount' => 'required|decimal:0,2',
            'transactions.*.description' => 'required|string',
        ]);

        $importStatistics = [];
        foreach($validated['transactions'] as $transaction){
            $newTransaction = Transaction::firstOrCreate([
                'bank_account_id' => $transaction['bank_account_id'],
                'date' => Carbon::parse($transaction['date'])->format('Y-m-d'),
                'description' => $transaction['description'],
                'amount' => $transaction['amount'],
            ]);
            
            $importStatistics[] = [
                'account_name' => BankAccount::find($transaction['bank_account_id'])->name,
                'total' => 1,
                'created' => intval($newTransaction->wasRecentlyCreated),
            ];

            if (!$newTransaction->wasRecentlyCreated) {
                Log::channel('duplicateTransactions')
                    ->notice('Individual transaction marked as duplicate.',[
                        'transaction_line'=>$transaction,
                        'database_model'=>$newTransaction, 
                    ]);
            }
        }

        return response()->json($importStatistics);
    }


    public function uploadFiles(Request $request)
    {
        $request->validate([
            'files.*.bankAccount' => 'required|integer',
            'files.*.file' => 'required|mimes:csv,txt|max:2048', // Validate as CSV or text file
        ]);

        $uploadedFiles = $request->input('files');
    
        $fileImports = [];
        foreach ($uploadedFiles as $i=>$fileData) {
            $bankAccount = BankAccount::find($fileData['bankAccount']);
            $file = $request->file("files.$i.file");

            $fileImports[] = self::parseCSV($file, $bankAccount);
        }

        return response()->json($fileImports);
    }
    

    private static function parseCSV($csvFile, $account)
    {
        $accountMap = $account->statementMap;

        $handle = fopen($csvFile->path(), 'r');

        foreach(range(1,$accountMap->header_lines) as $_){
            fgetcsv($handle);
        }

        $importStatistics = [
            'account_name' => $account->name,
            'created' => 0,
            'total' => 0,
        ];

        while ($line = fgetcsv($handle, escape: '')) {
            if ($accountMap->amount_is_split){
                $parsedAmount = $line[$accountMap->amount_column] == '' ? $line[$accountMap->amount_2_column]: $line[$accountMap->amount_column];
            }else{
                $parsedAmount = $line[$accountMap->amount_column];
            }

            $newTransaction = Transaction::firstOrCreate([
                'bank_account_id' => $account->id,
                'date' => Carbon::parse($line[$accountMap->date_column])->format('Y-m-d'),
                'description' => $line[$accountMap->description_column],
                'amount' => $parsedAmount,
            ]);

            $importStatistics['total'] += 1;

            if ($newTransaction->wasRecentlyCreated) {
                $importStatistics['created'] += 1;
            } else {
                Log::channel('duplicateTransactions')
                    ->notice('Statement transaction marked as duplicate.',[
                        'file_name' => $csvFile->getClientOriginalName(),
                        'file_line'=>$line,
                        'database_model'=>$newTransaction, 
                    ]);
            }
        }

        fclose($handle);

        return $importStatistics;
    }
}
