<?php

require_once '../config/config.php';

class Empleado {
    private $conn;
    private $table_empleados = "empleados";
    private $table_roles = "roles";
    private $table_areas = "areas";
    private $table_empleado_rol = "empleado_rol";

    public $id;
    public $nombre;
    public $email;
    public $sexo;
    public $area;
    public $descripcion;
    public $roles;
    public $boletin;

    public function __construct() {
        $this->conn = connectDB();
    }

    public function getAll() {
        $query = "
            SELECT e.*, a.nombre AS area_name
            FROM " . $this->table_empleados . " e
            INNER JOIN " . $this->table_areas . " a ON e.area_id = a.id
            order by e.id DESC
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getRoles() {
        $query = "SELECT * FROM " . $this->table_roles;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getAreas() {
        $query = "SELECT * FROM " . $this->table_areas;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_empleados . "
                  (nombre, email, sexo, area_id, descripcion, boletin) 
                  VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssiss", $this->nombre, $this->email, $this->sexo, $this->area, $this->descripcion, $this->boletin);

        return $stmt->execute();
    }

    public function edit() {
        $query = "
            UPDATE " . $this->table_empleados . "
            SET nombre = ?, email = ?, sexo = ?, area_id = ?, descripcion = ?, boletin = ?
            WHERE id = ?
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssissi", $this->nombre, $this->email, $this->sexo, $this->area, $this->descripcion, $this->boletin, $_POST['empleado_edit']);

        return $stmt->execute();
    }


    public function assignRoles($empleado_id, $roles) {
        $query = "INSERT INTO empleado_rol (empleado_id, rol_id) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
    
        if ($stmt === false) {
            die("Error en la preparación de la consulta: " . $this->conn->error);
        }
    
        foreach ($roles as $rol_id) {
            $stmt->bind_param("ii", $empleado_id, $rol_id); 
            $stmt->execute();
        }
    
        $stmt->close();
    }

    public function assignRolesEdit($empleado_id, $roles) {
        $deleteQuery = "DELETE FROM empleado_rol WHERE empleado_id = ?";
        $stmtDelete = $this->conn->prepare($deleteQuery);
        $stmtDelete->bind_param("i", $empleado_id);
        $stmtDelete->execute();
        $stmtDelete->close();

        $query = "INSERT INTO empleado_rol (empleado_id, rol_id) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);

        if ($stmt === false) {
            die("Error en la preparación de la consulta: " . $this->conn->error);
        }

        foreach ($roles as $rol_id) {
            $stmt->bind_param("ii", $empleado_id, $rol_id);
            $stmt->execute();
        }

        $stmt->close();
    }

    public function getLastInsertId() {
        return $this->conn->insert_id;
    }

    public function getEmpleadoById($id) {
        $query = "
            SELECT e.*
            FROM " . $this->table_empleados . " e
            WHERE e.id = ?
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id); 
        $stmt->execute();
        $empleado = $stmt->get_result()->fetch_assoc();

        if ($empleado) {
            $rolesQuery = "
                SELECT rol_id
                FROM " . $this->table_empleado_rol . "
                WHERE empleado_id = ?
            ";
            $stmtRoles = $this->conn->prepare($rolesQuery);
            $stmtRoles->bind_param("i", $id);
            $stmtRoles->execute();
            $rolesResult = $stmtRoles->get_result();
            $roles = $rolesResult->fetch_all(MYSQLI_ASSOC);

            $empleado['roles'] = array_column($roles, 'rol_id');

            return $empleado;
        } else {
            return null;
        }
    }

        public function deleteById($empleado_id){
            $deleteQueryRoles = "DELETE FROM empleado_rol WHERE empleado_id = ?";
            $stmtDeleteRoles = $this->conn->prepare($deleteQueryRoles);
            $stmtDeleteRoles->bind_param("i", $empleado_id);
            $stmtDeleteRoles->execute();
            $stmtDeleteRoles->close();
            
            $deleteQuery = "DELETE FROM empleados WHERE id = ?";
            $stmtDelete = $this->conn->prepare($deleteQuery);
            $stmtDelete->bind_param("i", $empleado_id);
            $stmtDelete->execute();

            return $stmtDelete->execute();
        }
   
}
