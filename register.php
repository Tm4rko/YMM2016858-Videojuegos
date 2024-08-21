<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = $_POST['email'];

    $query = "INSERT INTO usuarios (nombre_usuario, password, email) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $username, $password, $email);

    if ($stmt->execute()) {
        echo "Usuario registrado exitosamente";
    } else {
        echo "Error al registrar el usuario: " . $conn->error;
    }
}
?>
<?php include 'header.php'; ?>
<div class="container">
    <h2>Registro de Usuario</h2>
    <form method="POST">
        <input type="text" name="username" placeholder="Nombre de usuario" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <input type="email" name="email" placeholder="Email" required>
        <button type="submit">Registrar</button>
    </form>
</div>
