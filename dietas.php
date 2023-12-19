<?php
    $carga = fn($clase)=> require "bbdd/$clase.php";
    spl_autoload_register($carga);

    $bd = new BD();
    $datosUsuarioClases = array();

    session_start();

    $consulta = true;

    // Acceder al ID del usuario almacenado en la variable de sesión
    if (isset($_SESSION['id'])) {
        $id = $_SESSION['id'];
    }

    $usuario = $bd->obtenerUsuarioPorId($id);
    $idDieta = $usuario->getIdDieta();
    if(isset($idDieta)) {
        $dieta = $bd->obtenerDietaPorId($idDieta);
    }

    if(isset($_POST['consultar'])) {
        $consulta = true;
        $tipoDieta = $_POST['tipoDieta'];
        $dieta = $bd->obtenerDietaPorTipo($tipoDieta);
    }

    if(isset($_POST['agnadirDieta'])) {
        $consulta = true;
        $tipoDieta = $_POST['tipoDieta'];
        $dieta = $bd->obtenerDietaPorTipo($tipoDieta);
        $idDieta = $dieta->getIdDieta();
        $bd->actualizarDietaUsuario($id, $idDieta);
    }

    if(isset($idDieta) && isset($_POST['eliminarDieta'])) {
        $consulta = false;
        $dieta->setTipoDieta('hipocalorica');
        $idDieta = null;
        $bd->actualizarDietaUsuario($id, $idDieta);
    }

    if(isset($dieta) && $consulta) {
        $urlDieta = "https://www.google.com";
        $tipoDieta = $dieta->getTipoDieta();
        switch($tipoDieta) {
        case "hipocalorica":
            $imagen = "images/hipocalorica.jpg";
            $imagen2 = "images/hipocalorica2.jpg";
            $maxWidth = "65%";
            $maxHeight = "65%";
            $maxWidth2 = "65%";
            $maxHeight2 = "65%";
            $urlDieta = "https://www.clara.es/belleza/cuerpo/dieta-hipocalorica_13897";
            break;
        case "por puntos":
            $imagen = "images/porpuntos.jpg";
            $imagen2 = "images/puntosdieta.jpg";
            $maxWidth = "80%";
            $maxHeight = "80%";
            $maxWidth2 = "120%";
            $maxHeight2 = "120%";
            $urlDieta = "https://www.merca2.es/2019/06/22/dieta-puntos-asi-hace/";
            break;
        case "paleo":
            $imagen = "images/paleo.jpeg";
            $imagen2 = "images/paleo2.png";
            $maxWidth = "65%";
            $maxHeight = "65%";
            $maxWidth2 = "65%";
            $maxHeight2 = "65%";
            $urlDieta = "https://middlesexhealth.org/learning-center/espanol/articulos/dieta-paleo-qu-es-y-por-qu-es-tan-popular";
            break;
        case "proteica":
            $imagen = "images/proteica.jpg";
            $imagen2 = "images/proteica2.webp";
            $maxWidth = "90%";
            $maxHeight = "90%";
            $maxWidth2 = "90%";
            $maxHeight2 = "90%";
            $urlDieta = "https://www.clara.es/belleza/cuerpo/dieta-proteica_16765";
            break;
        case "detox":
            $imagen = "images/dieta_detox.jpeg";
            $imagen2 = "images/detox2.jpg";
            $maxWidth = "65%";
            $maxHeight = "65%";
            $maxWidth2 = "65%";
            $maxHeight2 = "65%";
            $urlDieta = "https://www.nutralie.com/es/blog/dieta-detox/";
            break;
        }
    } 

?>

