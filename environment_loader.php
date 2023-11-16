<?php
    // Ruta al archivo .env (ajusta la ruta según la ubicación de tu archivo .env)
    $envFilePath = __DIR__ . '/.env';

    // Comprueba si el archivo .env existe
    if (file_exists($envFilePath)) {
        // Lee las variables de entorno desde el archivo .env
        $envVariables = parse_ini_file($envFilePath, false, INI_SCANNER_RAW);

        if ($envVariables !== false) {
            // Define las variables de entorno en el entorno actual
            foreach ($envVariables as $key => $value) {
                putenv("$key=$value");
                $_ENV[$key] = $value;
                $_SERVER[$key] = $value;
            }
        } else {
            // Maneja el error si no se pudieron cargar las variables de entorno
            die('No se pudieron cargar las variables de entorno desde el archivo .env.');
        }
    } else {
        // Maneja el error si el archivo .env no existe
        die('El archivo .env no se encontró en la ubicación especificada.');
    }
    
    $db_type = $_ENV['DB_TYPE'];
    $servername = $_ENV['DB_HOST'];
    $db_port = $_ENV['DB_PORT'];
    
    $db_prefix = $_ENV['DB_PREFIX'];
    $database = $db_prefix.$_ENV['DB_NAME'];
    $db_engine = $_ENV["DB_ENGINE"];
    $db_charset = $_ENV["DB_CHARSET"];
    $db_collation = $_ENV["DB_COLLATION"];

    $db_username = $_ENV['DB_USER'];
    $db_password = $_ENV['DB_PASSWORD'];
?>
