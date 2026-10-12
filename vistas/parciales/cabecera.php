<?php
/** @var \App\Modelo\Carrito $carrito */
/** @var string|null $flash */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Casual — Carrito de compras</title>
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>
<body>

<header class="site-header">
    <a class="marca" href="index.php">🛍️ Tienda Casual</a>
    <a class="badge" href="index.php#carrito">🛒 <?= (int) $carrito->totalArticulos() ?> art.</a>
</header>

<?php if (!empty($flash)): ?>
    <div class="toast"><?= htmlspecialchars((string) $flash, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>
