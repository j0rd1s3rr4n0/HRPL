<?php
error_reporting(0);
session_start();

// Configuración de la base de datos MySQL
require('environtment_loader.php');
// Crear una conexión a la base de datos MySQL
$conn = new mysqli($servername, $db_username, $db_password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

$ip_options = array();

// Consulta para obtener la lista de IPs disponibles
$query = "SELECT DISTINCT ip FROM ubicaciones";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $ip_options[] = $row['ip'];
    }
}

if (isset($_POST['selected_ip'])) {
    $selected_ip = $_POST['selected_ip'];

    // Consulta para obtener las ubicaciones asociadas con la IP seleccionada
    $query = "SELECT latitud, longitud, hora FROM ubicaciones WHERE ip = ? ORDER BY timestamp";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $selected_ip);
    $stmt->execute();
    $result = $stmt->get_result();

    $locations = array();

    while ($row = $result->fetch_assoc()) {
        $locations[] = $row;
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Historial de Ubicaciones por IP</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        /* Estilos del mapa y contenedor */
        #map {
            height: 500px;
        }
    </style>
</head>
<body>
    <h1>Historial de Ubicaciones por IP</h1>
    <form method="POST" action="">
        <label for="selected_ip">Selecciona una IP:</label>
        <select name="selected_ip" required>
            <?php foreach ($ip_options as $ip) : ?>
                <option value="<?php echo $ip; ?>"><?php echo $ip; ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Mostrar Historial</button>
    </form>

    <?php if (isset($locations)) : ?>
        <h2>Historial de Ubicaciones para IP: <?php echo $selected_ip; ?></h2>
        <div id="map"></div>
        <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
        <script>
            var map = L.map('map').setView([0, 0], 2);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

            var locations = <?php echo json_encode($locations); ?>;

            var polyline = L.polyline([], { color: 'blue' }).addTo(map);

            locations.forEach(function (location) {
                var lat = parseFloat(location.latitud);
                var lon = parseFloat(location.longitud);
                var time = location.hora;

                L.marker([lat, lon]).addTo(map)
                    .bindPopup('Hora: ' + time);

                polyline.addLatLng([lat, lon]);
            });

            map.fitBounds(polyline.getBounds());
        </script>
    <?php endif; ?>

</body>
</html>
