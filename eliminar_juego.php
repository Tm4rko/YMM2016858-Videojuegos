<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM juegos_fisicos WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: listar_juegos.php");
    } else {
        echo "Error al eliminar el juego: " . $conn->error;
    }
}
?>
