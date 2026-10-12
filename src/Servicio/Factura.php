<?php

declare(strict_types=1);

namespace App\Servicio;

use App\Config;
use App\Modelo\Carrito;
use App\Modelo\Catalogo;
use App\Modelo\Producto;

/**
 * Servicio que construye la factura a partir del carrito y el catálogo.
 */
final class Factura
{
    /** @var array<int, array{producto: Producto, cantidad: int, subtotal: float}> */
    private array $lineas = [];

    private float $subtotal = 0.0;

    public function __construct(
        private readonly Carrito $carrito,
        private readonly Catalogo $catalogo,
    ) {
        $this->calcular();
    }

    private function calcular(): void
    {
        foreach ($this->carrito->items() as $id => $cantidad) {
            $producto = $this->catalogo->buscar($id);
            if ($producto === null) {
                continue;
            }

            $subtotal = $producto->subtotal($cantidad);
            $this->lineas[] = [
                'producto' => $producto,
                'cantidad' => $cantidad,
                'subtotal' => $subtotal,
            ];
            $this->subtotal += $subtotal;
        }
    }

    /** @return array<int, array{producto: Producto, cantidad: int, subtotal: float}> */
    public function lineas(): array
    {
        return $this->lineas;
    }

    public function subtotal(): float
    {
        return $this->subtotal;
    }

    public function iva(): float
    {
        return $this->subtotal * Config::IVA;
    }

    public function total(): float
    {
        return $this->subtotal + $this->iva();
    }

    public function estaVacia(): bool
    {
        return $this->lineas === [];
    }
}
