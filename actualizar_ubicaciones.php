<?php
error_reporting(0);


if($db_type=="mysql"){
    // Configuración de la base de datos MySQL
    require('environtment_loader.php');

    // Crear una conexión a la base de datos MySQL
    $conn = new mysqli($servername, $db_username, $db_password, $database);


    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error de conexión a la base de datos: " . $conn->connect_error);
    }

    // Seleccionar las ubicaciones más recientes por IP
    $query = "SELECT ip, latitud, longitud, hora
            FROM ubicaciones
            WHERE timestamp = (SELECT MAX(timestamp)
                                FROM ubicaciones AS u
                                WHERE u.ip = ubicaciones.ip)";

    $result = $conn->query($query);

    $ubicaciones = array();
    while ($row = $result->fetch_assoc()) {
        $ubicaciones[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($ubicaciones);

    // Cerrar la conexión a la base de datos
    $conn->close();
}elseif($db_type=="sqlite"){
    $databasePath = "$database.db";

    // Crear una conexión a la base de datos SQLite con PDO
    $conn = new PDO("sqlite:$databasePath");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Seleccionar las ubicaciones más recientes por IP
    $query = "SELECT ip, latitud, longitud, hora
            FROM ubicaciones
            WHERE timestamp = (SELECT MAX(timestamp)
                FROM ubicaciones AS u
                WHERE u.ip = ubicaciones.ip)";

    $result = $conn->query($query);

    $ubicaciones = array();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $ubicaciones[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($ubicaciones);

    // Cerrar la conexión a la base de datos
    $conn = null;

}elseif($db_type=="pgsql"){
    // Crear una conexión a la base de datos PostgreSQL con PDO
    $conn = new PDO("pgsql:host=$servername;port=$db_port;dbname=$database;user=$db_username;password=$db_password");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Seleccionar las ubicaciones más recientes por IP
    $query = "SELECT ip, latitud, longitud, hora
            FROM ubicaciones
            WHERE timestamp = (SELECT MAX(timestamp)
                FROM ubicaciones AS u
                WHERE u.ip = ubicaciones.ip)";

    $result = $conn->query($query);

    $ubicaciones = array();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $ubicaciones[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($ubicaciones);

    // Cerrar la conexión a la base de datos
    $conn = null;
}
?>
