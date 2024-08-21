
<?php
    require_once '../config/config.php';
    require_once '../app/controllers/EmpleadoController.php';

    //obtener la acción de la ruta
    $action = isset($_GET['action']) ? $_GET['action'] : 'index';

    // Instanciar el controlador
    $controller = new EmpleadoController();

    if (method_exists($controller, $action)) {
        $controller->$action();
    } else {
        echo "Método no encontrado: " . htmlspecialchars($action);
    }
?>
