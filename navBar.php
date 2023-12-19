<?php
    $carga = fn($clase)=> require "bbdd/$clase.php";
    spl_autoload_register($carga);

    $bd = new BD();
    if (session_status() != PHP_SESSION_ACTIVE) {
        session_start();
    } 

    //Comprobamos si venimos desde el login
    $paginaCorrecta = $_GET['paginaCorrecta'] ?? $_POST['paginaCorrecta'] ?? false;
    if(!isset($paginaCorrecta) || !$paginaCorrecta) {
        header("Location:login.php");
        exit();
    }
    
    // Acceder al ID del usuario almacenado en la variable de sesión
    if (isset($_SESSION['id'])) {
        $id = $_SESSION['id'];
    } 

    $usuario = $bd->obtenerUsuarioPorId($id);
    $idImagen = $usuario->getIdImagen();

    if(isset($idImagen)) {
        // Obtener el contenido binario de la imagen asociada al usuario desde la tabla de imágenes
        $contenidoImagen = $bd->obtenerContenidoImagenPorId($idImagen); 
        // Convertir el contenido binario de la imagen a un data URI
        $mime_type = 'image/jpeg'; 
        $base64Imagen = base64_encode(stripslashes($contenidoImagen));
        $data_uri = "data:$mime_type;base64,$base64Imagen";
    }

?>

<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
    }

    nav {
        background-color: #4B9BD4;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    .navbar {
        list-style-type: none;
        margin: 0;
        padding: 0;
        overflow: hidden;
    }

    .navbar li {
        float: left;
    }

    .navbar li a {
        display: block;
        color: white;
        text-align: center;
        padding: 16px;
        text-decoration: none;
        transition: background-color 0.3s;
    }

    .navbar li a:hover {
        background-color: #5CAEE1;
    }

    .navbar li a.active {
        background-color: #3F8ACB;
    }

    .navbar li.cerrarSesion {
        float: right;
    }

    .imagenPerfil {
        height: 45px;
    }
</style>

<nav>
    <ul class="navbar">
        <li><a href="pantallaPrincipal.php?paginaCorrecta=true">Pantalla principal</a></li>
        <li><a href="ejercicios.php?paginaCorrecta=true">Ejercicios</a></li>
        <li><a href="clases.php?paginaCorrecta=true">Clases</a></li>
        <li><a href="dietas.php?paginaCorrecta=true">Dietas</a></li>
        <li><a href="misEjercicios.php?paginaCorrecta=true">Mis ejercicios</a></li>
        <li><a href="misClases.php?paginaCorrecta=true">Mis clases</a></li>
        <li class="cerrarSesion"><a href="login.php">Cerrar sesión</a></li>
        <li class="cerrarSesion"><a href="miPerfil.php?paginaCorrecta=true">Mi perfil</a></li>
        <li class="cerrarSesion">
            <?php 
                if(isset($data_uri)) {
                echo '<img src="' . $data_uri . '" class="imagenPerfil" name="imagenActual "alt="Imagen de perfil">';
                }
            ?>
        </li>
    </ul>
</nav>