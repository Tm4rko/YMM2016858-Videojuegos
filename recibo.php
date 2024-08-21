<?php
include 'db.php';

if (isset($_GET['id_orden'])) {
    $id_orden = $_GET['id_orden'];

    $query = "SELECT ordenes.total, usuarios.nombre_usuario, detalles_orden.*, juegos_fisicos.nombre 
              FROM ordenes 
              JOIN usuarios ON ordenes.id_usuario = usuarios.id
              JOIN detalles_orden ON detalles_orden.id_orden = ordenes.id
              JOIN juegos_fisicos ON detalles_orden.id_juego = juegos_fisicos.id
              WHERE ordenes.id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_orden);
    $stmt->execute();
    $result = $stmt->get_result();

    $orden = $result->fetch_assoc();
    $total = $orden['total'];
    $nombre_usuario = $orden['nombre_usuario'];
}
?>

<h2>Recibo de Compra</h2>
<p>Usuario: <?= $nombre_usuario ?></p>
<table>
    <tr>
        <th>Juego</th>
        <th>Cantidad</th>
        <th>Precio Unitario</th>
        <th>Subtotal</th>
    </tr>
    <?php 
    $result->data_seek(0); // Reinicia el puntero del resultado
    while($detalle = $result->fetch_assoc()) { 
    ?>
    <tr>
        <td><?= $detalle['nombre'] ?></td>
        <td><?= $detalle['cantidad'] ?></td>
        <td><?= $detalle['precio_unitario'] ?></td>
        <td><?= $detalle['precio_unitario'] * $detalle['cantidad'] ?></td>
    </tr>
    <?php } ?>
    <tr>
        <th colspan="3">Total</th>
        <td><?= $total ?></td>
    </tr>
</table>

<p>Pago: <input type="number" id="pago" placeholder="Monto Pagado" required></p>
<p>Cambio: <span id="cambio"></span></p>

<script>
    document.getElementById('pago').addEventListener('input', function() {
        var pago = parseFloat(this.value);
        var total = <?= $total ?>;
        if (pago >= total) {
            document.getElementById('cambio').innerText = (pago - total).toFixed(2);
        } else {
            document.getElementById('cambio').innerText = 'Monto insuficiente';
        }
    });
</script>
