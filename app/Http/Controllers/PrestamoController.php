<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prestamo;
use App\Models\Prestamoautomatico;

class PrestamoController extends Controller
{
    public function index()
    {
        $prestamos = Prestamo::all()->where('user_id', auth()->id());
        return view('prestamo.index', compact('prestamos'));
    }

     public function indexautomatico()
    {
        $prestamos = Prestamoautomatico::all()->where('user_id', auth()->id());
        return view('prestamo.indexautomatico', compact('prestamos'));
    }

    public function tramitar(){
        $prestamos = Prestamo::all();
        return view('prestamo.tramitar', compact('prestamos'));
    }

    public function create()
    {
        return view('prestamo.create');
    }
     public function automaticocreate()
    {
        
        return view('prestamo.automaticocreate');
    }



    public function calcularTasa($perfilRiesgo)
    {
        $tasa = 0;

        if ($perfilRiesgo === 'AAA') {
            $tasa = 9.0;
        } elseif ($perfilRiesgo === 'AA') {
            $tasa = 10.0;
        } elseif ($perfilRiesgo === 'A') {
            $tasa = 11.0;
        } elseif ($perfilRiesgo === 'BBB') {
            $tasa = 15.0;
        } elseif ($perfilRiesgo === 'BB') {
            $tasa = 18.0;
        } elseif ($perfilRiesgo === 'CC') {
            $tasa = 20.0;
        } else {
            $tasa = 30.0; // tasa por defecto si el perfil no es reconocido
        }

        return $tasa/100;
    }

    

