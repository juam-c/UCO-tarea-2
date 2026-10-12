<?php

use App\Config;
use App\Soporte\Formato;

/** @var \App\Servicio\Factura $factura */
/** @var string|null $numero */
/** @var string|null $fecha */

require __DIR__ . '/parciales/cabecera.php';
?>
<main class="wrap">
    <?php if ($factura->estaVacia()): ?>
        <div class="factura" style="text-align:center">
            <h2>Tu factura está vacía 🧾</h2>
            <p class="sub">Agrega productos al carrito para generarla.</p>
            <a class="btn btn-primario btn-bloque" href="index.php">Volver a la tienda</a>
        </div>
    <?php else: ?>
        <div class="factura">
            <header>
                <div>
                    <h2>Factura de venta</h2>
                    <div class="sub">Gracias por tu compra ☺</div>
                </div>
                <div class="meta">
                    <div><strong><?= htmlspecialchars((string) $numero, ENT_QUOTES, 'UTF-8') ?></strong></div>
                    <div><?= htmlspecialchars((string) $fecha, ENT_QUOTES, 'UTF-8') ?></div>
                </div>
            </header>

            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th class="num">Precio</th>
                        <th class="num">Cant.</th>
                        <th class="num">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($factura->lineas() as $linea): $p = $linea['producto']; ?>
                        <tr>
                            <td><?= $p->emoji() . ' ' . htmlspecialchars($p->nombre(), ENT_QUOTES, 'UTF-8') ?></td>
                            <td class="num"><?= Formato::precio($p->precio()) ?></td>
                            <td class="num"><?= (int) $linea['cantidad'] ?></td>
                            <td class="num"><?= Formato::precio($linea['subtotal']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="resumen">
                <div class="row"><span>Subtotal</span><span><?= Formato::precio($factura->subtotal()) ?></span></div>
                <div class="row"><span>IVA (<?= Formato::porcentaje(Config::IVA) ?>)</span><span><?= Formato::precio($factura->iva()) ?></span></div>
                <div class="row total"><span>Total</span><span><?= Formato::precio($factura->total()) ?></span></div>
            </div>

            <div class="acciones-factura">
                <a class="btn btn-suave" href="index.php">← Seguir comprando</a>
                <button class="btn btn-teal" onclick="window.print()">🖨️ Imprimir factura</button>
                <form method="post" onsubmit="return confirm('¿Vaciar el carrito?');">
                    <input type="hidden" name="accion" value="vaciar">
                    <button class="btn btn-suave" type="submit">Vaciar carrito</button>
                </form>
            </div>
        </div>
    <?php endif; ?>
</main>
<?php require __DIR__ . '/parciales/pie.php'; ?>
