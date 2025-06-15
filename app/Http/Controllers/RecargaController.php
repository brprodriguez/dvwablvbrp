<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RecargaController extends Controller
{
    public function show()
    {
        return view('recarga.formulario');
    }

    public function buscarUsuarios(Request $request)
    {
        $search = $request->input('term');
        $usuarios = User::where('tipo_usuario', 1)
    ->where(function($query) use ($search) {
        $query->where('name', 'LIKE', "%{$search}%")
              ->orWhere('email', 'LIKE', "%{$search}%");
    })
    ->limit(10)
    ->get();

        $results = [];

        foreach ($usuarios as $usuario) {
            $results[] = ['id' => $usuario->id, 'text' => "{$usuario->name} ({$usuario->email})"];
        }

        return response()->json(['results' => $results]);
    }

    public function procesar(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|exists:users,id',
            'monto' => 'required|numeric|min:0.01',
        ]);

        $usuario = User::findOrFail($request->usuario_id);
        $usuario->dinero_digital += $request->monto;
        $usuario->save();

        return redirect()->back()->with('success', 'Saldo recargado correctamente.');
    }
}