    public function automaticostore(Request $request)
    {

        $request->validate([
            'monto' => 'required|numeric',
            'plazo' => 'required|integer|min:1',
            'fecha_inicio' => 'required|date',
            'perfil_riesgo' => 'required|string', // Puedes ajustar si usas un enum o valores fijos
            'termsycond' =>  'required',
        ]);

        Prestamoautomatico::create([
            'monto' => $request->monto,
            'plazo' => $request->plazo,
            'fecha_inicio' => $request->fecha_inicio,
            'perfil_riesgo' => $request->perfil_riesgo,
            'estado' => 'Solicitado',
            // 'user_id' => auth()->id(), // si usas autenticación
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('prestamo.indexautomatico')->with('success', 'Préstamo solicitado con éxito.');
    }

    public function store(Request $request)
    {

        $request->validate([
            'monto' => 'required|numeric',
            'plazo' => 'required|integer|min:1',
            'fecha_inicio' => 'required|date',
            'perfil_riesgo' => 'required|string', // Puedes ajustar si usas un enum o valores fijos
        ]);

        Prestamo::create([
            'monto' => $request->monto,
            'plazo' => $request->plazo,
            'fecha_inicio' => $request->fecha_inicio,
            'perfil_riesgo' => $request->perfil_riesgo,
            'estado' => 'Solicitado',
            // 'user_id' => auth()->id(), // si usas autenticación
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('prestamo.index')->with('success', 'Préstamo solicitado con éxito.');
    }

    // PrestamoController.php

    public function simular(Request $request)
    {
        $request->validate([
            'monto' => 'required|numeric',
            'plazo' => 'required|integer',
            'fecha_inicio' => 'required|date',
            'perfil_riesgo' => 'required', // Ej: XX por fecto -> tasa 15%
        ]);


    $monto = $request->monto;
    $plazo = $request->plazo;
    $tasaAnual = $this->calcularTasa($request->perfil_riesgo);
    $fechaInicio = \Carbon\Carbon::parse($request->fecha_inicio);

    // Convertir tasa anual a mensual
    $tasaMensual = $tasaAnual / 12;

    // Calcular cuota mensual con interés
    $cuotaMensual = round(
        ($monto * $tasaMensual) / (1 - pow(1 + $tasaMensual, -$plazo)),
        2
    );

    $saldoPendiente = $monto;

    $cronograma = [];

    for ($i = 1; $i <= $plazo; $i++) { 
    $interes = round($saldoPendiente * $tasaMensual, 2);
    
    // Ajuste en la última cuota
    if ($i == $plazo) {
        $amortizacion = round($saldoPendiente, 2);
        $cuota = round($interes + $amortizacion, 2);
        $saldoRestante = 0.00;
    } else {
        $amortizacion = round($cuotaMensual - $interes, 2);
        $cuota = $cuotaMensual;
        $saldoRestante = round($saldoPendiente - $amortizacion, 2);
    }

    $fechaPago = $fechaInicio->copy()->addMonths($i)->format('Y-m-d');

    $cronograma[] = [
        'nro_cuota' => $i,
        'fecha_pago' => $fechaPago,
        'monto' => $cuota,
        'interes' => $interes,
        'amortizacion' => $amortizacion,
        'saldo_restante' => $saldoRestante,
    ];

    $saldoPendiente -= $amortizacion;
    }



    return view('prestamo.simulacion', compact('monto', 'plazo', 'cuotaMensual', 'cronograma', 'tasaAnual'));
    }


    public function simularautomatico(Request $request)
    {
        $request->validate([
            'monto' => 'required|numeric',
            'plazo' => 'required|integer',
            'fecha_inicio' => 'required|date',
            'perfil_riesgo' => 'required', // Ej: XX por fecto -> tasa 15%
            'termsycond' =>  'required',
        ]);


    $monto = $request->monto;
    $plazo = $request->plazo;
    $tasaAnual = $this->calcularTasa($request->perfil_riesgo);
    $fechaInicio = \Carbon\Carbon::parse($request->fecha_inicio);
    $termsycond = $request->termsycond;
    // Convertir tasa anual a mensual
    $tasaMensual = $tasaAnual / 12;

    // Calcular cuota mensual con interés
    $cuotaMensual = round(
        ($monto * $tasaMensual) / (1 - pow(1 + $tasaMensual, -$plazo)),
        2
    );

    $saldoPendiente = $monto;

    $cronograma = [];

    for ($i = 1; $i <= $plazo; $i++) { 
    $interes = round($saldoPendiente * $tasaMensual, 2);
    
    // Ajuste en la última cuota
    if ($i == $plazo) {
        $amortizacion = round($saldoPendiente, 2);
        $cuota = round($interes + $amortizacion, 2);
        $saldoRestante = 0.00;
    } else {
        $amortizacion = round($cuotaMensual - $interes, 2);
        $cuota = $cuotaMensual;
        $saldoRestante = round($saldoPendiente - $amortizacion, 2);
    }

    $fechaPago = $fechaInicio->copy()->addMonths($i)->format('Y-m-d');

    $cronograma[] = [
        'nro_cuota' => $i,
        'fecha_pago' => $fechaPago,
        'monto' => $cuota,
        'interes' => $interes,
        'amortizacion' => $amortizacion,
        'saldo_restante' => $saldoRestante,
    ];

    $saldoPendiente -= $amortizacion;
    }



    return view('prestamo.simulacionautomatico', compact('monto', 'plazo', 'cuotaMensual', 'cronograma', 'tasaAnual'));
    }

    

    public function aprobar($id)
    {
        $prestamo = Prestamo::findOrFail($id);
        $prestamo->estado = 'Aprobado';
        $prestamo->save();

         // Sumar el monto al dinero_digital del usuario
        $user = $prestamo->user;
        $user->dinero_credito += $prestamo->monto;
        
        $user->save();

        return redirect()->route('prestamo.tramitar')->with('success', 'Préstamo aprobado.');
    }

    public function rechazar($id)
    {
        $prestamo = Prestamo::findOrFail($id);
        $prestamo->estado = 'Rechazado';
        $prestamo->save();

        return redirect()->route('prestamo.tramitar')->with('success', 'Préstamo rechazado.');
    }
}