<?php
namespace App\Services\ProviderServices;

use Carbon\Carbon;
use App\Models\Client;
use App\Models\Provider;
use App\Models\Transaction;
use Illuminate\Support\Facades\Validator;

class StoreDataService {

    public function validation($request){
        global $validator;
        $validator = Validator::make($request->all(), $request->rules());
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
    }

    public function storeFilesPath($request){
        global $validator;
        $providedFile = Provider::create(array_merge(
            $validator->validated(),
            [
                'usersFile' => $request->file('usersFile')->store('clients'),
                'transactionsFile' => $request->file('transactionsFile')->store('transactions'),
            ]
        ));
        return $providedFile;
    }

    public function decodeUsersData($providedFile){
        $usersFilePath = $providedFile->usersFile;
        $usersJsonData = file_get_contents($usersFilePath);
        $usersData = json_decode($usersJsonData, true);

        return $usersData;
    }

    public function decodeTransactionsData($providedFile){
        $transactionsFilePath = $providedFile->transactionsFile;
        $transactionsJsonData = file_get_contents($transactionsFilePath);
        $transactionsData = json_decode($transactionsJsonData, true);

        return $transactionsData;
    }

    public function parseUsersData($usersData){

        foreach($usersData as $value){
            foreach($value as $item){
                $client = Client::create([
                    'balance' => $item['balance'],
                    'currency' => $item['currency'],
                    'email' => $item['email'],
                    'created_at' => Carbon::createFromFormat('d/m/Y', $item['created_at'])->format("Y-m-d"),
                    'pass_id' => $item['id'],
                ]);

            }
        }
    }

    public function parseTransactionsData($transactionsData){
        foreach($transactionsData as $value){
            foreach($value as $item){
                 $transactions = Transaction::create([
                    'paidAmount' => $item["paidAmount"],
                    'currency' => $item["Currency"],
                    'parentEmail' => $item["parentEmail"],
                    'statusCode' => $item["statusCode"],
                    'paymentDate' => Carbon::parse($item["paymentDate"])->format("Y-m-d"),
                    'parentIdentification' => $item["parentIdentification"],
                ]);

            }
        }
    }

    public function storeProvidersData($request){
       $this->validation($request);
       $providedFile = $this->storeFilesPath($request);
       $usersData = $this->decodeUsersData($providedFile);
       $transactionsData = $this->decodeTransactionsData($providedFile);
       $this->parseUsersData($usersData);
       $this->parseTransactionsData($transactionsData);

       return response()->json([
         'message' => 'Files successfully uploaded'
          ], 201);

    }
}
