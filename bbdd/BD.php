<?php

    require_once 'modelos/Clase.php';
    require_once 'modelos/Ejercicio.php';
    require_once 'modelos/Usuario.php';
    require_once 'modelos/Usuario_Ejercicio.php';
    require_once 'modelos/Usuario_Clase.php';
    require_once 'modelos/Dieta.php';

    class BD extends mysqli {

        private $con;

        public function __construct() {
            try {
                $db = parse_ini_file("conexion.ini");
                $this->con = new mysqli($db["host"], $db["user"], $db["pass"], $db["db"]);
            }
            catch(mysqli_sql_exception $exception) {
                die("Error conectando " .  $exception->getMessage());
            }
        }

        public function agnadirUsuario($nombre, $apellidos, $nick, $contrasegna, $correo, $telefono, $fechaNacimiento, $idImagen) {
            $sentencia = "INSERT INTO usuarios (nombre, apellidos, nick, contrasegna, correo, telefono, fechaNacimiento, idImagen) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
            $stmt = $this->con->prepare($sentencia);
            $stmt->bind_param("sssssssi", $nombre, $apellidos, $nick, $contrasegna, $correo, $telefono, $fechaNacimiento, $idImagen);
            $stmt->execute();
            $stmt->close();
        }

        public function comprobarNick($nick) {
            $sentencia = "SELECT * FROM usuarios WHERE nick = ?;";
            $stmt = $this->con->stmt_init();
            $stmt->prepare($sentencia);
            $stmt->bind_param("s", $nick); 
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows == 0) {
                return true;
            }
            return false;
        }

        public function comprobarNickYContrasegna($nick, $contrasegna) {
            $sentencia = "SELECT * FROM usuarios WHERE nick = ? AND contrasegna = ?;";
            $stmt = $this->con->stmt_init();
            $stmt->prepare($sentencia);
            $stmt->bind_param("ss", $nick, $contrasegna); 
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows == 0) {
                return null;
            }
            $row = $result->fetch_assoc();
            $usuario = new Usuario($row['id'], $row['nombre'], $row['apellidos'], $row['nick'], 
                    $row['contrasegna'], $row['correo'], $row['telefono'], 
                    $row['fechaNacimiento'], $row['idDieta'], $row['idImagen']);

            return $usuario;
        }

        public function mostrarClases() {
            $sentencia = "SELECT * FROM clases";
            $rtdo = $this->con->query($sentencia);
            foreach($rtdo as $row) {
                $datos[] = new Clase($row['idClase'], $row['nombreClase'], $row['nivel'], 
                    $row['diaSemana'], $row['horaInicio'], $row['horaFin']);
            }
            return $datos;
        }

        public function mostrarClasesPorNombre($nombre) {
            $sentencia = "SELECT * FROM clases WHERE nombreClase LIKE ?";
            $nombreParametro = $nombre . "%";
            $stmt = $this->con->prepare($sentencia);
            $stmt->bind_param("s", $nombreParametro);
            $stmt->execute();
            $rtdo = $stmt->get_result();
            $datos = array();
            while ($row = $rtdo->fetch_assoc()) {
                $datos[] = new Clase($row['idClase'], $row['nombreClase'], $row['nivel'], 
                    $row['diaSemana'], $row['horaInicio'], $row['horaFin']);
            }
            $stmt->close();
            return $datos;
        }

        public function mostrarClasesPorDiaSemana($diaSemana) {
            $sentencia = "SELECT * FROM clases WHERE diaSemana LIKE ?";
            $stmt = $this->con->prepare($sentencia);
            $stmt->bind_param("s", $diaSemana);
            $stmt->execute();
            $rtdo = $stmt->get_result();
            $datos = array();
            while ($row = $rtdo->fetch_assoc()) {
                $datos[] = new Clase($row['idClase'], $row['nombreClase'], $row['nivel'], 
                    $row['diaSemana'], $row['horaInicio'], $row['horaFin']);
            }
            $stmt->close();
            return $datos;
        }

        public function mostrarEjercicios() {
            $sentencia = "SELECT * FROM ejercicios";
            $rtdo = $this->con->query($sentencia);
            foreach($rtdo as $row) {
                $datos[] = new Ejercicio($row['idEj'], $row['nombreEj'], 
                    $row['zonaTrabajada'], $row['intensidad']);
            }
            return $datos;
        }

        public function mostrarEjerciciosPorNombre($nombre) {
            $sentencia = "SELECT * FROM ejercicios WHERE nombreEj LIKE ?";
            $nombreParametro = $nombre . "%";
            $stmt = $this->con->prepare($sentencia);
            $stmt->bind_param("s", $nombreParametro);
            $stmt->execute();
            $rtdo = $stmt->get_result();
            $datos = array();
            while ($row = $rtdo->fetch_assoc()) {
                $datos[] = new Ejercicio($row['idEj'], $row['nombreEj'], 
                    $row['zonaTrabajada'], $row['intensidad']);
            }
            $stmt->close();
            return $datos;
        }

        public function insertUsuarioEjercicios($id, $idEj, $fechaRealizado, $peso, $series) {
            $sentencia = "INSERT INTO usuarios_ejercicios (id, idEj, fechaRealizado, peso, series) 
                            VALUES (?, ?, ?, ?, ?);";

            $stmt = $this->con->prepare($sentencia);
            $stmt->bind_param("iisdi", $id, $idEj, $fechaRealizado, $peso, $series);
            $stmt->execute();
            $stmt->close();
        }

        public function insertUsuarioClases($id, $idClase) {
            $sentencia = "INSERT INTO usuarios_clases (id, idClase) VALUES (?, ?);";
            $stmt = $this->con->prepare($sentencia);
            $stmt->bind_param("ii", $id, $idClase);
            $stmt->execute();
            $stmt->close();
        }

        public function mostrarUsuarioEjerciciosPorFecha($id, $fechaRealizado) {
            $sentencia = "SELECT * FROM usuarios_ejercicios WHERE id = ? AND fechaRealizado LIKE ?";
            $stmt = $this->con->prepare($sentencia);
            $stmt->bind_param("is", $id, $fechaRealizado);
            $stmt->execute();
            $rtdo = $stmt->get_result();
            $datos = array();
            while ($row = $rtdo->fetch_assoc()) {
                $datos[] = new Usuario_Ejercicio($row['id'], $row['idEj'], 
                    $row['fechaRealizado'], $row['peso'], $row['series']);
            }
            $stmt->close();
            return $datos;
        }

        public function obtenerEjercicioPorId($idEj) {
            $sentencia = "SELECT * FROM ejercicios WHERE idEj = ?";
            $stmt = $this->con->stmt_init();
            $stmt->prepare($sentencia);
            $stmt->bind_param("i", $idEj); 
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows == 0) {
                return null;
            }
            $row = $result->fetch_assoc();
            $ejercicio = new Ejercicio($row['idEj'], $row['nombreEj'], 
                $row['zonaTrabajada'], $row['intensidad']);

            return $ejercicio;
        }

        public function borrarEjercicio($id, $idEj) {
            $sentencia = "DELETE FROM usuarios_ejercicios WHERE id = ? AND idEj = ?";
            $stmt = $this->con->prepare($sentencia);
            $stmt->bind_param("ii", $id, $idEj);
            $stmt->execute();
            $stmt->close();
        }

        public function mostrarUsuarioClasesPorDiaSemana($id, $diaSemana) {
            $sentencia = "SELECT uc.id, c.idClase FROM usuarios_clases uc JOIN clases c 
                ON uc.idClase = c.idClase WHERE uc.id = ? AND c.diaSemana LIKE ? ORDER BY c.horaInicio";
            $stmt = $this->con->prepare($sentencia);
            $stmt->bind_param("is", $id, $diaSemana);
            $stmt->execute();
            $rtdo = $stmt->get_result();
            $datos = array();
            while ($row = $rtdo->fetch_assoc()) {
                $datos[] = new Usuario_Clase($row['id'], $row['idClase']);
            }
            $stmt->close();
            return $datos;
        }

        public function obtenerClasePorId($idClase) {
            $sentencia = "SELECT * FROM clases WHERE idClase = ?";
            $stmt = $this->con->stmt_init();
            $stmt->prepare($sentencia);
            $stmt->bind_param("i", $idClase);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows == 0) {
                return null;
            }
            $row = $result->fetch_assoc();
            $clase = new Clase($row['idClase'], $row['nombreClase'], $row['nivel'], 
                $row['diaSemana'], $row['horaInicio'], $row['horaFin']);
            
            return $clase;
        }

        public function borrarClase($id, $idClase) {
            $sentencia = "DELETE FROM usuarios_clases WHERE id = ? AND idClase = ?";
            $stmt = $this->con->prepare($sentencia);
            $stmt->bind_param("ii", $id, $idClase);
            $stmt->execute();
            $stmt->close();
        }

        public function obtenerUsuarioPorId($id) {
            $sentencia = "SELECT * FROM usuarios WHERE id = ?";
            $stmt = $this->con->stmt_init();
            $stmt->prepare($sentencia);
            $stmt->bind_param("i", $id); 
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows == 0) {
                return null;
            }
            $row = $result->fetch_assoc();
            $usuario = new Usuario($row['id'], $row['nombre'], $row['apellidos'], $row['nick'], 
                $row['contrasegna'], $row['correo'], $row['telefono'], 
                $row['fechaNacimiento'], $row['idDieta'], $row['idImagen']);
            
            return $usuario;
        }

        public function actualizarUsuario($id, $contrasegna, $correo, $telefono, $idImagen) {
            $sentencia = "UPDATE usuarios SET contrasegna = ?, correo = ?, telefono = ?, idImagen = ? WHERE id = ?";
            $stmt = $this->con->prepare($sentencia);
            $stmt->bind_param("sssii", $contrasegna, $correo, $telefono, $idImagen, $id);
            $stmt->execute();
            $stmt->close();
        }

        public function actualizarUsuarioSinImagen($id, $contrasegna, $correo, $telefono) {
            $sentencia = "UPDATE usuarios SET contrasegna = ?, correo = ?, telefono = ? WHERE id = ?";
            $stmt = $this->con->prepare($sentencia);
            $stmt->bind_param("sssi", $contrasegna, $correo, $telefono, $id);
            $stmt->execute();
            $stmt->close();
        }

        public function actualizarUsuarioImagenNula($id, $idImagen) {
            $sentencia = "UPDATE usuarios SET idImagen = ? WHERE id = ?";
            $stmt = $this->con->prepare($sentencia);
            $stmt->bind_param("ii", $idImagen, $id);
            $stmt->execute();
            $stmt->close();
        }

        public function insertarImagen($img) {
            $sentencia = "INSERT INTO imagenes (img) VALUES (?)";
            $stmt = $this->con->prepare($sentencia);
            $stmt->bind_param("s", $img);
            $stmt->execute();
            $stmt->close();
        }

        public function obtenerIdImagen() {
            $sentencia = "SELECT COUNT(*) FROM imagenes;";
            $rtdo = $this->con->query($sentencia);
            if($rtdo) {
                $row = $rtdo->fetch_row();

                // Obtener el total (la columna con índice 0)
                $total = $row[0];

                return $total;
            }

            return null;
        }

        public function obtenerContenidoImagenPorId($idImagen) {
            $sentencia = "SELECT img FROM imagenes WHERE idImagen = ?;";
            $stmt = $this->con->prepare($sentencia);
            $stmt->bind_param("i", $idImagen);
            $stmt->execute();
            $stmt->bind_result($contenidoImagen);
        
            if ($stmt->fetch()) {
                $stmt->close();
                return $contenidoImagen;
            }
        
            return null;
        }

        public function obtenerDietaPorTipo($tipoDieta) {
            $sentencia = "SELECT * FROM dietas WHERE tipoDieta = ?";
            $stmt = $this->con->stmt_init();
            $stmt->prepare($sentencia);
            $stmt->bind_param("s", $tipoDieta);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows == 0) {
                return null;
            }
            $row = $result->fetch_assoc();
            $dieta = new Dieta($row['idDieta'], $row['nombreDieta'], $row['tipoDieta'], 
                $row['descripcionDieta'], $row['observacionesDieta']);

            return $dieta;
        }

        public function obtenerDietaPorId($idDieta) {
            $sentencia = "SELECT * FROM dietas WHERE idDieta = ?";
            $stmt = $this->con->stmt_init();
            $stmt->prepare($sentencia);
            $stmt->bind_param("i", $idDieta);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows == 0) {
                return null;
            }
            $row = $result->fetch_assoc();
            $dieta = new Dieta($row['idDieta'], $row['nombreDieta'], $row['tipoDieta'], 
                $row['descripcionDieta'], $row['observacionesDieta']);

            return $dieta;
        }

        public function actualizarDietaUsuario($id, $idDieta) {
            $sentencia = "UPDATE usuarios SET idDieta = ? WHERE id = ?";
            $stmt = $this->con->prepare($sentencia);
            $stmt->bind_param("ii", $idDieta, $id);
            $stmt->execute();
            $stmt->close();
        }

    }
?>