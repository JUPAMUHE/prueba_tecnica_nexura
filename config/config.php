<?php

// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'db_empleados');

// Configuración de rutas
define('BASE_URL', 'http://localhost/prueba_tecnica_nexura');
define('APP_PATH', realpath(dirname(__FILE__) . '/..'));
define('VIEW_PATH', APP_PATH . '/views/');
define('MODEL_PATH', APP_PATH . '/models/');
define('CONTROLLER_PATH', APP_PATH . '/controllers/');

// Configuración de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Otras configuraciones
define('APP_NAME', 'Empleados');

// Función para la conexión a la base de datos
function connectDB() {
    $connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($connection->connect_error) {
        die("Conexión fallida: " . $connection->connect_error);
    }

    return $connection;
}

