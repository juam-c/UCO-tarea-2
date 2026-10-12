// Pequeña mejora: si venimos de agregar un producto, bajamos hasta el carrito.
(function () {
    const vista = new URLSearchParams(location.search).get('vista');
    if (vista !== 'factura' && document.querySelector('.toast')) {
        document.getElementById('carrito')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
})();
