<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CyberMaresme - Directory Listing Security</title>
    <style>
        body {
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
            padding: 20pt;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 10pt;
            overflow: hidden;
            transform: translateY(20pt);
            opacity: 0;
            transition: transform 0.5s ease-in-out, opacity 0.5s ease-in-out;
        }

        table.show {
            transform: translateY(0);
            opacity: 1;
        }

        td, th {
            padding: 10pt;
            text-align: left;
        }

        th {
            background-color: #428bca;
            color: #fff;
        }

        td {
            border: 1pt solid #e6e6e6;
        }

        img {
            max-height: 20pt;
            vertical-align: middle;
            margin-right: 10pt;
        }
        .card{
            display:none;
        }
/* Media query para dispositivos móviles */
		@media (max-width: 671px) {
			table.show {
	            display: none !important; /* Ocultar la tabla en dispositivos móviles */
	        }
			.card {
            	overflow: overlay !important; /* Agregar overflow: hidden */
                max-width: 90vw; /* Ancho máximo de 300 puntos */
                background-color: #f8f8f8;
                border: 1pt solid #e6e6e6;
                border-radius: 10pt;
                box-shadow: 0 4pt 6pt rgba(0, 0, 0, 0.1);
                margin: 0;
                padding: 20pt;
                /*transform: scale(0.95);*/
                opacity: 0;
                transition: transform 0.5s ease-in-out, opacity 0.5s ease-in-out, box-shadow 0.3s ease-in-out;
                color: #333;
                display:block;
            }
	        /* Establecer el contenedor de las tarjetas como un grid sin espacios en blanco */
	        .cards-container {
	            display: grid;
	            /*grid-template-columns: repeat(auto-fill, 1fr);*/
	            gap: 15pt; /* Espacio entre las tarjetas */
	            justify-items: center;
	        }	
			
		}

        /* Media query para dispositivos móviles */
        /* Media query para dispositivos móviles con un ancho mínimo de 700pt y máximo de 1400pt */
		@media (min-width: 672px) and (max-width: 1024px) {
            table.show {
                display: none !important; /* Ocultar la tabla en dispositivos móviles */
            }
			.card{
				display:block;
			}
            /* Establecer el contenedor de las tarjetas como un grid sin espacios en blanco */
            .cards-container {
            	width:90vw;
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(300pt, 1fr));
                gap:15pt; /* Espacio entre las tarjetas */
                justify-items: center;
                margin:10pt;
            }

            /* Estilos para las tarjetas en dispositivos móviles */
            .card {
            	overflow: overlay !important; /* Agregar overflow: hidden */
                max-width: 350pt; /* Ancho máximo de 300 puntos */
                background-color: #f8f8f8;
                border: 1pt solid #e6e6e6;
                border-radius: 10pt;
                box-shadow: 0 4pt 6pt rgba(0, 0, 0, 0.1);
                margin: 0;
                padding: 20pt;
                /*transform: scale(0.95);*/
                opacity: 0;
                transition: transform 0.5s ease-in-out, opacity 0.5s ease-in-out, box-shadow 0.3s ease-in-out;
                color: #333;
            }

            .card.show {
                transform: scale(1);
                opacity: 1;
                box-shadow: 0 6pt 10pt rgba(0, 0, 0, 0.2);
                transition-delay: 0.2s;
            }

            .card:hover {
                box-shadow: 0 8pt 12pt rgba(0, 0, 0, 0.3);
                transform: scale(1.02);
                transition: transform 0.3s ease-in-out, box-shadow 0.2s ease-in-out;
            }

            .card strong {
                color: #428bca;
            }
        }

    </style>
</head>
<body>
<h1>CyberMaresme - Directory Listing Security</h1>
<table class="show">
    <tr>
        <th>ID</th>
        <th>IP</th>
        <th>City</th>
        <th>Region</th>
        <th>Country</th>
        <th>Location</th>
        <th>Organization</th>
        <th>Postal</th>
        <th>Timezone</th>
        <th>User Agent</th>
        <th>Requested URL</th>
        <th>Timestamp</th>
    </tr>
    <?php
    
    require('environment_loader.php');
    
    
    $mysqli = new mysqli($servername, $db_username, $db_password, $database);

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    $sql = "SELECT * FROM user_info";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["user_ip"] . "</td>";
            echo "<td>" . $row["user_city"] . "</td>";
            echo "<td>" . $row["user_region"] . "</td>";
            echo "<td><img src='https://flagsapi.com/" . $row["user_country"] . "/flat/64.png'> " . $row["user_country"] . "</td>";
            echo '<td><a href="https://www.google.com/maps?q=' . $row["user_location"] . '">' . $row["user_location"] . '</a></td>';
            echo "<td>" . $row["user_organization"] . "</td>";
            echo "<td>" . $row["user_postal"] . "</td>";
            echo "<td>" . $row["user_timezone"] . "</td>";
            echo "<td>" . $row["user_user_agent"] . "</td>";
            echo "<td>" . $row["user_requested_url"] . "</td>";
            echo "<td>" . $row["timestamp"] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='12'>No hay datos disponibles.</td></tr>";
    }

    $mysqli->close();
    ?>
</table>

<div class="cards-container">
<?php
$mysqli = new mysqli("localhost", "root", "Jakarjk23!", "security");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$sql = "SELECT * FROM user_info";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='card show'>";
        echo "<strong>ID:</strong> " . $row["id"] . "<br>";
        echo "<strong>IP:</strong> " . $row["user_ip"] . "<br>";
        echo "<strong>City:</strong> " . $row["user_city"] . "<br>";
        echo "<strong>Region:</strong> " . $row["user_region"] . "<br>";
        echo "<strong>Country:</strong> <img src='https://flagsapi.com/" . $row["user_country"] . "/flat/64.png'> " . $row["user_country"] . "<br>";
        echo "<strong>Location:</strong> <a href='https://www.google.com/maps?q=" . $row["user_location"] . "'>" . $row["user_location"] . "</a><br>";
        echo "<strong>Organization:</strong> " . $row["user_organization"] . "<br>";
        echo "<strong>Postal:</strong> " . $row["user_postal"] . "<br>";
        echo "<strong>Timezone:</strong> " . $row["user_timezone"] . "<br>";
        echo "<strong>User Agent:</strong> " . $row["user_user_agent"] . "<br>";
        echo "<strong>Requested URL:</strong> " . $row["user_requested_url"] . "<br>";
        echo "<strong>Timestamp:</strong> " . $row["timestamp"] . "<br>";
        echo "</div>";
    }
} else {
    echo "No hay datos disponibles.";
}

$mysqli->close();
?>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelector("table").classList.add("show");
        var cards = document.querySelectorAll(".card");
        cards.forEach(function (card, index) {
            setTimeout(function () {
                card.classList.add("show");
            }, 200 * index);
        });
    })
</script>
</body>
</html>
