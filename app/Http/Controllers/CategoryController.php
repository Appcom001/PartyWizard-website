<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Display a listing of the categories
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    // Show form to create a new category
    public function create()
    {
        $parentCategories = Category::where('is_parent', 1)->get();
        return view('categories.create', compact('parentCategories'));
    }

    // Store a new category in the database
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:categories',
            'status' => 'required|in:active,inactive',
        ]);

        Category::create($validatedData);

        return redirect()->route('categories.index')
            ->with('success', 'Category added successfully');
    }

    // Show form to edit an existing category
    public function edit(Category $category)
    {
        $parentCategories = Category::where('is_parent', 1)->get();
        return view('categories.edit', compact('category', 'parentCategories'));
    }

    // Update the category in the database
    public function update(Request $request, Category $category)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:categories,slug,' . $category->id,
            'status' => 'required|in:active,inactive',
        ]);

        $category->update($validatedData);

        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully');
    }

    // Delete a category from the database
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully');
    }
}
