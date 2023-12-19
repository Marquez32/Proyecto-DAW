<?php

    $carga = fn($clase)=> require "bbdd/$clase.php";
    spl_autoload_register($carga);
  
    $bd = new BD();
    $datosEjercicios = $bd->mostrarEjercicios();

    session_start();

    // Acceder al ID del usuario almacenado en la variable de sesión
    if (isset($_SESSION['id'])) {
        $id = $_SESSION['id'];
    } 

    $error = false; 

    if (isset($_POST['botonAgnadir'])) {
      $idEjercicio = $_POST['idEjercicio'];
      $nombreEjercicio = $_POST['nombreEjercicio'];
      $fechaEjercicio = $_POST['fechaEjercicio'];
      $zonaTrabajada = $_POST['zonaTrabajada'];
      $peso = 0;
      $numSeries = 0;
        if (empty($fechaEjercicio)) {
            $error = true;
            $errorMensaje = "Selecciona una fecha";
        } 
        else {
            if ($zonaTrabajada != "todo el cuerpo") {
                $peso = $_POST['peso'];
                $numSeries = $_POST['numSeries'];
                if($numSeries <= 0) {
                    $error = true;
                    $errorMensaje = "Selecciona el nº de series";
                }
                else {
                    $bd->insertUsuarioEjercicios($id, $idEjercicio, $fechaEjercicio, $peso, $numSeries);
                }
            }
            else {
                $bd->insertUsuarioEjercicios($id, $idEjercicio, $fechaEjercicio, $peso, $numSeries);
            }
        }
    }
    
    if(isset($_POST['btnFiltrarPorNombre'])) {
        $nombreEjercicio = $_POST['buscadorEjercicios'];
        $datosEjercicios = $bd->mostrarEjerciciosPorNombre($nombreEjercicio);
    }

    if(isset($_POST['btnMostrarEjercicios'])) {
        $datosEjercicios = $bd->mostrarEjercicios();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ejercicios</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #F9E8E8;
        }

        #contenedorEjercicios {
            max-width: 100%;
            margin: 20px 20px 0 20px;
            padding: 20px;
            padding-top: 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f5f5f5;
            float: left; 
        }

        #contenedorListado {
            max-height: 400px;
            margin: 20px 20px 0 20px;
            overflow-y: auto; 
        }

        input[type="search"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        label {
            display: flex;
            font-weight: bold;
            align-items: center;
            margin-left: 10px;
        }

        button {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            margin-right: 10px;
        }

        h2 {
            font-size: 24px;
            color: #2f4f4f; 
        }

        .botones {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .divBotonAgnadir {
            display: flex; 
            align-items: center;
        }

        .botonAgnadir {
          width: 20px;
          height: 20px;
          padding: 0;
          border: none;
          border-radius: 20px;
          background-color: #4CAF50;
          color: white;
          cursor: pointer;
          font-size: 12px;
          margin-left: 20px;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        .contenedor-listado {
            display: flex;
            align-items: center;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f5f5f5;
            margin-bottom: 10px;
            margin-right: 10px;
        }

        .hora-inicio {
            width: 100px;
            text-align: center;
        }

        .hora-fin {
            width: 100px;
            text-align: center;
        }

        .formulario-ejercicio {
            display: flex;
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

        .fechaEjercicio {
            width: 110px;
            height: 30px;
            margin-left: 10px;
        }

        .peso {
            width: 50px;
            height: 30px;
            margin-left: 10px;
        }

        .numSeries {
            width: 50px;
            height: 30px;
            margin-left: 10px;
        }

        .dia-semana {
            width: 140px;
            margin-left: 10px;
            color: #000;
            font-size: 16px;
            text-align: left;
        }

        .labelBuscador {
            margin: 0 auto;
            margin-bottom: 5px;
        }

        .left-column {
            float: left;
            width: 35%;
        }

        .imgEjercicio {
            margin-left: 20px;
            margin-top: 20px;
            max-width: 85%;
        }

        .mensaje-error {
            color: red;
            margin-left: 5px;
        }

        
    </style>
</head>
<body>
    <?php
    // Incluir el menú de navegación desde navbar.php
        include 'navBar.php';
    ?>
    <div class="left-column">
        <div id="contenedorEjercicios">
            <h2>Buscador de ejercicios</h2>
            <form method="post" action="ejercicios.php">
                <input type="hidden" name="paginaCorrecta" value="true">
                <label class="labelBuscador" for="buscadorEjercicios">Nombre:</label>
                <input type="search" id="buscadorEjercicios" name="buscadorEjercicios" placeholder="Buscar" />

                <div class="botones">
                    <button id="btnFiltrarPorNombre" type="submit" name="btnFiltrarPorNombre">Filtrar por nombre</button>
                    <button id="btnMostrarEjercicios" type="submit" name="btnMostrarEjercicios">Mostrar ejercicios</button>
                </div>
            </form>
        </div>
        <img src="images/imagenEjercicio.webp" class="imgEjercicio">
    </div>
    
    <h2>Listado de ejercicios</h2>
    <div id="contenedorListado">
    <ul id="listadoClases">
        <?php 
        foreach ($datosEjercicios as $ejercicio) {
            $zonaTrabajada = $ejercicio->getZonaTrabajada();
            $nombreEj = $ejercicio->getnombreEj();
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

                <form class="formulario-ejercicio" method="post" action="ejercicios.php" onsubmit="return validarFormulario(this)">
                    <input type="hidden" name="paginaCorrecta" value="true">

                    <label for="fechaEjercicio">Fecha:</label>
                    <input type="date" class="fechaEjercicio" name="fechaEjercicio" placeholder="Fecha(día/mes/año)" />
                    
                    <?php 
                        if($zonaTrabajada != "todo el cuerpo") { 
                    ?>
                        <label for="peso">Peso:</label>
                        <input type="number" class="peso" name="peso" placeholder="0"/>

                        <label for="numSeries">Nº series:</label>
                        <input type="number" class="numSeries" name="numSeries" placeholder="0"/>

                    <?php 
                        } 
                    ?>

                    <input type="hidden" name="idEjercicio" value="<?php echo $ejercicio->getIdEj(); ?>">
                    <input type="hidden" name="nombreEjercicio" value="<?php echo $ejercicio->getNombreEj(); ?>">
                    <input type="hidden" name="zonaTrabajada" class="zonaTrabajadaTexto" value="<?php echo $zonaTrabajada; ?>">

                    <div class="divBotonAgnadir">
                        <button class="botonAgnadir" type="submit" name="botonAgnadir">+</button>
                    </div>

                    <?php
                        // Mostrar mensaje de error si corresponde
                        if ($error && isset($_POST['idEjercicio']) && $_POST['idEjercicio'] === $ejercicio->getIdEj()) {
                            echo '<span class="mensaje-error">' . $errorMensaje . '</span>';
                        }
                    ?>
                </form>
            </li>
        <?php } ?>
    </ul>
</div>
</body>
<script>
  // Esta función se ejecutará cuando se envíe el formulario
  function validarFormulario(formulario) {
    // Comprueba si hay un mensaje de error en el formulario actual
    var errorMensaje = formulario.querySelector('.mensaje-error');
    
    // Comprueba si se ha ingresado una fecha válida
    var fechaEjercicio = formulario.querySelector('.fechaEjercicio').value;

    // Obtiene los valores de zonaTrabajada y numSeries
    var zonaTrabajada = formulario.querySelector('.zonaTrabajadaTexto').value;
    if (fechaEjercicio === '') {
        alert('Por favor, selecciona una fecha.');
        return false;
    }

    if(zonaTrabajada != 'todo el cuerpo') {
        var numSeries = formulario.querySelector('.numSeries').value;
        if(numSeries === '' || numSeries <= 0) {
            alert('El número de series no puede ser 0 o negativo.');
            return false;
        }
    }
    
    // Mostrar el confirm aquí
    var confirmar = confirm('¿Seguro que deseas agregar este ejercicio?');
    
    // Si el usuario acepta el confirm, se envía el formulario
    if (confirmar) {
      alert('El ejercicio se ha añadido correctamente.');
      return true; 
    } else {
      alert('Se ha cancelado la operación.');
      return false; 
    }
  }
</script>
</html>