<?php
session_start();
include 'header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

echo "Bienvenido, " . $_SESSION['user_id'] . "!";

?>
<ul>
    <li><a href="listar_juegos.php">Juegos Físicos</a></li>
    <li><a href="orden_compra.php">Realizar Orden de Compra</a></li>
</ul>
