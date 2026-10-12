<?php

declare(strict_types=1);

namespace App\Soporte;

use RuntimeException;

/**
 * Renderizador de vistas: incluye un archivo de /vistas con sus datos.
 */
final class Plantilla
{
    /**
     * @param array<string, mixed> $datos
     */
    public static function render(string $vista, array $datos = []): void
    {
        $archivo = dirname(__DIR__, 2) . '/vistas/' . $vista . '.php';

        if (!is_file($archivo)) {
            throw new RuntimeException("No existe la vista '$vista'.");
        }

        // Convierte las claves del arreglo en variables locales para la vista.
        extract($datos, EXTR_SKIP);

        require $archivo;
    }
}
