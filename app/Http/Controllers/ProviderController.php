<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Requests\ProviderRequest;
use App\Services\ProviderServices\StoreDataService;

class ProviderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function store(ProviderRequest $request)
    {

        (new StoreDataService())->storeProvidersData($request);
    }

    public function getUsersData()
    {
        $clients = Client::with('transactions')->get();
        return response()->json([
              'Users' => $clients
        ]);
    }

    public function filterByItem(Request $request){
        $item = $request->item;
        $transactions = Transaction::where('currency', $item) ->orWhere('statusCode', $item)->get();

        return response()->json([
            'Transactions' => $transactions
        ]);
    }

    public function filterByRange(Request $request){
        $start = $request->start;
        $end = $request->end;

        $transactions = Transaction::where(function($query) use ($start, $end){
             $query->whereBetween('paidAmount', [$start, $end])
                   ->orWhere(function($query) use ($start, $end){
                      $query->whereBetween('paymentDate', [$start, $end]);
                   });
        })->orderBy('paidAmount', 'ASC')->get();

        return response()->json([
            'Transactions' => $transactions
        ]);
    }
}
