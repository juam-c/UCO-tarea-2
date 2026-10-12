<?php

declare(strict_types=1);

use App\Almacenamiento\AlmacenSesion;
use App\Modelo\Carrito;
use App\Modelo\Catalogo;
use App\Servicio\Factura;
use App\Soporte\Plantilla;

require __DIR__ . '/src/Autoload.php';

session_start();

/* ---------- Composición de dependencias ---------- */
$catalogo = new Catalogo(require __DIR__ . '/datos/productos.php');
$carrito  = new Carrito(new AlmacenSesion());

/* ---------- Controlador: acciones del carrito (POST) ---------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion   = (string) ($_POST['accion'] ?? '');
    $id       = (string) ($_POST['id'] ?? '');
    $cantidad = (int) ($_POST['cantidad'] ?? 1);

    switch ($accion) {
        case 'agregar':
            if ($catalogo->existe($id)) {
                $agregada = $carrito->agregar($id, $cantidad);
                $producto = $catalogo->buscar($id);
                $_SESSION['flash'] = 'Agregaste ' . $agregada . ' × ' . $producto->nombre();
                if (!isset($_SESSION['factura_numero'])) {
                    $_SESSION['factura_numero'] = 'FAC-' . date('Ymd') . '-' .
                        str_pad((string) random_int(1, 9999), 4, '0', STR_PAD_LEFT);
                    $_SESSION['factura_fecha'] = date('d/m/Y H:i');
                }
            } else {
                $_SESSION['flash'] = 'Ese producto no existe.';
            }
            break;

        case 'actualizar':
            $carrito->actualizar($id, $cantidad);
            break;

        case 'eliminar':
            $carrito->eliminar($id);
            break;

        case 'vaciar':
            $carrito->vaciar();
            $_SESSION['flash'] = 'El carrito quedó vacío.';
            break;
    }

    // Al vaciarse el carrito se reinicia la numeración de la factura.
    if ($carrito->estaVacio()) {
        unset($_SESSION['factura_numero'], $_SESSION['factura_fecha']);
    }

    // Patrón Post/Redirect/Get: recargar no reenvía el formulario.
    $vista = isset($_GET['vista']) ? '?vista=' . urlencode((string) $_GET['vista']) : '';
    header('Location: index.php' . $vista);
    exit;
}

/* ---------- Datos que consume la vista ---------- */
$verFactura = ($_GET['vista'] ?? '') === 'factura';
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

Plantilla::render($verFactura ? 'factura' : 'tienda', [
    'catalogo' => $catalogo,
    'carrito'  => $carrito,
    'factura'  => new Factura($carrito, $catalogo),
    'flash'    => $flash,
    'numero'   => $_SESSION['factura_numero'] ?? null,
    'fecha'    => $_SESSION['factura_fecha'] ?? null,
]);
