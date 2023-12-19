<?php 

    $carga = fn($clase)=> require "bbdd/$clase.php";
    spl_autoload_register($carga);

    $bd = new BD();
    $datosUsuarioClases = array();

    session_start();

    // Acceder al ID del usuario almacenado en la variable de sesión
    if (isset($_SESSION['id'])) {
        $id = $_SESSION['id'];
    } 

    if (isset($_POST['consultar'])) {
        $diaSemana = $_POST['dia'];
        $datosUsuarioClases = $bd->mostrarUsuarioClasesPorDiaSemana($id, $diaSemana);
    } 

    if (isset($_POST['botonBorrar'])) {
        $diaSemana = $_POST['dia'];
        $idClase = $_POST['idClase'];
        $bd->borrarClase($id, $idClase);
        $datosUsuarioClases = $bd->mostrarUsuarioClasesPorDiaSemana($id, $diaSemana);
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
        }

        .left-column {
            float: left;
            width: 55%;
            text-align: center;
        }

        .input-label {
            display: inline-block; 
            font-weight: bold;
            margin-right: 10px;
            font-size: 18px;
            color: #333; 
        }

        .right-column {
            float: right;
            width: 45%;
        }

        .imagen {
            max-width: 90%;
            height: auto;
            margin: 10px;
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

        #contenedorListado {
            max-height: 400px;
            margin: 20px 20px 0 20px;
            overflow-y: auto; 
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

        select {
            font-size: 16px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 200px;
            margin-top: 10px;
        }

        .textazo {
            margin-top: 20px;
            font-size: 20px;
        }
    </style>
</head>
<body>
    <?php
    // Incluir el menú de navegación desde navbar.php
        include 'navBar.php';
    ?>
    <header>Clases diarias</header>
    <div class="container">
        <div class="left-column">
            <form method="post" action="misClases.php">
                <input type="hidden" name="paginaCorrecta" value="true">
                <div class="input-label">Elige el día de la semana: </div>
                <select name="dia">
                    <option value="lunes" <?php if(isset($diaSemana) && $diaSemana === 'lunes') echo 'selected'; ?>>Lunes</option>
                    <option value="martes" <?php if(isset($diaSemana) && $diaSemana === 'martes') echo 'selected'; ?>>Martes</option>
                    <option value="miércoles" <?php if(isset($diaSemana) && $diaSemana === 'miércoles') echo 'selected'; ?>>Miércoles</option>
                    <option value="jueves" <?php if(isset($diaSemana) && $diaSemana === 'jueves') echo 'selected'; ?>>Jueves</option>
                    <option value="viernes" <?php if(isset($diaSemana) && $diaSemana === 'viernes') echo 'selected'; ?>>Viernes</option>
                    <option value="sábado" <?php if(isset($diaSemana) && $diaSemana === 'sábado') echo 'selected'; ?>>Sábado</option>
                    <option value="domingo" <?php if(isset($diaSemana) && $diaSemana === 'domingo') echo 'selected'; ?>>Domingo</option>
                </select>
                <div class="buttons-container">
                    <button class="button" type="submit" name="consultar">Consultar</button>
                </div>
            </form>
            <div class="textazo">Aquí aparecerán las clases en el día que has seleccionado.</div>

            <div id="contenedorListado">
                <ul id="listadoClases">
                    <?php 
                    foreach ($datosUsuarioClases as $usuario_clase) {
                        $idClase = $usuario_clase->getIdClase();
                        $clase = $bd->obtenerClasePorId($idClase);

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
                            <form class="formulario-clase" method="post" action="misClases.php" onsubmit="return validarFormulario(this)">
                                <input type="hidden" name="paginaCorrecta" value="true">
                                <input type="hidden" name="dia" value="<?php echo $diaSemana ?>">
                                <input type="hidden" name="idClase" value="<?php echo $clase->getIdClase(); ?>">
                                <button class="botonBorrar" type="submit" name="botonBorrar">x</button>
                            </form>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div class="right-column">
            <img class="imagen" src="images/imagenMisClases.jpg" alt="Imagen 1">
            <img class="imagen" src="images/imagenMisClases2.webp" alt="Imagen 2">
        </div>
    </div>
</body>
<script>
    // Esta función se ejecutará cuando se envíe el formulario
    function validarFormulario(formulario) {
        
        var confirmar = confirm('¿Seguro que deseas eliminar esta clase?');
        
        if (confirmar) {
            alert('La clase se ha eliminado correctamente.');
            return true; 
        } else {
            alert('Se ha cancelado la operación.');
            return false; 
        }
    }
</script>
</html>