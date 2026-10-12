<?php

declare(strict_types=1);

namespace App\Almacenamiento;

/**
 * Contrato de persistencia del carrito.
 * Permite cambiar la forma de guardar (sesión, archivo, etc.) sin tocar el modelo.
 */
interface AlmacenamientoCarrito
{
    /** @return array<string, int> Mapa id_producto => cantidad. */
    public function leer(): array;

    /** @param array<string, int> $items */
    public function guardar(array $items): void;

    public function limpiar(): void;
}
