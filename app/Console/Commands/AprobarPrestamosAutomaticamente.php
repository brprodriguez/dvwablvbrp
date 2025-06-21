<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Prestamoautomatico;
use Carbon\Carbon;

class AprobarPrestamosAutomaticamente extends Command
{
    protected $signature = 'prestamos:revisar';
    protected $description = 'Revisa los préstamos y actualiza su estado según el tiempo transcurrido';

    public function handle()
    {
            $ahora = Carbon::now();
            $this->info("Hora Actual: {$ahora}");
       $prestamos = Prestamoautomatico::whereIn('estado', ['Solicitado', 'En proceso'])->get();


            foreach ($prestamos as $prestamo) {
                $diferencia = $prestamo->created_at->diffInMinutes($ahora);

                // Mostrar la fecha creación y diferencia de minutos
                $this->info("Préstamo ID: {$prestamo->id} - creado en: {$prestamo->created_at} - Diferencia: {$diferencia} minutos - Estado {$prestamo->estado}");

                if ($diferencia >= 5 && $diferencia < 6) {
                    $prestamo->estado = 'En proceso';
                    $prestamo->save();
                    $this->info("Estado cambiado a: En proceso");
                } elseif ($diferencia >= 6) {
                    $prestamo->estado = 'Aprobado';
                    $prestamo->save();

                     // Sumar el monto al dinero_digital del usuario
                    $user = $prestamo->user;
                    $user->dinero_credito += $prestamo->monto;
                    
                    $user->save();
                    $this->info("Estado cambiado a: Aprobado");
                }
            }

            $this->info('Estados de préstamos revisados correctamente.');
    }
}
