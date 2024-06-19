<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Transaction::query();

        if ($request->has('filter')){
            foreach($request->filter as $field=>$data){
                $type = $data['type'];
                $value = $data['value'];

                if ($type == 'exact'){
                    $query->where($field,filter_var($value, FILTER_VALIDATE_BOOLEAN));
                } else if ($type == 'search'){
                    $query->whereRaw("$field LIKE '%$value%'");
                } else if ($type == 'list') {
                    $query->whereIn($field,$value);
                } else if ($type == 'date-range') {
                    $startDate = $value['start'];
                    $endDate = $value['end'];

                    if($startDate) $query->whereDate('date','>=',$value['start']);
                    if($endDate) $query->whereDate('date','<=',$value['end']);
                }
            }
        }

        if ($request->filled('sortBy')) {
            $query->orderBy($request->sortBy, filter_var($request->sortDesc, FILTER_VALIDATE_BOOLEAN) ? 'desc' : 'asc');
        } else {
            $query->orderBy('date');
        }

        return $query->get();
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        return $transaction->load([
            'bankAccount:id,name', 
            'expenses' => [
                'subCategory.category'
            ]
        ]);
    }

    public function oldest()
    {
        return Transaction::with('bankAccount')->notProcessed()->first();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'description' => 'sometimes|string',
            'bank_account_id' => 'sometimes|exists:bank_accounts,id',
            'date' => 'sometimes|date',
            'amount' => 'sometimes|decimal:2',
            'processed' => 'sometimes|boolean',
            'duplicate' => 'sometimes|boolean',
        ]);

        $transaction->update($validated);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
