<?php

use App\Config;
use App\Soporte\Formato;

/** @var \App\Modelo\Catalogo $catalogo */
/** @var \App\Modelo\Carrito $carrito */
/** @var \App\Servicio\Factura $factura */

require __DIR__ . '/parciales/cabecera.php';
?>
<main class="wrap">
    <div class="layout">
        <section>
            <h2>Nuestro catálogo</h2>
            <p class="sub">Elige tus productos favoritos y agrégalos al carrito.</p>

            <div class="grid">
                <?php foreach ($catalogo->todos() as $id => $p): ?>
                    <article class="card">
                        <div class="emoji"><?= $p->emoji() ?></div>
                        <h3><?= htmlspecialchars($p->nombre(), ENT_QUOTES, 'UTF-8') ?></h3>
                        <p><?= htmlspecialchars($p->descripcion(), ENT_QUOTES, 'UTF-8') ?></p>
                        <div class="precio"><?= Formato::precio($p->precio()) ?></div>
                        <form class="fila" method="post">
                            <input type="hidden" name="accion" value="agregar">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($id, ENT_QUOTES, 'UTF-8') ?>">
                            <input type="number" name="cantidad" value="1" min="1" max="99" aria-label="Cantidad">
                            <button class="btn btn-primario" type="submit">Agregar</button>
                        </form>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <aside class="carrito" id="carrito">
            <h2>Tu carrito</h2>
            <p class="sub"><?= (int) $carrito->totalArticulos() ?> artículo(s)</p>

            <?php if ($carrito->estaVacio()): ?>
                <div class="vacio">Aún no has agregado nada 🛒</div>
            <?php else: ?>
                <?php foreach ($factura->lineas() as $linea): ?>
                    <?php $p = $linea['producto']; $id = $p->id(); ?>
                    <div class="linea">
                        <div class="emoji"><?= $p->emoji() ?></div>
                        <div>
                            <div class="nombre"><?= htmlspecialchars($p->nombre(), ENT_QUOTES, 'UTF-8') ?></div>
                            <div class="unitario"><?= Formato::precio($p->precio()) ?> c/u</div>
                            <form method="post" class="acciones">
                                <input type="hidden" name="accion" value="actualizar">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($id, ENT_QUOTES, 'UTF-8') ?>">
                                <input type="number" name="cantidad" value="<?= (int) $linea['cantidad'] ?>" min="0" max="99" aria-label="Cantidad">
                                <button class="btn btn-suave" type="submit">↻</button>
                            </form>
                        </div>
                        <div style="text-align:right">
                            <div class="nombre"><?= Formato::precio($linea['subtotal']) ?></div>
                            <form method="post">
                                <input type="hidden" name="accion" value="eliminar">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($id, ENT_QUOTES, 'UTF-8') ?>">
                                <button class="quitar" type="submit" title="Quitar">✕</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>

                <div class="totales">
                    <div class="row"><span>Subtotal</span><span><?= Formato::precio($factura->subtotal()) ?></span></div>
                    <div class="row iva"><span>IVA (<?= Formato::porcentaje(Config::IVA) ?>)</span><span><?= Formato::precio($factura->iva()) ?></span></div>
                    <div class="row total"><span>Total</span><span><?= Formato::precio($factura->total()) ?></span></div>
                </div>

                <div style="display:grid; gap:.6rem; margin-top:1.2rem">
                    <a class="btn btn-primario btn-bloque" href="index.php?vista=factura">🧾 Ver factura</a>
                    <form method="post" onsubmit="return confirm('¿Vaciar el carrito?');">
                        <input type="hidden" name="accion" value="vaciar">
                        <button class="btn btn-suave btn-bloque" type="submit">Vaciar carrito</button>
                    </form>
                </div>
            <?php endif; ?>
        </aside>
    </div>
</main>
<?php require __DIR__ . '/parciales/pie.php'; ?>
