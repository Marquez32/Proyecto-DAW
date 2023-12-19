<?php

    $carga = fn($clase)=> require "bbdd/$clase.php";
    spl_autoload_register($carga);
  
    $bd = new BD();
    $datosClases = $bd->mostrarClases();

    session_start();

    // Acceder al ID del usuario almacenado en la variable de sesión
    if (isset($_SESSION['id'])) {
        $id = $_SESSION['id'];
    }
    
    if(isset($_POST['btnFiltrarPorNombre'])) {
        $nombreClase = $_POST['buscadorClases'];
        $datosClases = $bd->mostrarClasesPorNombre($nombreClase);
    }

    if(isset($_POST['btnFiltrarPorFecha'])) {
        $fecha = $_POST['fechaClases'];
        if(!empty($fecha)) {
            $diaSemana = date("l", strtotime($fecha)); // Devuelve el nombre completo del día (por ejemplo: "Tuesday")
            $diaSemanaEspanol = "";
            switch($diaSemana) {
                case "Monday":
                    $diaSemanaEspanol = "lunes";
                    break;
                case "Tuesday":
                    $diaSemanaEspanol = "martes";
                    break;
                case "Wednesday":
                    $diaSemanaEspanol = "miercoles";
                    break;
                case "Thursday":
                    $diaSemanaEspanol = "jueves";
                    break;
                case "Friday":
                    $diaSemanaEspanol = "viernes";
                    break;
                case "Saturday":
                    $diaSemanaEspanol = "sabado";
                    break;
                case "Sunday":
                    $diaSemanaEspanol = "domingo";
                    break;
            }

            $datosClases = $bd->mostrarClasesPorDiaSemana($diaSemanaEspanol);
        }
        
    }

    if(isset($_POST['btnMostrarClases'])) {
        $datosClases = $bd->mostrarClases();
    }

    if (isset($_POST['botonAgnadir'])) {
        $idClase = $_POST['idClase'];
        $bd->insertUsuarioClases($id, $idClase);
        
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Clases</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #E6E6FA;
        }

        #contenedorClase {
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

        input[type="date"] {
            width: 93%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
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

        .centrar-boton {
            display: flex;
            justify-content: center;
            margin-top: 10px;
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
        }

        .hora-inicio {
            width: 100px;
            text-align: center;
        }

        .hora-fin {
            width: 100px;
            text-align: center;
        }

        .nivel {
            width: 22px;
            height: 21px;
            margin-left: 10px;
        }

        .nombre-clase {
            width: 184px;
            margin-left: 10px;
            font-weight: bold;
            font-size: 20px;
            text-align: left;
        }

        .dia-semana {
            width: 140px;
            margin-left: 10px;
            color: #000;
            font-size: 16px;
            text-align: left;
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

        .formulario-clase {
            display: flex;
        }

        .left-column {
            float: left;
            width: 35%;
        }

        .imgClase {
            margin-left: 20px;
            margin-top: 20px;
            max-width: 85%;
            max-height: 100%;
            margin-bottom: 20px;
        }
    </style>
<body>
    <?php
    // Incluir el menú de navegación desde navbar.php
        include 'navBar.php';
    ?>
    <div class="left-column">
        <div id="contenedorClase">
            <h2>Buscador de clases</h2>
            <form method="post" action="clases.php">
                <input type="hidden" name="paginaCorrecta" value="true">

                <label for="buscadorClases">Nombre:</label>
                <input type="search" id="buscadorClases" name="buscadorClases" placeholder="Buscar" />

                <label for="fechaClases">Fecha(día/mes/año):</label>
                <input type="date" id="fechaClases" name="fechaClases" placeholder="Fecha(año-mes-día)" />

                <div class="botones">
                    <button id="btnFiltrarPorNombre" type="submit" name="btnFiltrarPorNombre">Filtrar por nombre</button>
                    <button id="btnFiltrarPorFecha" type="submit" name="btnFiltrarPorFecha">Filtrar Por Fecha</button>
                </div>
                <div class="centrar-boton">
                    <button id="btnMostrarClases" type="submit" name="btnMostrarClases">Mostrar Clases</button>
                </div>
            </form>
        </div>
        <img src="images/imagenClase.jpg" class="imgClase">
    </div>
    
    <h2>Listado de clases</h2>
    <div id="contenedorListado">
        <ul id="listadoClases">
            <?php foreach ($datosClases as $clase) {
                $nivel = $clase->getNivel();
                $imagen = '';

                if ($nivel == 1) {
                    $imagen = 'images/ic_fondoazul.png';
                } else if ($nivel == 2) {
                    $imagen = 'images/ic_fondo_amarillo.png';
                } else if ($nivel == 3) {
                    $imagen = 'images/ic_fondo_rojo.png';
                }
            ?>
                <li class="contenedor-listado">
                    <div class="hora-inicio"><?php echo $clase->getHoraInicio(); ?></div>
                    <div class="hora-fin"><?php echo $clase->getHoraFin(); ?></div>
                    <img class="nivel" src="<?php echo $imagen; ?>" alt="Nivel">
                    <div class="nombre-clase"><?php echo $clase->getNombreClase(); ?></div>
                    <div class="dia-semana"><?php echo $clase->getDiaSemana(); ?></div>
                    <form class="formulario-clase" method="post" action="clases.php" onsubmit="return validarFormulario(this)">
                        <input type="hidden" name="paginaCorrecta" value="true">
                        <input type="hidden" name="idClase" value="<?php echo $clase->getIdClase(); ?>">
                        <button class="botonAgnadir" type="submit" name="botonAgnadir">+</button>
                    </form>
                </li>
            <?php } ?>
        </ul>
    </div>
</body>
<script>
  // Esta función se ejecutará cuando se envíe el formulario
  function validarFormulario(formulario) {
    var confirmar = confirm('¿Seguro que deseas agregar esta clase?');
    
    if (confirmar) {
      alert('La clase se ha añadido correctamente.');
      return true; 
    } else {
      alert('Se ha cancelado la operación.');
      return false; 
    }
  }
</script>
</html>