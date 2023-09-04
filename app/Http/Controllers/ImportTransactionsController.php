<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImportTransactionsController extends Controller
{
    public function upload(Request $request)
    {
        // Validate the request to ensure it's a CSV file
        $request->validate([
            'files.*.bankAccount' => 'required|integer',
            'files.*.file' => 'required|mimes:csv,txt|max:2048', // Validate as CSV or text file
        ]);
        // Access the uploaded files and associated bank accounts
        $uploadedFiles = $request->input('files');
    
        $convertedFiles = [];
        foreach ($uploadedFiles as $i=>$fileData) {
            $bankAccount = $fileData['bankAccount'];
            $file = $request->file("files.$i.file");

            $convertedFiles[] = self::csvToTransactions($file, $bankAccount);
        }
    
        // Redirect or return a response
        return response()->json($convertedFiles);
    }
    
    private static function csvToTransactions($csvFile, $accountId){
        // TODO: Pull configs from database
        
        // Chase config
        $accountConfig = (object)['id'=>1,'name'=>'Freedom','headerLines'=>1, 'date'=>0, 'description'=>2, 'amount'=>5];

        $handle = fopen($csvFile->path(), 'r');

        foreach(range(1,$accountConfig->headerLines) as $_){
            fgetcsv($handle);
        }

        $convertedLines = [];
        while ($line = fgetcsv($handle)) {
            $newTransaction = 
            //      App\Models\Transaction::firstOrNew(
                     [ 
                         'account_id' => $accountConfig->id,
                         'date' => $line[$accountConfig->date],
                         'description' => $line[$accountConfig->description],
                         'amount' => $line[$accountConfig->amount],
                     ]
            //      )
            ;

            $convertedLines[] = $newTransaction;

            //TODO: log if the transaction was found instead of created
        }

        fclose($handle);

        return $convertedLines;
    }
}
