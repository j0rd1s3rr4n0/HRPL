<?php
// Conexin a la base de datos
require('environtment_loader.php');
$mysqli = new mysqli($servername, $db_username, $db_password, $database);
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Datos del usuario
$browser = $_SERVER['HTTP_USER_AGENT'];
$dateTime = date('Y-m-d G:i:s');
$clientIP = $_SERVER['HTTP_CLIENT_IP'] 
    ?? $_SERVER["HTTP_CF_CONNECTING_IP"]
    ?? $_SERVER['HTTP_X_FORWARDED'] 
    ?? $_SERVER['HTTP_X_FORWARDED_FOR'] 
    ?? $_SERVER['HTTP_FORWARDED'] 
    ?? $_SERVER['HTTP_FORWARDED_FOR'] 
    ?? $_SERVER['REMOTE_ADDR'] 
    ?? '0.0.0.0';
$clientIP = str_replace(":", "", $clientIP);

// Obtener la URL solicitada
$userRequestedURL = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

// Usar cURL para obtener datos de la API
$apiURL = "http://ip-api.com/json/" . $clientIP;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiURL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$apiResponse = curl_exec($ch);

if ($apiResponse) {
    $ipData = json_decode($apiResponse, true);

    // Datos del usuario
    $city = $ipData['city'];
    $region = $ipData['regionName'];
    $country = $ipData['countryCode'];
    $location = $ipData['lat'] . "," . $ipData['lon'];
    $organization = $ipData['isp'];
    $postal = $ipData['zip'];
    $timezone = $ipData['timezone'];

    // Consulta SQL
    $sql = "INSERT INTO user_info (user_ip, user_city, user_region, user_country, user_location, user_organization, user_postal, user_timezone, user_readme, user_user_agent, user_requested_url, timestamp) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Usar declaraciones preparadas para prevenir la inyección SQL
    $stmt = $mysqli->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssssssssssss", $clientIP, $city, $region, $country, $location, $organization, $postal, $timezone, $readme, $browser, $userRequestedURL, $dateTime);

        $readme = "https://ipinfo.io/missingauth"; // Puedes reemplazar esto con tu propio valor

        if ($stmt->execute()) {
            //echo "¡Información registrada exitosamente!";
        } else {
            //echo "Error al registrar la información en la base de datos: " . $stmt->error;
        }

        $stmt->close();
    } else {
        //echo "Error al preparar la declaración: " . $mysqli->error;
    }

    curl_close($ch);
} else {
    //echo "Error al obtener información de la API.";
}

$mysqli->close();
?>



<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html><head>
<title>404 Not Found</title>
</head><body>
<h1>Not Found</h1>
<p>The requested URL was not found on this server.</p>
</body></html>
