<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', Product::class);

        $products = Product::with('user')->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        Gate::authorize('create', Product::class);

        return view('products.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Product::class);

        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
        ]);

        Product::create([
            'name'      => $validated['name'],
            'price'     => $validated['price'],
            'user_id'   => $request->user()->id,
            'is_public' => $request->has('is_public'),
        ]);

        return redirect()->route('products.index')->with('status', 'Produit créé avec succès.');
    }

    public function show(Product $product)
    {
        Gate::authorize('view', $product);

        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        Gate::authorize('update', $product);

        return view('products.edit', compact('product'));
    }

    public function update(Request $request,  Product $product)
    {
        Gate::authorize('update', $product);

        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
        ]);

        $product->update([
            'name'      => $validated['name'],
            'price'     => $validated['price'],
            'is_public' => $request->has('is_public'),
        ]);

        return redirect()
            ->route('products.index')
            ->with('status', 'Produit mis à jour avec succès.');
    }

    public function destroy(Product $product)
    {
        Gate::authorize('delete', $product);

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('status', 'Produit supprimé avec succès.');
    }
}