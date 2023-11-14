<?php

namespace App\Http\Controllers;

use App\Models\SubCategory;
use App\Models\Category;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Category $category)
    {
        $data = $category->subCategories();
        if (!$request->with_disabled){
            $data = $data->where('enabled',true);
        }
        return $data->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'string:unique:sub_categories,name',
            'enabled' => 'sometimes|boolean',
        ]);

        return $category->subCategories()->create($validated)->refresh();
    }

    /**
     * Display the specified resource.
     */
    public function show(SubCategory $subCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category, SubCategory $subCategory)
    {
        $validated = $request->validate([
            'name' => 'sometimes|unique:sub_categories,name',
            'category_id' => 'sometimes|required|integer|exists:categories,id',
            'enabled' => 'sometimes|boolean',
        ]);
        $subCategory->update($validated);
        return $subCategory->refresh();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubCategory $subCategory)
    {
        //
    }
}
