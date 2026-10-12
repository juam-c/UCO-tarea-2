<?php

declare(strict_types=1);

namespace App\Modelo;

use InvalidArgumentException;

/**
 * Colección de productos. Se construye a partir de un arreglo de datos.
 */
final class Catalogo
{
    /** @var array<string, Producto> */
    private array $productos = [];

    /**
     * @param array<string, array{nombre: string, descripcion: string, precio: float|int, emoji: string}> $datos
     */
    public function __construct(array $datos)
    {
        foreach ($datos as $id => $fila) {
            foreach (['nombre', 'descripcion', 'precio', 'emoji'] as $campo) {
                if (!isset($fila[$campo])) {
                    throw new InvalidArgumentException("Falta el campo '$campo' del producto '$id'.");
                }
            }

            $this->productos[(string) $id] = new Producto(
                (string) $id,
                (string) $fila['nombre'],
                (string) $fila['descripcion'],
                (float) $fila['precio'],
                (string) $fila['emoji'],
            );
        }
    }

    /** @return array<string, Producto> */
    public function todos(): array
    {
        return $this->productos;
    }

    public function buscar(string $id): ?Producto
    {
        return $this->productos[$id] ?? null;
    }

    public function existe(string $id): bool
    {
        return isset($this->productos[$id]);
    }

    public function cantidad(): int
    {
        return count($this->productos);
    }
}
