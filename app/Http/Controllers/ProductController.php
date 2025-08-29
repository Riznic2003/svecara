<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     */
    public function index()
    {
        $products = Product::with('category')->orderBy('name')->paginate(10);
        return view('products.index', compact('products'));
    }

    /**
     */
    public function create()
    {
        $categories = Category::orderBy('name')->pluck('name', 'id');
        return view('products.create', compact('categories'));
    }

    /**
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'unit'        => 'required|string|max:20',
            'sku'         => 'nullable|string|max:100|unique:products,sku',
            'min_stock'   => 'nullable|integer|min:0',
        ]);

        $data['min_stock'] = $data['min_stock'] ?? 0;

        Product::create($data);

        return redirect('/products')->with('ok', 'Proizvod dodat.');
    }

    /**
     */
    public function show(Product $product)
    {
        abort(404);
    }

    /**
     */
    public function edit(Product $product)
    {
        $categories = \App\Models\Category::orderBy('name')->pluck('name','id');
        return view('products.edit', compact('product','categories'));
    }

    /**
     */
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'unit'        => 'required|string|max:20',
            'sku'         => 'nullable|string|max:100|unique:products,sku,' . $product->id,
            'min_stock'   => 'nullable|integer|min:0',
        ]);

        $data['min_stock'] = $data['min_stock'] ?? 0;

        $product->update($data);

        return redirect('/products')->with('ok', 'Proizvod izmenjen.');
    }

    /**
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect('/products')->with('ok', 'Proizvod obrisan.');
    }
}
