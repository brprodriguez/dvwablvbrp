<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Carbon\Carbon;
class ProductController extends Controller
{
    // Mostrar formulario
    public function create()
    {
        return view('products.create');
    }

    // Guardar producto
    public function store(Request $request)
    {
        // Validar datos
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|string|size:3',
            'stock' => 'required|integer|min:0',
        ]);

        // Crear producto
        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'currency' => strtoupper($request->currency),
            'stock' => $request->stock,
            'entry_date' => now(),
        ]);

        // Redirigir con mensaje
        
        return redirect()->route('products.index')->with('success', 'Producto registrado correctamente.');

    }

    public function index()
    {
        $products = Product::orderBy('entry_date', 'desc')->get();
        return view('products.index', compact('products'));
    }

    public function comprar()
    {
        $products = Product::orderBy('entry_date', 'desc')->get();
        return view('products.comprar', compact('products'));
    }
}
