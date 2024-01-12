<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Transaction::all();
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
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
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
