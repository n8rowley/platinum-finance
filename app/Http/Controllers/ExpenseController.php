<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\Transaction;
use Closure;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    public function storeByTransaction(Request $request, Transaction $transaction)
    {        
        $transaction->expenses()->createMany($request->expenses);
        $transaction->update(['processed'=>true]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expense $expense)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        //
    }


    public function getGroupedExpenses(Request $request)
    {
        $expensesData = Expense::whereMonth('month',$request->month)
            ->whereYear('month',$request->year)
            ->groupedExpenseData()
            ->get();


        $formattedData = $expensesData->groupBy(['category_name','sub_category_name'])
            ->map(function ($subCategories,$categoryName) use ($expensesData){
                xdebug_break();
                $subCategories->transform(function($expenses, $subCategoryName){
                    $total = $expenses->sum('expense_total');
                    return [
                        'sub_category_total_raw' => $total,
                        'sub_category_total' => number_format($total,2),
                        'expenses' => $expenses,
                    ];
                });

                $total = $subCategories->sum('sub_category_total_raw');
                return [
                    'category_total_raw' => $total,
                    'category_total' => number_format($total,2),
                    'sub_categories' => $subCategories,
                ];
                
            });
        
        return response()->json($formattedData);
    }

}
