<?php
error_reporting(0);
session_start();

if (!isset($_SESSION['username'])) {
?>
<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html><head>
<title>404 Not Found</title>
</head><body>
<h1>Not Found</h1>
<p>The requested URL was not found on this server.</p>
</body></html>
<?php
}else{
// Verificar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $uuid = $_POST['uuid'];
    $nombre = $_POST['nombre'];

    try {
        // Configuración de la base de datos MySQL
        require('environment_loader.php');

        // Crear una conexión a la base de datos
        $conn = new mysqli($servername, $db_username, $db_password, $database);

        // Verificar si la conexión se estableció correctamente
        if ($conn->connect_error) {
            die("Error de conexión a la base de datos: " . $conn->connect_error);
        }

        // Insertar el identificador en la tabla 'identificadores'
        $query = "INSERT INTO identificadores (identificador, texto, timestamp, id_usuario) VALUES (?, ?, NOW(), ?)";
        $stmt = $conn->prepare($query);

        // Obtener el ID de usuario a partir del nombre de usuario
        $username = $_SESSION['username'];
        $user_query = "SELECT id FROM usuarios WHERE username = ?";
        $user_stmt = $conn->prepare($user_query);
        $user_stmt->bind_param("s", $username);
        $user_stmt->execute();
        $user_stmt->store_result();
        $user_stmt->bind_result($user_id);
        $user_stmt->fetch();

        // Bind de los parámetros y ejecución de la inserción
        $stmt->bind_param("ssi", $uuid, $nombre, $user_id);
        $stmt->execute();

        // Cerrar la conexión
        $stmt->close();
        $user_stmt->close();
        $conn->close();
        // Redirigir a la página de visualización de identificadores u otra acción adecuada.
        header('Location: generador_identificador.php?status=ok');
    } catch (Exception) {
        // Redirigir a la página de visualización de identificadores u otra acción adecuada.
        header('Location: generador_identificador.php?status=error');
    }


    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Generador de Identificador</title>
    <link rel="icon" type="image/png" href="/img/logo.png">
</head>
<style>
	@import url(https://fonts.googleapis.com/css?family=Major%20Mono%20Display);
	.logo{
		font-family: "Major Mono Display";
	}
</style>
<body>
<nav class="navbar">
        <ul class="nav-list">
        	<!--<li><img class="logo" src="img/logo.png"></li>-->
            <li><h3 class="logo">GeoSpy</h3></li>
            <li><a href="generador_identificador.php">Generador de Identificador</a></li>
            <li><a href="vista.php">Vista GEO</a></li>
            <li><a href="vista_ip.php">Vista IP</a></li>
            <li><a href="cerrar_sesion.php">Cerrar Sesión</a></li>
        </ul>
    </nav>
    <br>
    <h1>GENERAR UUID</h1>

    <h2></h2>
    <form method="POST" action="">
        <label for="uuid">UUID:</label>
        <input type="text" name="uuid" value="<?php echo str_replace(".", "-", uniqid(uniqid("", true), true),); ?>"><br>
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required><br>
        <?php
        if (isset($_GET['status'])) {
            if ($_GET['status'] == 'ok') {
                echo 'Identificador Añadido Correctamente!';
            } else {
                echo '<i style="color:red;">Error No se Añadio el Identificador!</i>';
            }
        }
        ?>
        <button type="submit">Generar Identificador</button>
    </form>
    <a href="cerrar_sesion.php">Cerrar Sesión</a>
</body>
<style>
    *{
        padding: 0;
        margin: 0;
        border: 0;
    }
    body {
        font-family: Arial, sans-serif;
        background-color: #33394a;
        margin: 0;
        padding: 0;
    }

    h1 {
        color: #fff;
        text-align: center;
        padding: 20px;
    }

    h2 {
        color: #fff;
        text-align: center;
        margin-top: 20px;
    }

    form {
        max-width: 400px;
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

    input[type="text"] {
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
        background-color: #191d20;
        color: #fff;
        border: none;
        border-radius: 3px;
        cursor: pointer;
    }

    button:hover {
        background-color: #606d7a;
    }

    a {
        display: block;
        margin: 20px auto;
        text-align: center;
        color: #fff;
        text-decoration: none;
    }

    a:hover {
        text-decoration:wavy;
        color:#fff;
        text-shadow: #fff 0.1pt 0.1pt;
    }




/* Estilos del navbar */
.navbar {
    background-color: #191d20;
    color: #fff;
    padding: 10px 0;
}

.nav-list {
    list-style: none;
    padding: 0;
    display: flex;
    justify-content: space-around;
}

.nav-list li {
    margin: 0 10px;
}

.nav-list a {
    text-decoration: none;
    color: #fff;
    transition: color 0.3s;
}

.nav-list a:hover {
    color: #f0f0f0;
}
.logo{
    height: 20pt;
    filter: brightness(12.5);
    margin-top: 10pt;
}
*{
    font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    text-transform: uppercase;
}
</style>

</html>
<?php
}
?>