<?php

declare(strict_types=1);

namespace App\Almacenamiento;

/**
 * Guarda el carrito en la variable de sesión $_SESSION['carrito'].
 * No usa base de datos.
 */
final class AlmacenSesion implements AlmacenamientoCarrito
{
    public function __construct(private readonly string $clave = 'carrito')
    {
        if (!isset($_SESSION[$this->clave]) || !is_array($_SESSION[$this->clave])) {
            $_SESSION[$this->clave] = [];
        }
    }

    public function leer(): array
    {
        return $_SESSION[$this->clave];
    }

    public function guardar(array $items): void
    {
        $_SESSION[$this->clave] = $items;
    }

    public function limpiar(): void
    {
        $_SESSION[$this->clave] = [];
    }
}
