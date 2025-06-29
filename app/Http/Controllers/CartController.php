<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Services\ExchangeRateService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;
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
    $rates = $this->exchangeService->getRates(); //

  
    if (empty($cart)) {
        return redirect()->route('cart.index')->with('error', 'El carrito está vacío.');
    }

    $totalSol = 0;
    $itemsProcesados = [];
    
    foreach ($cart as $item) {
        $rate = $rates[$item['currency']] ?? 1;    
        
        $subtotal = $item['price'] * $item['quantity'];
        $subtotalSol = $subtotal * $rate;
        $totalSol += $subtotalSol;

        $itemsProcesados[] = [
            'product_name' => $item['name'],
            'quantity' => $item['quantity'],
            'price' => $item['price'],
            'currency' => $item['currency'],
            'subtotal_sol' => $subtotalSol,
        ];
    }

    $user = Auth::user();
   DB::beginTransaction();

    try {
    if ($user->dinero_digital >= $totalSol) {
        $user->dinero_digital -= $totalSol;
            $paymentMethod = 'digital';

    } elseif ($user->dinero_digital + $user->dinero_credito >= $totalSol) {
        // Usa primero el dinero digital
        $restante = $totalSol - $user->dinero_digital;
        $user->dinero_digital = 0;
        $user->dinero_credito -= $restante;
            $paymentMethod = 'mixto';

    } else {
    return redirect()->route('cart.show')->with('error', 'Fondos insuficientes para completar la compra.');
    }

    $user->save(); // Guarda los cambios en la base de datos

    // Aquí puedes registrar la compra, si usas una tabla de órdenes/pedidos
    // Por ahora solo limpiamos el carrito
            // Registrar la orden
        $order = new \App\Models\Order();
        $order->user_id = $user->id;
        $order->total = $totalSol ;
        $order->payment_method = $paymentMethod;
        $order->save();
        // Registrar los ítems
        foreach ($itemsProcesados as $item) {
            $order->items()->create($item);
        }
      DB::commit();
        session()->forget('cart');

        return redirect()->route('cart.index')->with('success', 'Compra realizada y registrada con éxito.');
    } catch (\Exception $e) {
        dd($e);
        DB::rollBack();

        return redirect()->route('cart.index')->with('error', 'Ocurrió un error al procesar la compra.');
    }
}


}
