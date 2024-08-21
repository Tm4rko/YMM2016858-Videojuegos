<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = $_SESSION['user_id'];
    $juegos = $_POST['juegos'];
    $total = 0;

    $conn->begin_transaction();
    try {
        $query = "INSERT INTO ordenes (id_usuario, total) VALUES (?, 0)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $id_orden = $stmt->insert_id;

        foreach ($juegos as $id_juego => $cantidad) {
            $query = "SELECT precio FROM juegos_fisicos WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $id_juego);
            $stmt->execute();
            $result = $stmt->get_result();
            $juego = $result->fetch_assoc();
            $precio_unitario = $juego['precio'];
            $subtotal = $precio_unitario * $cantidad;

            $query = "INSERT INTO detalles_orden (id_orden, id_juego, cantidad, precio_unitario) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("iiid", $id_orden, $id_juego, $cantidad, $precio_unitario);
            $stmt->execute();

            $total += $subtotal;
        }

        $query = "UPDATE ordenes SET total = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("di", $total, $id_orden);
        $stmt->execute();

        $conn->commit();
        header("Location: recibo.php?id_orden=$id_orden");
    } catch (Exception $e) {
        $conn->rollback();
        echo "Error al realizar la orden: " . $conn->error;
    }
}

$query = "SELECT * FROM juegos_fisicos";
$result = $conn->query($query);
?>

<form method="POST">
    <?php while($juego = $result->fetch_assoc()) { ?>
    <div>
        <label><?= $juego['nombre'] ?> - $<?= $juego['precio'] ?></label>
        <input type="number" name="juegos[<?= $juego['id'] ?>]" placeholder="Cantidad" min="0">
    </div>
    <?php } ?>
    <button type="submit">Realizar Orden</button>
</form>
