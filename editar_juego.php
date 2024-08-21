<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM juegos_fisicos WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $juego = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];

    $query = "UPDATE juegos_fisicos SET nombre = ?, descripcion = ?, precio = ?, stock = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssdii", $nombre, $descripcion, $precio, $stock, $id);

    if ($stmt->execute()) {
        header("Location: listar_juegos.php");
    } else {
        echo "Error al actualizar el juego: " . $conn->error;
    }
}
?>
<form method="POST">
    <input type="text" name="nombre" value="<?= $juego['nombre'] ?>" required>
    <textarea name="descripcion" required><?= $juego['descripcion'] ?></textarea>
    <input type="number" step="0.01" name="precio" value="<?= $juego['precio'] ?>" required>
    <input type="number" name="stock" value="<?= $juego['stock'] ?>" required>
    <button type="submit">Actualizar</button>
</form>
