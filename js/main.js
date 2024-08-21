document.addEventListener('DOMContentLoaded', function() {
    // Función para calcular el cambio en el recibo
    var pagoInput = document.getElementById('pago');
    if (pagoInput) {
        pagoInput.addEventListener('input', function() {
            var pago = parseFloat(this.value);
            var total = parseFloat(document.getElementById('total').innerText.replace('$', ''));
            var cambioElement = document.getElementById('cambio');

            if (pago >= total) {
                cambioElement.innerText = '$' + (pago - total).toFixed(2);
            } else {
                cambioElement.innerText = 'Monto insuficiente';
            }
        });
    }

    // Otros scripts que puedas necesitar...
});
