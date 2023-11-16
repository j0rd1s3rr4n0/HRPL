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
} else {
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Ubicaciones en el Mapa</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        * {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            text-transform: uppercase;
        }
        @import url(https://fonts.googleapis.com/css?family=Major%20Mono%20Display);
        @import url(https://fonts.googleapis.com/css?family=Ballet);
        .logo{ font-family: 'Ballet'; } #map { height: 100vh; } /* Estilos del navbar */ .navbar { background-color: #191d20; color: #fff; padding: 10px 0; } .nav-list { list-style: none; padding: 0; display: flex; justify-content: space-around; } .nav-list li { margin: 0 10px; } .nav-list a { text-decoration: none; color: #fff; transition: color 0.3s; } .nav-list a:hover { color: #f0f0f0; } * { border: 0; padding: 0; margin: 0; } .logo { height: 20pt; filter: brightness(12.5); margin-top: 10pt; }
    </style>
</head>

<body>
    <nav class="navbar">
        <ul class="nav-list">
            <!--<li><img class="logo" src="img/geologo.png"></li>-->
            <li><h3 class="logo">GeoSpy</h3></li>
            <li><a href="generador_identificador.php">Generador de Identificador</a></li>
            <li><a href="vista.php">Vista GEO</a></li>
            <li><a href="vista_ip.php">Vista IP</a></li>
            <li><a href="cerrar_sesion.php">Cerrar Sesión</a></li>
        </ul>
    </nav>
    <div id="map"></div>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView([0, 0], 2); // Centro del mapa y nivel de zoom
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

        var markers = {}; // Almacena los marcadores por IP

        function actualizarMapa() {
            // Realiza una solicitud AJAX para obtener las ubicaciones más recientes por IP
            fetch('actualizar_ubicaciones.php')
                .then(function(response) {
                    return response.json();
                })
                .then(function(data) {
                    // Elimina los marcadores existentes del mapa
                    for (var ip in markers) {
                        map.removeLayer(markers[ip]);
                    }
                    markers = {};

                    // Agrega nuevos marcadores
                    data.forEach(function(entry) {
                        var marker = L.marker([entry.latitud, entry.longitud]).addTo(map);
                        markers[entry.ip] = marker;
                        marker.bindPopup('<b>UUID:</b>' + '' + '<br><b>IP:</b> ' + entry.ip + '<br><b>Hora:</b> ' + entry.hora + '<br> <a href="https://www.google.com/maps?q=' + entry.latitud + ',' + entry.longitud + '">GOOGLE MAPS</a>');
                    });
                })
                .catch(function(error) {
                    console.error("Error al actualizar el mapa:", error);
                });
        }

        actualizarMapa(); // Llama a la función al cargar la página
        setInterval(actualizarMapa, 20000); // Actualiza cada minuto (60000 ms)
    </script>
</body>

</html>
<?php
}
?>