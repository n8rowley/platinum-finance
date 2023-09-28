<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BankAccount;
use App\Http\Requests\BankAccountRequest;

class BankAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return BankAccount::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string',
            'enabled' => 'sometimes|required|boolean',
        ]);

        $account = BankAccount::create($validated);

        return $account;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BankAccountRequest $request, string $id)
    {
        $account = BankAccount::find($id);

        $account->update($request->safe(['name','enabled']));
        if ($request->has('statement_map')) {
            if ($account->statementMap()->exists()){
                $account->statementMap->update($request->safe(['statement_map'])['statement_map']);
            } else {
                $account->statementMap()->create($request->safe(['statement_map'])['statement_map']);
            }
        }

        return $account->refresh();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
