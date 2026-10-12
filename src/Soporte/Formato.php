<?php

declare(strict_types=1);

namespace App\Soporte;

use App\Config;

/**
 * Utilidades de formato para mostrar valores en las vistas.
 */
final class Formato
{
    public static function precio(float $valor): string
    {
        return Config::MONEDA . ' ' . number_format($valor, 2, ',', '.');
    }

    public static function porcentaje(float $tasa): string
    {
        return number_format($tasa * 100, 0, ',', '.') . ' %';
    }
}