<!DOCTYPE html>
<html>
<head>
  <title>Dietas</title>
  <style>
    body {
        margin: 0;
        padding: 0;
        background-color: #edfee2;
    }

    header {
        padding: 16px;
        color: #2f4f4f; 
        text-align: center;
        font-size: 24px;
        font-weight: bold;
    }

    h2 {
        font-size: 24px;
        color: #2f4f4f; 
        margin-left: 10px;
        border-bottom: 2px solid #2f4f4f;
        padding-bottom: 4px;
    }

    h3 {
        font-size: 18px;
        color: #2f4f4f; 
        margin-left: 10px;
    }

    p {
        margin-left: 10px;
        margin-right: 20px;
        line-height: 1.6;
    }

    .input-label {
        display: inline-block; 
        margin-left: 10px;
        margin-right: 10px;
        font-size: 18px;
        color: #333; 
    }

    select {
        font-size: 16px;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
        width: 200px; 
        margin-top: 10px;
        margin-right: 10px;
    }

    .button {
      background-color: #b35900; 
      color: white;
      padding: 10px 20px;
      font-size: 16px;
      border: none;
      cursor: pointer;
      margin-right: 10px;
      border-radius: 5px;
      transition: background-color 0.3s ease;
    }

    .button:hover {
      background-color: #944d00; 
    }

    .left-column {
        float: left;
        width: 60%;
    }

    .right-column {
        float: right;
        width: 40%;
    }

    .buttons-container {
        display: flex;
        justify-content: center; 
        margin-top: 20px;
    }

    .imagen {
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
    <header>Dietas</header>
    <div class="left-column">
        <form method="post" action="dietas.php" onsubmit="return validarFormulario(this, <?php echo $idDieta ?>);">
            <input type="hidden" name="paginaCorrecta" value="true">
            <div class="input-label">Escoja su tipo de dieta: </div>
            <select name="tipoDieta">
                <option value="hipocalorica" <?php if(isset($dieta) && $dieta->getTipoDieta() === 'hipocalorica') echo 'selected'; ?>>hipocalórica</option>
                <option value="por puntos" <?php if(isset($dieta) && $dieta->getTipoDieta() === 'por puntos') echo 'selected'; ?>>por puntos</option>
                <option value="paleo" <?php if(isset($dieta) && $dieta->getTipoDieta() === 'paleo') echo 'selected'; ?>>paleo</option>
                <option value="proteica" <?php if(isset($dieta) && $dieta->getTipoDieta() === 'proteica') echo 'selected'; ?>>proteica</option>
                <option value="detox" <?php if(isset($dieta) && $dieta->getTipoDieta() === 'detox') echo 'selected'; ?>>detox</option>
            </select>
            <button id="consultarDieta" class="button" type="submit" name="consultar">Consultar</button>
            <div class="buttons-container">
                <button id="agnadirDieta" class="button" type="submit" name="agnadirDieta">Añadir dieta</button>
                <button id="eliminarDieta" class="button" type="submit" name="eliminarDieta">Eliminar dieta</button>
            </div>
        </form>
        <?php
            if(isset($dieta) && $consulta) {
        ?>
            <h2><?php echo $dieta->getNombreDieta()?></h2>
            <h3>Descripción</h3>
            <p><?php echo $dieta->getDescripcionDieta()?></p>
            <h3>Observaciones</h3>
            <p><?php echo $dieta->getObservacionesDieta()?></p> 
            <p>
                Para obtener más información sobre esta dieta consulte en el siguiente link: 
                <a href="<?php echo $urlDieta; ?>" target="_blank"><?php echo $urlDieta; ?></a>
            </p> 
        <?php    
            }
            else {
        ?>      
            <p>
                <b>No tiene ninguna dieta asignada.</b> Pulse el botón <b>"añadir dieta"</b> si quiere empezar una dieta.<br/>
                Si quiere ver cualquier dieta solamente tiene que seleccionarla en el desplegable y pulsar el botón <b>"consultar"</b>.
            </p>  
        <?php    
            }
        ?>
        
        

    </div>
    <div class="right-column">
        <?php
            if(isset($imagen)) {
        ?>
        
        <img class="imagen" src=<?php echo $imagen?> alt="Dieta" style="max-width: <?php echo $maxWidth ?>; max-height: <?php echo $maxHeight ?>;">
        <img class="imagen" src=<?php echo $imagen2?> alt="Dieta" style="max-width: <?php echo $maxWidth2 ?>; max-height: <?php echo $maxHeight2 ?>;">
        <?php 
            } 
        ?>
    </div>
    <script>
        var botonPresionado = null;

        document.getElementById("consultarDieta").addEventListener("click", function () {
            botonPresionado = "consultar";
        });

        document.getElementById("agnadirDieta").addEventListener("click", function () {
            botonPresionado = "agnadirDieta";
        });

        document.getElementById("eliminarDieta").addEventListener("click", function () {
            botonPresionado = "eliminarDieta";
        });

        // Esta función se ejecutará cuando se envíe el formulario
        function validarFormulario(formulario, idDieta) {
            var mensajePregunta = "";
            var mensajeExito = "";

            // Determina qué botón se presionó y establece el mensaje en consecuencia
            if (botonPresionado === "agnadirDieta") {
                mensajePregunta = "¿Seguro que deseas añadir esta dieta? Si tienes otra dieta asignada se eliminará y se sustituirá por la nueva dieta.";
                mensajeExito = "La dieta se ha añadido correctamente.";
            } else if (botonPresionado === "eliminarDieta" && idDieta != null) {
                mensajePregunta = "¿Seguro que deseas eliminar tu dieta actual?";
                mensajeExito = "La dieta se ha eliminado correctamente.";
            }

            if(mensajePregunta != "") {
                var confirmar = confirm(mensajePregunta);
                
                if (confirmar) {
                    alert(mensajeExito);
                    return true; 
                } else {
                    alert('Se ha cancelado la operación.');
                    return false; 
                }
            }
        }
    </script>
</body>
</html>