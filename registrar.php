<?php

  $carga = fn($clase)=> require "bbdd/$clase.php";
  spl_autoload_register($carga);

  $bd = new BD();

  //Comprobamos si venimos desde el login
  $paginaCorrecta = $_GET['paginaCorrecta'] ?? $_POST['paginaCorrecta']  ?? false;
  if(!isset($paginaCorrecta) || !$paginaCorrecta) {
      header("Location:login.php");
      exit();
  }

  $nombre = "";
  $apellidos = "";
  $nick = "";
  $contrasena = "";
  $repetir_contrasena = "";
  $correo = "";
  $telefono = "";
  $fecha_nacimiento = "";

  $idImagen = null;
  $error_mensaje = "";

  if(isset($_POST["Registrarse"])) {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $nick = $_POST['nick'];
    $contrasena = $_POST['contrasena'];
    $repetir_contrasena = $_POST['repetir_contrasena'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];

    // Verificamos si se ha enviado un archivo
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
      // Obtenemos el nombre temporal del archivo
      $imagen_tmp_name = $_FILES['imagen']['tmp_name'];

      // Leemos el contenido del archivo en binario
      $imagen_contenido = file_get_contents($imagen_tmp_name);

      // Escapamos el contenido para evitar inyección SQL (opcional, pero recomendado)
      $imagen_contenido = addslashes($imagen_contenido);

      // Guardamos el contenido de la imagen en la base de datos
      $bd->insertarImagen($imagen_contenido);

      $idImagen = $bd->obtenerIdImagen();
    }

    if(!$bd->comprobarNick($nick)) {
      $error_mensaje = "Error: El nick ya existe. Pruebe con otro.";
    }
    else if($contrasena != $repetir_contrasena) {
      $error_mensaje = "Error: Los campos contraseña y repetir contraseña deben ser iguales.";
    }
    else if($telefono != "" && !preg_match('/^\d{9}$/', $telefono)) {
      $error_mensaje = "Error: El teléfono debe tener exáctamente 9 dígitos.";
    }
    else {

      $bd->agnadirUsuario($nombre, $apellidos, $nick, $contrasena, 
      $correo, $telefono, $fecha_nacimiento, $idImagen);
      
      echo '<script>alert("Usuario registrado correctamente."); window.location.href = "login.php";</script>';

    }

  }

?>


<!DOCTYPE html>
<html>
<head>
  <title>Formulario registro</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
      margin: 0;
      padding: 20px;
    }

    h2 {
      color: #333333;
      text-align: center;
    }

    form {
      max-width: 400px;
      margin: 0 auto;
      background-color: #ffffff;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    label {
      display: block;
      margin-bottom: 10px;
      font-weight: bold;
      color: #666666;
    }

    input[type="text"],
    input[type="password"],
    input[type="email"],
    input[type="tel"],
    input[type="date"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #cccccc;
      border-radius: 4px;
      box-sizing: border-box;
      margin-bottom: 20px;
    }

    input[type="button"], 
    input[type="submit"] {
      background-color: #4CAF50;
      color: #ffffff;
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    input[type="button"]:hover, 
    input[type="submit"]:hover {
      background-color: #45a049;
    }
  </style>
</head>
<body>
  <h2>Formulario de Registro</h2>
  <form action="registrar.php" method="post" enctype="multipart/form-data">
    <?php if (!empty($error_mensaje)) { ?>
        <span style="color: red;"><?php echo $error_mensaje; ?></span><br>
    <?php } ?>
    <br>

    <input type="hidden" name="paginaCorrecta" value="true">

    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>" required><br><br>

    <label for="apellidos">Apellidos:</label>
    <input type="text" id="apellidos" name="apellidos" value="<?php echo $apellidos; ?>" required><br><br>

    <label for="nick">Nick:</label>
    <input type="text" id="nick" name="nick" value="<?php echo $nick; ?>" required><br><br>

    <label for="contrasena">Contraseña:</label>
    <input type="password" id="contrasena" name="contrasena" value="<?php echo $contrasena; ?>" required><br><br>

    <label for="repetir_contrasena">Repetir Contraseña:</label>
    <input type="password" id="repetir_contrasena" name="repetir_contrasena" value="<?php echo $repetir_contrasena; ?>" required><br><br>

    <label for="correo">Correo Electrónico: (opcional)</label>
    <input type="email" id="correo" name="correo" value="<?php echo $correo; ?>" ><br><br>

    <label for="telefono">Teléfono: (opcional)</label>
    <input type="tel" id="telefono" name="telefono" value="<?php echo $telefono; ?>" ><br><br>

    <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo $fecha_nacimiento; ?>" required><br><br>

    <label for="imagen">Imagen de perfil: (opcional)</label>
    <input type="file" id="imagen" name="imagen" accept="image/*" ><br><br>

    <input type="button" value="Volver" onclick="window.location.href='login.php'">
    <input type="submit" name="Registrarse" value="Registrarse">
    
  </form>
</body>
</html>