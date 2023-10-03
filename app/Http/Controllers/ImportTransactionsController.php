<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BankAccount;
use App\Models\Transaction;
use Carbon\Carbon;

class ImportTransactionsController extends Controller
{
    public function upload(Request $request)
    {
        xdebug_break();
        // Validate the request to ensure it's a CSV file
        $request->validate([
            'files.*.bankAccount' => 'required|integer',
            'files.*.file' => 'required|mimes:csv,txt|max:2048', // Validate as CSV or text file
        ]);
        // Access the uploaded files and associated bank accounts
        $uploadedFiles = $request->input('files');
    
        $fileImports = [];
        foreach ($uploadedFiles as $i=>$fileData) {
            $bankAccount = BankAccount::find($fileData['bankAccount']);
            $file = $request->file("files.$i.file");

            $fileImports[] = self::csvToTransactions($file, $bankAccount);
        }

        return response()->json($fileImports);
    }
    
    private static function csvToTransactions($csvFile, $account){
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

        while ($line = fgetcsv($handle)) {
            xdebug_break();
            if ($accountMap->amount_is_split){
                $parsedAmount = $line[$accountMap->amount_column] == '' ? $line[$accountMap->amount_2_column]: $line[$accountMap->amount_column];
            }else{
                $parsedAmount = $line[$accountMap->amount_column];
            }

            $newTransaction = Transaction::firstOrCreate([
                'bank_account_id' => $account->id,
                'date' => Carbon::parse($line[$accountMap->date_column]),
                'description' => $line[$accountMap->description_column],
                'amount' => $parsedAmount,
            ]);

            $importStatistics['total'] += 1;
            if ($newTransaction->wasRecentlyCreated) $importStatistics['created'] += 1;

            //TODO: log if the transaction was found instead of created
        }

        fclose($handle);

        return $importStatistics;
    }
}
