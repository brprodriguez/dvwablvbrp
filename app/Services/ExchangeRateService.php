<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class ExchangeRateService
{
    public function getRates()
    {
        $cacheKey = 'exchange_rates_' . date('Y_m_d');

        return Cache::remember($cacheKey, 86400, function () {
            return [
                'USD' => $this->randomFloat(3.0, 3.9),
                'EUR' => $this->randomFloat(4.0, 4.5),
                'SOL' => 1.0,
            ];
        });
    }

    private function randomFloat($min, $max)
    {
        return round(mt_rand($min * 100, $max * 100) / 100, 2);
    }
}
