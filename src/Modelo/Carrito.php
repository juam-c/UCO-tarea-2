<?php

declare(strict_types=1);

namespace App\Modelo;

use App\Almacenamiento\AlmacenamientoCarrito;

/**
 * Modelo del carrito de compras.
 * Solo conoce reglas de negocio; delega el guardado en AlmacenamientoCarrito.
 */
final class Carrito
{
    public const MAX_POR_PRODUCTO = 99;

    /** @var array<string, int> */
    private array $items;

    public function __construct(private readonly AlmacenamientoCarrito $almacen)
    {
        $this->items = $this->almacen->leer();
    }

    /** @return array<string, int> Mapa id_producto => cantidad. */
    public function items(): array
    {
        return $this->items;
    }

    public function estaVacio(): bool
    {
        return $this->items === [];
    }

    public function totalArticulos(): int
    {
        return array_sum($this->items);
    }

    /**
     * Suma una cantidad al producto. Devuelve la cantidad realmente agregada
     * (acotada al máximo permitido).
     */
    public function agregar(string $id, int $cantidad): int
    {
        $cantidad = max(1, min(self::MAX_POR_PRODUCTO, $cantidad));
        $this->items[$id] = ($this->items[$id] ?? 0) + $cantidad;
        $this->persistir();

        return $cantidad;
    }

    /**
     * Fija la cantidad de un producto. Si es <= 0, lo elimina.
     */
    public function actualizar(string $id, int $cantidad): void
    {
        if (!isset($this->items[$id])) {
            return;
        }

        if ($cantidad <= 0) {
            unset($this->items[$id]);
        } else {
            $this->items[$id] = min(self::MAX_POR_PRODUCTO, $cantidad);
        }

        $this->persistir();
    }

    public function eliminar(string $id): void
    {
        unset($this->items[$id]);
        $this->persistir();
    }

    public function vaciar(): void
    {
        $this->items = [];
        $this->almacen->limpiar();
    }

    private function persistir(): void
    {
        $this->almacen->guardar($this->items);
    }
}
