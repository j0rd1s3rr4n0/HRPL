<?php
error_reporting(0);
// Configuración de la base de datos MySQL
require('environment_loader.php');
// Crear una conexión a la base de datos MySQL
$conn = new mysqli($servername, $db_username, $db_password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $latitud = isset($_POST['latitud']) ? $_POST['latitud'] : '';
    $longitud = isset($_POST['longitud']) ? $_POST['longitud'] : '';
    $ip = isset($_POST['ip']) ? $_POST['ip'] : '';

    if (!empty($latitud) && !empty($longitud) && !empty($ip)) {
        // Obtener la hora actual y el timestamp
        $hora = date('H:i:s');
        $timestamp = time();

        // Verificar si la tabla 'ubicaciones' existe, y si no, crearla
        $createTableSQL = "CREATE TABLE IF NOT EXISTS ubicaciones (
            id INT AUTO_INCREMENT PRIMARY KEY,
            latitud DOUBLE,
            longitud DOUBLE,
            ip VARCHAR(255),
            hora TIME,
            timestamp INT
        )";

        if ($conn->query($createTableSQL) === TRUE) {
            // Insertar los datos en la tabla 'ubicaciones'
            $insertSQL = "INSERT INTO ubicaciones (latitud, longitud, ip, hora, timestamp) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insertSQL);
            $stmt->bind_param("ddssi", $latitud, $longitud, $ip, $hora, $timestamp);
            if ($stmt->execute()) {
                echo "Datos almacenados en la base de datos MySQL.";
            } else {
                echo "Error al insertar datos: " . $stmt->error;
            }
        } else {
            echo "Error al crear la tabla 'ubicaciones': " . $conn->error;
        }
        
        $stmt->close();
    } else {
        echo "Datos incompletos";
    }
} else {
    echo "Acceso denegado";
}

// Cerrar la conexión a la base de datos
$conn->close();

?>