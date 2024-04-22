<?php
class Administrador {
    private $servername = "localhost";
    private $username = "root";
    private $password = "12345";
    private $dbname = "efi100cia2";

    public function validarCredenciales($correo, $contrasena) {
        $contrasena_md5 = md5($contrasena);
        
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        if ($conn->connect_error) {
            die("Error de conexión a la base de datos: " . $conn->connect_error);
        }

        // Consulta para validar las credenciales del administrador
        $adminstmt = $conn->prepare("SELECT correo FROM administrador WHERE correo = ? AND contrasena = ?");
        $adminstmt->bind_param("ss", $correo, $contrasena_md5);
        $adminstmt->execute();
        $adminstmt->store_result();

        if ($adminstmt->num_rows > 0) {
            $adminstmt->close();
            $conn->close();
            return true;
        }

        return false;
    }
    public function buscarEstudiantesPorMatricula($matricula) {
        $conexion = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        $sql = "SELECT matricula, nombre, apellido1, apellido2, fecha_nacimiento, residencia, correo,id_grupo 
                FROM estudiantes_inscritos 
                WHERE matricula LIKE '%$matricula%'";
        $result = $conexion->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    
    public function buscarProfesorPorClave($clave_profesor) {
        $conexion = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        $sql = "SELECT * 
                FROM profesores 
                WHERE clave_profesor LIKE '%$clave_profesor%'";
        $result = $conexion->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function obtenerTodosLosEstudiantes() {
        $conexion = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
    
        $sql = "SELECT matricula, estudiantes_inscritos.nombre AS nombre_estudiante, apellido1, apellido2, fecha_nacimiento, residencia, correo, grupos.nombre AS NombreGrupo 
                FROM estudiantes_inscritos
                LEFT JOIN grupos ON estudiantes_inscritos.id_grupo = grupos.id_grupo";
        $result = $conexion->query($sql);
    
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    

    

    public function obtenerTodosLosProfesores() {
        $conexion = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        $sql = "SELECT * 
                FROM profesores";
        $result = $conexion->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function buscarGrupoPorNombre($nombre) {
        $conexion = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        $sql = "SELECT * 
                FROM grupos 
                WHERE nombre LIKE '%$nombre%'";
        $result = $conexion->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerTodosLosgrupos() {
        $conexion = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        $sql = "SELECT * 
                FROM grupos";
        $result = $conexion->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function nuevoProfesor($clave_profesor,$nombre,$apellido1,$apellido2,$correo,$contrasena_encriptada){
        $conexion = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        // Consulta preparada para evitar inyección de SQL
        $stmt = $conexion->prepare("INSERT INTO profesores (clave_profesor,nombre,ap_paterno,ap_materno, correo, contrasena) VALUES (?, ?, ?,?,?,?)");
        $stmt->bind_param("isssss", $clave_profesor, $nombre, $apellido1, $apellido2, $correo, $contrasena_encriptada);
        if ($stmt->execute()) {
            // La inserción se realizó correctamente
            echo "Registro exitoso.";
    
        } else {
            // Hubo un error en la inserción
            echo "Error al registrar el profesor: " . $stmt->error;
        }
    
        $stmt->close();
        $conexion->close();
    }

    public function nuevoGrupo($nombre,$id_periodo) {
        $conexion = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
    
        // Verificar la conexión
        if ($conexion->connect_error) {
            die("Error de conexión a la base de datos: " . $conexion->connect_error);
        }
    
        // Consulta preparada para insertar un nuevo grupo
        $stmt = $conexion->prepare("INSERT INTO grupos (id_grupo,nombre,id_periodo) VALUES (NULL,?,?)");
    
        // Verificar si la preparación de la consulta fue exitosa
        if ($stmt === false) {
            die("Error al preparar la consulta: " . $conexion->error);
        }
    
        // Enlazar parámetros y ejecutar la consulta
        $stmt->bind_param("si", $nombre,$id_periodo);
        if ($stmt->execute()) {
            // Si la inserción fue exitosa
            echo "Nuevo grupo registrado correctamente.";
        } else {
            // Si ocurrió un error durante la inserción
            echo "Error al registrar el nuevo grupo: " . $stmt->error;
        }
    
        // Cerrar la consulta y la conexión
        $stmt->close();
        $conexion->close();
    }
    public function buscarasignaturaPorNombre($nombre) {
        $conexion = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        $sql = "SELECT * 
                FROM asignaturas 
                WHERE nombre LIKE '%$nombre%'";
        $result = $conexion->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerTodosLosasignaturas() {
        $conexion = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        $sql = "SELECT * 
                FROM asignaturas";
        $result = $conexion->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function nuevoAsignatura($nombre, $id_periodo) {
        $conexion = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
    
        // Verificar la conexión
        if ($conexion->connect_error) {
            die("Error de conexión a la base de datos: " . $conexion->connect_error);
        }
    
        // Consulta preparada para insertar un nuevo asignatura
        $stmt = $conexion->prepare("INSERT INTO asignaturas (id_asignatura,nombre,id_periodo) VALUES (NULL,?,?)");
    
        // Verificar si la preparación de la consulta fue exitosa
        if ($stmt === false) {
            die("Error al preparar la consulta: " . $conexion->error);
        }
    
        // Enlazar parámetros y ejecutar la consulta
        $stmt->bind_param("si", $nombre,$id_periodo);
        if ($stmt->execute()) {
            // Si la inserción fue exitosa
            echo "Nuevo asignatura registrado correctamente.";
        } else {
            // Si ocurrió un error durante la inserción
            echo "Error al registrar el nuevo asignatura: " . $stmt->error;
        }
    }
    
    public function MostrarAsignaciones() {
        $conexion = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $sql = "SELECT asignaturas.Nombre AS NombreAsignatura, CONCAT(profesores.Nombre, ' ', profesores.Ap_paterno, ' ', profesores.Ap_materno) AS NombreProfesor, grupos.Nombre AS NombreGrupo
                FROM asignacionmaterias
                INNER JOIN asignaturas ON asignacionmaterias.id_asignatura = asignaturas.id_asignatura
                INNER JOIN profesores ON asignacionmaterias.clave_profesor = profesores.clave_profesor
                INNER JOIN grupos ON asignacionmaterias.id_grupo = grupos.id_grupo";

        $result = $conexion->query($sql);

        return $result;
    }
    public function obtenerAsignaturas() {
        $conexion = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $sql = "SELECT Nombre FROM asignaturas";
        $resultado = $conexion->query($sql);
        return $resultado;
    }

    public function obtenerProfesores() {
        $conexion = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $sql = "SELECT Nombre FROM profesores";
        $resultado = $conexion->query($sql);
        return $resultado;
    }

    public function obtenerGrupos() {
        $conexion = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $sql = "SELECT DISTINCT Nombre FROM Grupos";
        $resultado = $conexion->query($sql);
        return $resultado;
    }

    public function insertarAsignacion($id_asignatura, $clave_profesor, $id_grupo, $id_periodo) {
        $conexion = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $stmt = $conexion->prepare("INSERT INTO asignacionmaterias (id_asignacion, id_asignatura, clave_profesor, id_grupo,id_periodo) VALUES (NULL, ?, ?, ?,?)");
        $stmt->bind_param("iiii", $id_asignatura, $clave_profesor, $id_grupo,$id_periodo);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    function obtenerIdAsignatura($nombre) {
        $conexion = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $stmt = $conexion->prepare("SELECT id_asignatura FROM asignaturas WHERE Nombre = ?");
        $stmt->bind_param("s", $nombre);
        $stmt->execute();
        $resultado = $stmt->get_result();
    
        if ($resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            return $fila['id_asignatura'];
        } else {
            return false;
        }
    }
    
    function obtenerIdProfesor($nombre) {
        $conexion = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $stmt = $conexion->prepare("SELECT clave_profesor FROM profesores WHERE Nombre = ?");
        $stmt->bind_param("s", $nombre);
        $stmt->execute();
        $resultado = $stmt->get_result();
    
        if ($resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            return $fila['clave_profesor'];
        } else {
            return false;
        }
    }
    
    function obtenerIdGrupo($nombre) {
        $conexion = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $stmt = $conexion->prepare("SELECT id_grupo FROM grupos WHERE Nombre = ?");
        $stmt->bind_param("s", $nombre);
        $stmt->execute();
        $resultado = $stmt->get_result();
    
        if ($resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            return $fila['id_grupo'];
        } else {
            return false;
        }
    }
    public function nuevoAdmin($nombre,$correo, $contrasena_encriptada) {
        $conexion = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
    
        if ($conexion->connect_error) {
            die("Error de conexión a la base de datos: " . $conexion->connect_error);
        }
    
        $stmt = $conexion->prepare("INSERT INTO administrador (id_admin,nombre,correo,contrasena) VALUES (NULL,?,?,?)");
    
        if ($stmt === false) {
            die("Error al preparar la consulta: " . $conexion->error);
        }
    
        $stmt->bind_param("sss", $nombre,$correo, $contrasena_encriptada);
        if ($stmt->execute()) {
            echo "Nuevo administrador registrado correctamente.";
        } else {
            echo "Error al registrar el nuevo administrador: " . $stmt->error;
        }
    
    
        $stmt->close();
        $conexion->close();
    }

    public function verificarMatricula($matricula) {
        $conexion = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $query = "SELECT matricula FROM estudiantes_inscritos WHERE matricula = '".$matricula."'";
        $result = $conexion->query($query);
        return $result->num_rows > 0;
    }

    public function actualizarMatricula($matricula,$nombre) {
        $conexion = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $query = "UPDATE estudiantes_inscritos SET nombre = '".$nombre."' WHERE matricula = '".$matricula."'";
        $conexion->query($query);
    }

    public function insertarMatricula($matricula, $nombre,$apellido1,$apellido2,$fecha_nacimiento,$residencia,$correo,$id_grupo) {
        $conexion = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $query = "INSERT INTO estudiantes_inscritos (matricula,nombre,apellido1,apellido2,correo) VALUES ('".$matricula."', '".$nombre."', '".$apellido1."', '".$apellido2."', '".$correo."')";
        $conexion->query($query);
    }
    public function borrarEstudiante($matricula) {
        $conexion = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $query = "DELETE FROM estudiantes_inscritos WHERE matricula = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("s", $matricula);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    public function actualizarEstudiante($matricula, $nombre, $apellido1, $apellido2, $fecha_nacimiento, $residencia, $correo, $id_grupo) {
        $conexion = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $query = "UPDATE estudiantes_inscritos SET nombre=?, apellido1=?, apellido2=?, fecha_nacimiento=?, residencia=?, correo=?, id_grupo=? WHERE matricula=?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("ssssssss", $nombre, $apellido1, $apellido2, $fecha_nacimiento, $residencia, $correo, $id_grupo, $matricula);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function MostrarAsignacionesPorGrupo($grupo) {
        $conexion = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        
        // Construye la consulta SQL para filtrar por grupo si se proporciona un valor de grupo
        $sql = "SELECT asignaturas.Nombre AS NombreAsignatura, CONCAT(profesores.Nombre, ' ', profesores.Ap_paterno, ' ', profesores.Ap_materno) AS NombreProfesor, grupos.Nombre AS NombreGrupo
                FROM asignacionmaterias
                INNER JOIN asignaturas ON asignacionmaterias.id_asignatura = asignaturas.id_asignatura
                INNER JOIN profesores ON asignacionmaterias.clave_profesor = profesores.clave_profesor
                INNER JOIN grupos ON asignacionmaterias.id_grupo = grupos.id_grupo";
        
        if(!empty($grupo)) {
            
            $sql .= " WHERE grupos.Nombre = '$grupo'";
        }
    
        $result = $conexion->query($sql);
    
        return $result;
    }    
    public function ObtenerGruposAsignaciones() {
        $conexion = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $sql = "SELECT Nombre AS NombreGrupo FROM grupos";
        $result = $conexion->query($sql);
        return $result;
    }
    public function ObtenerDetalleAlumno($matricula) {
        $conexion = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $sql = "SELECT * FROM estudiantes_inscritos WHERE matricula = '$matricula'";
        $result = $conexion->query($sql);
        return $result->fetch_assoc();
    }
    public function ActualizarEstudianteGrupo ($matricula, $id_grupo) {
        $conexion = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $query = "UPDATE estudiantes_inscritos SET  id_grupo = '".$id_grupo."' WHERE matricula = '".$matricula."'";
        $conexion->query($query);
    }
    public function obtenerTodosLosPeriodos() {
        // Implementa la lógica para obtener todos los periodos desde tu base de datos
        $conexion = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $sql = "SELECT * FROM periodo";
        $result = $conexion->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);

    }

    // Método para buscar grupos por periodo
    public function buscarGrupoPorPeriodo($id_periodo) {
        $conexion = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        
        // Verificar la conexión
        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }
        
        $sql = "SELECT grupos.nombre, periodo.nombre as nombre_periodo
                FROM grupos
                INNER JOIN periodo ON grupos.id_periodo = periodo.id_periodo
                WHERE grupos.id_periodo = $id_periodo";
        
        // Ejecutar la consulta
        $result = $conexion->query($sql);
        
        // Verificar si se obtuvieron resultados
        if ($result === false) {
            echo "Error al ejecutar la consulta: " . $conexion->error;
            return null;
        }
        
        // Inicializar un array para almacenar los resultados
        $resultados = array();
        
        // Recorrer los resultados y agregarlos al array
        while ($row = $result->fetch_assoc()) {
            $resultados[] = $row;
        }
        
        // Cerrar la conexión
        $conexion->close();
        
        // Devolver los resultados
        return $resultados;
    }
    public function obtenerPeriodos() {
        $conexion = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $sql = "SELECT Nombre FROM periodo";
        $resultado = $conexion->query($sql);
        return $resultado;
    }
    public function obtenerIdPeriodo($periodo){
        $conexion = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $stmt = $conexion->prepare("SELECT id_periodo FROM periodo WHERE nombre = ?");
        $stmt->bind_param("s", $periodo);
        $stmt->execute();
        $resultado = $stmt->get_result();
    
        if ($resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            return $fila['id_periodo'];
        } else {
            return false;
        }
    }    
    public function buscarasignaturasPorPeriodo($id_periodo) {
        $conexion = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        
        // Verificar la conexión
        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }
        
        $sql = "SELECT asignaturas.nombre, periodo.nombre as nombre_periodo
                FROM asignaturas
                INNER JOIN periodo ON asignaturas.id_periodo = periodo.id_periodo
                WHERE asignaturas.id_periodo = $id_periodo";
        
        // Ejecutar la consulta
        $result = $conexion->query($sql);
        
        // Verificar si se obtuvieron resultados
        if ($result === false) {
            echo "Error al ejecutar la consulta: " . $conexion->error;
            return null;
        }
        
        // Inicializar un array para almacenar los resultados
        $resultados = array();
        
        // Recorrer los resultados y agregarlos al array
        while ($row = $result->fetch_assoc()) {
            $resultados[] = $row;
        }
        
        // Cerrar la conexión
        $conexion->close();
        
        // Devolver los resultados
        return $resultados;
    }
    
    
    public function buscarEstudiantesPorGrupo($grupo) {
        $conexion = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
    
        $sql = "SELECT matricula, estudiantes_inscritos.nombre AS nombre_estudiante, apellido1, apellido2, fecha_nacimiento, residencia, correo, grupos.nombre AS NombreGrupo 
                FROM estudiantes_inscritos
                INNER JOIN grupos ON estudiantes_inscritos.id_grupo = grupos.id_grupo";
    
        if (!empty($grupo)) {
            // Utilizamos el alias correcto para la columna nombre del grupo
            $sql .= " WHERE grupos.nombre = '$grupo'";
        }
    
        $result = $conexion->query($sql);
    
        return $result;
    }
    public function mostrarChequeos() {
        $conexion = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $sql = "SELECT CONCAT(estudiantes_inscritos.Nombre, ' ', estudiantes_inscritos.apellido1, ' ', estudiantes_inscritos.apellido2) AS NombreAlumno, 
               salones.nombre AS NombreSalon,
               checar.fecha,
               checar.hora
        FROM checar
        INNER JOIN estudiantes_inscritos ON checar.huella = estudiantes_inscritos.huella
        INNER JOIN salones ON checar.id_salon = salones.id_salon";

        $result = $conexion->query($sql);
        return $result;
    }

    public function obtenerTodosLosSalones() {
        // Implementa la lógica para obtener todos los periodos desde tu base de datos
        $conexion = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $sql = "SELECT * FROM salones";
        $result = $conexion->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);

    }
    public function consultaChequeosPorFecha($fecha) {
        $conexion = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $sql = "SELECT CONCAT(estudiantes_inscritos.Nombre, ' ', estudiantes_inscritos.apellido1, ' ', estudiantes_inscritos.apellido2) AS NombreAlumno, 
               salones.nombre AS NombreSalon,
               checar.fecha,
               checar.hora
        FROM checar
        INNER JOIN estudiantes_inscritos ON checar.huella = estudiantes_inscritos.huella
        INNER JOIN salones ON checar.id_salon = salones.id_salon
        WHERE checar.fecha = '$fecha'";

        $result = $conexion->query($sql);
        return $result;
    }
    public function consultaChequeosPorSalon($salon) {
        $conexion = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $sql = "SELECT CONCAT(estudiantes_inscritos.Nombre, ' ', estudiantes_inscritos.apellido1, ' ', estudiantes_inscritos.apellido2) AS NombreAlumno, 
               salones.nombre AS NombreSalon,
               checar.fecha,
               checar.hora
        FROM checar
        INNER JOIN estudiantes_inscritos ON checar.huella = estudiantes_inscritos.huella
        INNER JOIN salones ON checar.id_salon = salones.id_salon";
        if(!empty($salon)) {
            
            $sql .= " WHERE salones.id_salon = '$salon'";
        }
        $result = $conexion->query($sql);
        return $result;
    }
    
}
?>
