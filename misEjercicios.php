<?php

    $carga = fn($clase)=> require "bbdd/$clase.php";
    spl_autoload_register($carga);

    $bd = new BD();
    $datosUsuarioEjercicios = array();

    session_start();

    // Acceder al ID del usuario almacenado en la variable de sesión
    if (isset($_SESSION['id'])) {
        $id = $_SESSION['id'];
    } 

    if (isset($_POST['consultar'])) {
        $fechaConsulta = $_POST['fecha'];
        $datosUsuarioEjercicios = $bd->mostrarUsuarioEjerciciosPorFecha($id, $fechaConsulta);
    } 

    if (isset($_POST['botonBorrar'])) {
        $fechaConsulta = $_POST['fecha'];
        $idEjercicio = $_POST['idEjercicio'];
        $bd->borrarEjercicio($id, $idEjercicio);
        $datosUsuarioEjercicios = $bd->mostrarUsuarioEjerciciosPorFecha($id, $fechaConsulta);
    }

?>

<!DOCTYPE html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Mis Ejercicios</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #F9E8E8;
        }

        header {
            padding: 16px;
            color: #2f4f4f; 
            text-align: center;
            font-size: 24px;
            font-weight: bold;
        }

        .container {
            display: flex; 
            flex-direction: row; 
            width: 100%;
            height: 100%;
        }

        .left-column {
            float: left;
            width: 60%;
            text-align: center;
        }

        .input-label {
            font-size: 18px;
            font-weight: bold;
            margin-right: 10px;
            align-items: center;
            display: inline-block; 
        }

        .input-field {
            padding: 8px;
            font-size: 16px;
            text-align: center; 
            width: 25%;
        }

        .textazo {
            margin-top: 20px;
            font-size: 20px;
        }

        .textazo2 {
            margin-top: 20px;
            font-size: 20px;
        }

        .right-column {
            float: right;
            width: 40%;
        }

        .exercise-item {
            padding: 10px;
            border: 1px solid #ccc;
            margin-bottom: 10px;
        }

        .buttons-container {
            display: flex;
            justify-content: center; 
            margin-top: 20px;
        }

        .button {
            background-color: #572364; 
            color: white;
            padding: 10px 20px;
            font-size: 18px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #9370DB; 
        }

        .contenedor-listado {
            display: flex;
            align-items: center;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f5f5f5;
            margin-bottom: 10px;
        }

        #contenedorClases {
            max-height: 425px;
            margin: 20px;
            overflow-y: auto;
        }

        .divBotonBorrar {
            display: flex; 
            align-items: center;
        }

        .botonBorrar {
          width: 20px;
          height: 20px;
          padding: 0;
          border: none;
          border-radius: 20px;
          background-color: #FF0000;
          color: white;
          cursor: pointer;
          font-size: 12px;
          margin-left: 20px;
        }

        .zonaTrabajada {
            width: 52px;
            height: 51px;
            margin-left: 10px;
        }

        .nombre-ejercicio {
            width: 150px;
            margin-left: 10px;
            font-weight: bold;
            font-size: 20px;
            text-align: left;
        }

        .peso {
            width: 190px;
            margin-left: 10px;
            font-weight: bold;
            font-size: 20px;
            text-align: left;
        }

        .num-series {
            width: 130px;
            margin-left: 10px;
            font-weight: bold;
            font-size: 20px;
            text-align: left;
        }

        .imagen {
            max-width: 90%;
            height: auto;
            margin: 10px; 
        }

    </style>
  </head>
  <body>
    <?php
    // Incluir el menú de navegación desde navbar.php
        include 'navBar.php';
    ?>
    <header>Ejercicios diarios</header>
    <div class="container">
        <div class="left-column">
            <form method="post" action="misEjercicios.php">
                <input type="hidden" name="paginaCorrecta" value="true">
                <div class="input-label">Fecha (día/mes/año):</div>
                <input type="date" class="input-field" name="fecha" value="<?php echo $fechaConsulta; ?>">
                <div class="buttons-container">
                    <button class="button" type="submit" name="consultar">Consultar</button>
                </div>
            </form>
            
        <div class="textazo">Aquí aparecerán los ejercicios en la fecha que has seleccionado.</div>
        <div id="contenedorClases">
            <ul id="listadoClases">
                <?php 
                foreach ($datosUsuarioEjercicios as $usuario_ejercicio) {
                    $peso = $usuario_ejercicio->getPeso();
                    $numSeries = $usuario_ejercicio->getNumSeries();
                    $idEj = $usuario_ejercicio->getIdEj();
                    $ejercicio = $bd->obtenerEjercicioPorId($idEj);

                    $zonaTrabajada = $ejercicio->getZonaTrabajada();
                    $nombreEj = $ejercicio->getNombreEj();
                    $imagen = '';

                    switch($zonaTrabajada) {
                        case "pierna":
                            $imagen = 'images/ic_pierna.png';
                            break;
                        case "espalda":
                            $imagen = 'images/ic_espalda.png';
                            break;
                        case "pecho":
                            $imagen = 'images/ic_pecho.png';
                            break;
                        case "brazo":
                            $imagen = 'images/ic_brazo.png';
                            break;
                        default:
                        switch($nombreEj) {
                            case "futbol":
                                $imagen = 'images/ic_futbol.png';
                                break;
                            case "baloncesto":
                                $imagen = 'images/ic_deporte2.png';
                                break;
                            case "tenis":
                            case "padel":
                                $imagen = 'images/ic_tenis.png';
                                break;
                            case "natacion":
                                $imagen = 'images/ic_natacion.png';
                                break;
                            default:
                                break;
                        }
                        break;
                    }
                    
                ?>
                    <li class="contenedor-listado">
                        <img class="zonaTrabajada" src="<?php echo $imagen; ?>" alt="Zona trabajada">
                        <div class="nombre-ejercicio"><?php echo $ejercicio->getNombreEj(); ?></div>
                        <?php
                            if($zonaTrabajada != "todo el cuerpo") { 
                        ?>
                            <div class="peso">Peso: <?php echo $usuario_ejercicio->getPeso(); ?></div>
                            <div class="num-series">Nº series: <?php echo $usuario_ejercicio->getNumSeries(); ?></div>
                        <?php
                            }
                            else {
                        ?>
                            <div class="peso">Peso: - </div>
                            <div class="num-series">Nº series: - </div>
                        <?php
                            }
                        ?>

                        <form class="formulario-ejercicio" method="post" action="misEjercicios.php" onsubmit="return validarFormulario(this)">
                            <input type="hidden" name="paginaCorrecta" value="true">
                            <input type="hidden" name="fecha" value="<?php echo $fechaConsulta ?>">
                            <input type="hidden" name="idEjercicio" value="<?php echo $usuario_ejercicio->getIdEj(); ?>">
                            <input type="hidden" name="nombreEjercicio" value="<?php echo $ejercicio->getNombreEj(); ?>">

                            <div class="divBotonBorrar">
                                <button class="botonBorrar" type="submit" name="botonBorrar">x</button>
                            </div>
                        </form>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="right-column">
        <img class="imagen" src="images/imagenMisEjercicios.jpg" alt="Imagen 1">
        <img class="imagen" src="images/imagenMisEjercicios2.jpeg" alt="Imagen 2">
    </div>
    </div>
    
  </body>
  <script>
    // Esta función se ejecutará cuando se envíe el formulario
    function validarFormulario(formulario) {
        var confirmar = confirm('¿Seguro que deseas eliminar este ejercicio?');
        
        if (confirmar) {
            alert('El ejercicio se ha eliminado correctamente.');
            return true; 
        } else {
            alert('Se ha cancelado la operación.');
            return false; 
        }
    }
  </script>
</html>