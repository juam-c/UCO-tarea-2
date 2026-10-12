<?php

declare(strict_types=1);

namespace App\Modelo;

/**
 * Entidad que representa un producto del catálogo.
 * Es inmutable: solo expone sus datos mediante getters.
 */
final class Producto
{
    public function __construct(
        private readonly string $id,
        private readonly string $nombre,
        private readonly string $descripcion,
        private readonly float $precio,
        private readonly string $emoji,
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function nombre(): string
    {
        return $this->nombre;
    }

    public function descripcion(): string
    {
        return $this->descripcion;
    }

    public function precio(): float
    {
        return $this->precio;
    }

    public function emoji(): string
    {
        return $this->emoji;
    }

    /** Precio del producto multiplicado por una cantidad. */
    public function subtotal(int $cantidad): float
    {
        return $this->precio * $cantidad;
    }
}
