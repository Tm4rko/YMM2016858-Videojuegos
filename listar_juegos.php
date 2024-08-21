<?php
include 'db.php';

$query = "SELECT * FROM juegos_fisicos";
$result = $conn->query($query);
?>

<table>
    <tr>
        <th>Nombre</th>
        <th>Descripción</th>
        <th>Precio</th>
        <th>Stock</th>
        <th>Acciones</th>
    </tr>
    <?php while($juego = $result->fetch_assoc()) { ?>
    <tr>
        <td><?= $juego['nombre'] ?></td>
        <td><?= $juego['descripcion'] ?></td>
        <td><?= $juego['precio'] ?></td>
        <td><?= $juego['stock'] ?></td>
        <td>
            <a href="editar_juego.php?id=<?= $juego['id'] ?>">Editar</a>
            <a href="eliminar_juego.php?id=<?= $juego['id'] ?>">Eliminar</a>
        </td>
    </tr>
    <?php } ?>
</table>
<a href="crear_juego.php">Agregar Juego</a>
