<?php

require_once '../app/models/Empleado.php';

class EmpleadoController {
    private $empleadoModel;

    public function __construct() {
        $this->empleadoModel = new Empleado();
    }

    public function index() {
        $empleados = $this->empleadoModel->getAll();
        $areas = $this->empleadoModel->getAreas();
        $roles = $this->empleadoModel->getRoles();
   
        $data = [
            'empleados' => $empleados,
            'areas' => $areas,
            'roles' => $roles
        ];

        $this->loadView('index', $data);
    }

    public function store() {
 
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         
            $this->empleadoModel->nombre = trim($_POST['nombre']);
            $this->empleadoModel->email = trim($_POST['email']);
            $this->empleadoModel->sexo = trim($_POST['sexo']);
            $this->empleadoModel->area = trim($_POST['area']);
            $this->empleadoModel->descripcion = trim($_POST['descripcion']);
            $this->empleadoModel->boletin = isset($_POST['boletin']) ? 1 : 0;
            $roles = isset($_POST['roles']) ? $_POST['roles'] : [];

            $errors = [];
   
            if (empty($this->empleadoModel->nombre) || !preg_match('/^[\p{L}\s]{2,}$/u', $this->empleadoModel->nombre)) {
                $errors[] = 'Nombre inválido. Debe tener al menos 2 caracteres y solo letras.';
            }

            if (empty($this->empleadoModel->email) || !filter_var($this->empleadoModel->email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Correo electrónico inválido.';
            }

            if (empty($this->empleadoModel->area)) {
                $errors[] = 'Debe seleccionar un área.';
            }

            if (empty($roles)) {
                $errors[] = 'Debe seleccionar al menos un rol.';
            }

            if (empty($this->empleadoModel->descripcion)) {
                $errors[] = 'Debe ingresar una descripción.';
            }
            
            if (!empty($errors)) {
                echo json_encode(['success' => false, 'errors' => implode('<br>', $errors)]);
                exit;
            }   

      
            if($_POST['empleado_edit']==0) {
                if ($this->empleadoModel->create()) {
                    $empleado_id = $this->empleadoModel->getLastInsertId();
                    $this->empleadoModel->assignRoles($empleado_id, $roles);
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'errors' => 'Error al crear el empleado.']);
                }
            }else{
                if ($this->empleadoModel->edit()) {
                    $this->empleadoModel->assignRolesEdit($_POST['empleado_edit'], $roles);
                    echo json_encode(['success_edit' => true]);
                } else {
                    echo json_encode(['success_edit' => false, 'errors' => 'Error al crear el empleado.']);
                }
            }

           
        } else {
            echo json_encode(['success' => false, 'errors' => 'Solicitud inválida.']);
        }
    }

    public function edit() {
        $id = $_GET['id'];
        $empleado = $this->empleadoModel->getEmpleadoById($id);
        if ($empleado) {
            echo json_encode([
                'success' => true,
                'data' => $empleado
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Empleado no encontrado'
            ]);
        }
    }

    public function delete() {
        $id = $_GET['id'];
        $empleado = $this->empleadoModel->deleteById($id);
        
        if ($empleado) {
            echo json_encode([
                'success' => true,
                'data' => $empleado
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Empleado no encontrado'
            ]);
        }
    }

    private function loadView($view, $data) {
        extract($data);
        session_start();
        $errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
        $form_data = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : [];
        unset($_SESSION['errors']);
        unset($_SESSION['form_data']);
        require_once "../app/view/{$view}.php";
    }

}
