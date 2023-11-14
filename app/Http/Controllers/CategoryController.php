<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Category::with('subCategories');

        if (!$request->with_disabled){
            $data->where('enabled', true);
        }

        return $data->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'string|unique:categories,name',
            'enabled' => 'sometimes|boolean',
        ]);

        return Category::create($validated)->refresh()->load('subCategories');  
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|unique:categories,name',
            'enabled' => 'sometimes|boolean',
        ]);
        $category->update($validated);
        return $category->refresh();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
