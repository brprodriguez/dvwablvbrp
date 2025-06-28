<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Services\ExchangeRateService;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    protected $exchangeService;

    public function __construct(ExchangeRateService $exchangeService)
    {
        $this->exchangeService = $exchangeService;
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:5',
        ]);

        $product = Product::findOrFail($request->product_id);
        $quantity = $request->quantity;

        $cart = session()->get('cart', []);

        // Si ya existe el producto en carrito, suma cantidades
        if(isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'currency' => $product->currency,
            ];
        }

        session()->put('cart', $cart);

      
        return redirect()->back()->with('success', "Añadido $quantity x $product->name al carrito.");

    }
    public function show()
    {
        $cart = session()->get('cart', []);
        $rates = $this->exchangeService->getRates(); //

        $totalSol = 0;

       return view('cart.show', compact('cart', 'rates', 'totalSol'));

    }

    public function clear()
    {
        session()->forget('cart'); // Elimina la variable 'cart' de la sesión
        return redirect()->route('cart.show')->with('success', 'Carrito limpiado correctamente.');
    }

   /* public function checkout(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
    ]);

    $cart = session()->get('cart', []);
    $rates = $this->exchangeService->getRates();

    // Aquí podrías procesar el pedido, guardarlo en base de datos, enviar correo, etc.
    // Por ahora, solo simularemos la compra.

    session()->forget('cart'); // Limpiar carrito tras "compra"

    return redirect()->route('products.index')->with('success', 'Compra realizada exitosamente. Gracias por tu compra, ' . $request->name . '!');
}*/


public function checkout(Request $request)
{
    $cart = session('cart', []);
    $rates = session('rates', []);

    if (empty($cart)) {
        return redirect()->route('cart.index')->with('error', 'El carrito está vacío.');
    }

    $totalSol = 0;

    foreach ($cart as $item) {
        $rate = $rates[$item['currency']] ?? 1;
        $subtotal = $item['price'] * $item['quantity'];
        $subtotalSol = $subtotal * $rate;
        $totalSol += $subtotalSol;
    }

    $user = Auth::user();

    if ($user->dinero_digital >= $totalSol) {
        $user->dinero_digital -= $totalSol;
    } elseif ($user->dinero_digital + $user->dinero_credito >= $totalSol) {
        // Usa primero el dinero digital
        $restante = $totalSol - $user->dinero_digital;
        $user->dinero_digital = 0;
        $user->dinero_credito -= $restante;
    } else {
        return redirect()->route('cart.show')->with('success', 'Compra realizada con éxito.');
    }

    $user->save(); // Guarda los cambios en la base de datos

    // Aquí puedes registrar la compra, si usas una tabla de órdenes/pedidos
    // Por ahora solo limpiamos el carrito
    session()->forget('cart');

    return redirect()->route('cart.index')->with('success', 'Compra realizada con éxito.');
}


}
