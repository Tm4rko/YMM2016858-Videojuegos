<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];

    $query = "INSERT INTO juegos_fisicos (nombre, descripcion, precio, stock) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssdi", $nombre, $descripcion, $precio, $stock);

    if ($stmt->execute()) {
        header("Location: listar_juegos.php");
    } else {
        echo "Error al crear el juego: " . $conn->error;
    }
}
?>
<form method="POST">
    <input type="text" name="nombre" placeholder="Nombre" required>
    <textarea name="descripcion" placeholder="Descripción" required></textarea>
    <input type="number" step="0.01" name="precio" placeholder="Precio" required>
    <input type="number" name="stock" placeholder="Stock" required>
    <button type="submit">Crear</button>
</form>
