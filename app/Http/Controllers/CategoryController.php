<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     */
    public function index()
    {
        $categories = Category::orderBy('name')->paginate(10);
        return view('categories.index', compact('categories'));
    }

    /**
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
        ]);

        Category::create($data);

        return redirect('/categories')->with('ok', 'Kategorija dodata.');
    }

    /**
     */
    public function show(Category $category)
    {
        abort(404);
    }

    /**
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     */
    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
        ]);

        $category->update($data);

        return redirect('/categories')->with('ok', 'Kategorija izmenjena.');
    }

    /**
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect('/categories')->with('ok', 'Kategorija obrisana.');
    }
}
