<?php

declare(strict_types=1);

/**
 * Autoloader PSR-4 simple para el espacio de nombres App\.
 * Mapea App\Modelo\Producto  ->  src/Modelo/Producto.php
 */
spl_autoload_register(static function (string $clase): void {
    $prefijo = 'App\\';
    if (!str_starts_with($clase, $prefijo)) {
        return;
    }

    $relativa = substr($clase, strlen($prefijo));
    $ruta = __DIR__ . '/' . str_replace('\\', '/', $relativa) . '.php';

    if (is_file($ruta)) {
        require $ruta;
    }
});
