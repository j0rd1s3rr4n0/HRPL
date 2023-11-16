<?php
require('environment_loader.php');

if ($db_type == "mysql") {
    try {
        $conn = new PDO("mysql:host=$servername;port=$db_port;", $db_username, $db_password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "
        SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';
        START TRANSACTION;
        SET time_zone = '+00:00';

        CREATE DATABASE IF NOT EXISTS `$database` DEFAULT CHARACTER SET $db_charset COLLATE $db_collation;
        USE `$database`;

        DROP TABLE IF EXISTS `identificadores`;
        CREATE TABLE IF NOT EXISTS `identificadores` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `identificador` varchar(255) NOT NULL,
            `texto` text NOT NULL,
            `timestamp` timestamp NULL DEFAULT NULL,
            `id_usuario` int(11) DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `id_usuario` (`id_usuario`)
        ) ENGINE=$db_engine AUTO_INCREMENT=0 DEFAULT CHARSET=$db_charset COLLATE=$db_collation;

        DROP TABLE IF EXISTS `ubicaciones`;
        CREATE TABLE IF NOT EXISTS `ubicaciones` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `latitud` double DEFAULT NULL,
            `longitud` double DEFAULT NULL,
            `ip` varchar(255) DEFAULT NULL,
            `hora` time DEFAULT NULL,
            `timestamp` int(11) DEFAULT NULL,
            `identificator` int(11) DEFAULT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=$db_engine AUTO_INCREMENT=0 DEFAULT CHARSET=$db_charset COLLATE=$db_collation;

        DROP TABLE IF EXISTS `usuarios`;
        CREATE TABLE IF NOT EXISTS `usuarios` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `username` varchar(255) NOT NULL,
            `password` varchar(255) NOT NULL,
            `timestamp_last_login` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=$db_engine AUTO_INCREMENT=100 DEFAULT CHARSET=$db_charset COLLATE=$db_collation;

        INSERT INTO `usuarios` (`id`, `username`, `password`, `timestamp_last_login`) VALUES
            (1, 'ROOT', 'TOOR', NULL);

        ALTER TABLE `identificadores`
            ADD CONSTRAINT `identificadores_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

        COMMIT;
    ";

        $conn->exec($sql);

        echo "Base de datos y tablas creadas correctamente";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}elseif($db_type=="sqlite"){
    try {
        $conn = new PDO("sqlite:geolocate.db");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $sql = "
            CREATE TABLE IF NOT EXISTS identificadores (
                id INTEGER PRIMARY KEY,
                identificador TEXT NOT NULL,
                texto TEXT NOT NULL,
                timestamp TEXT NULL,
                id_usuario INTEGER DEFAULT NULL,
                FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
            );
    
            CREATE TABLE IF NOT EXISTS ubicaciones (
                id INTEGER PRIMARY KEY,
                latitud REAL DEFAULT NULL,
                longitud REAL DEFAULT NULL,
                ip TEXT DEFAULT NULL,
                hora TEXT DEFAULT NULL,
                timestamp INTEGER DEFAULT NULL,
                identificator INTEGER DEFAULT NULL,
                FOREIGN KEY (identificator) REFERENCES identificadores(id)
            );
    
            CREATE TABLE IF NOT EXISTS usuarios (
                id INTEGER PRIMARY KEY,
                username TEXT NOT NULL,
                password TEXT NOT NULL,
                timestamp_last_login TEXT NULL
            );
    
            INSERT INTO usuarios (id, username, password, timestamp_last_login) VALUES
                (1, 'ROOT', 'TOOR', NULL);
        ";
    
        $conn->exec($sql);
    
        echo "Base de datos y tablas creadas correctamente";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    
    $conn = null;
    
}elseif($db_type=="pgsql"){
    try {
        $conn = new PDO("pgsql:host=$servername;port=$db_port;", $db_username, $db_password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        // Crear la base de datos si no existe
        $conn->exec("CREATE DATABASE $database");
    
        // Conectarse a la base de datos recién creada
        $conn->exec("USE $database");
    
        $sql = "
            CREATE TABLE IF NOT EXISTS identificadores (
                id SERIAL PRIMARY KEY,
                identificador VARCHAR(255) NOT NULL,
                texto TEXT NOT NULL,
                timestamp TIMESTAMP NULL,
                id_usuario INT DEFAULT NULL,
                CONSTRAINT fk_id_usuario FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
            );
    
            CREATE TABLE IF NOT EXISTS ubicaciones (
                id SERIAL PRIMARY KEY,
                latitud DOUBLE PRECISION DEFAULT NULL,
                longitud DOUBLE PRECISION DEFAULT NULL,
                ip VARCHAR(255) DEFAULT NULL,
                hora TIME DEFAULT NULL,
                timestamp INT DEFAULT NULL,
                identificator INT DEFAULT NULL,
                CONSTRAINT fk_identificator FOREIGN KEY (identificator) REFERENCES identificadores(id)
            );
    
            CREATE TABLE IF NOT EXISTS usuarios (
                id SERIAL PRIMARY KEY,
                username VARCHAR(255) NOT NULL,
                password VARCHAR(255) NOT NULL,
                timestamp_last_login TIMESTAMP NULL
            );
    
            INSERT INTO usuarios (id, username, password, timestamp_last_login) VALUES
                (1, 'ROOT', 'TOOR', NULL);
        ";
    
        $conn->exec($sql);
    
        echo "Base de datos y tablas creadas correctamente";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    
    $conn = null;
}
