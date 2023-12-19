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

    if(isset($_POST["Guardar"])) {
        $contrasegna = $_POST['contrasena'];
        $repetir_contrasegna = $_POST['repetir_contrasena'];
        $correo = $_POST['correo'];
        $telefono = $_POST['telefono'];
        $idImagen = null;

        // Verificamos si se ha enviado un archivo
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            // Obtenemos el nombre temporal del archivo
            $imagen_tmp_name = $_FILES['imagen']['tmp_name'];

            // Leemos el contenido del archivo en binario
            $imagen_contenido = file_get_contents($imagen_tmp_name);

            // Escapamos el contenido para evitar inyección SQL
            $imagen_contenido = addslashes($imagen_contenido);

            // Guardamos el contenido de la imagen en la base de datos
            $bd->insertarImagen($imagen_contenido);

            $idImagen = $bd->obtenerIdImagen();
        }
        if (isset($_POST['checkEliminarFoto']) && $_POST['checkEliminarFoto'] === 'eliminarFoto') {
          $bd->actualizarUsuarioImagenNula($id, null);
        } 

        if($idImagen == null) {
          $bd->actualizarUsuarioSinImagen($id, $contrasegna, $correo, $telefono);
        }
        else {
          $bd->actualizarUsuario($id, $contrasegna, $correo, $telefono, $idImagen);
        }
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

<!DOCTYPE html>
<html>
<head>
  <title>Mi perfil</title>
  <style>
    body {
      background-color: #f2f2f2;
      margin: 0;
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

    span {
      font-size: 14px;
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

    .checkbox-container {
      display: flex;
      align-items: center;
      margin-top: 20px; 
      margin-bottom: 20px;
    }

    input[type="checkbox"] {
      transform: scale(1.25); 
      margin-left: 10px;
      margin-right: 10px; 
    }

    input[type="button"], 
    input[type="submit"] {
      background-color: #4CAF50;
      color: #ffffff;
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      margin-top: 10px;
      margin-right: 10px;
    }

    input[type="button"]:hover, 
    input[type="submit"]:hover {
      background-color: #45a049;
    }

    .divImagen {
      display: flex; 
    }

    .botones {
      display: flex; 
      justify-content: center;
    }

    .imagenPerfil {
      margin-left: 10px;
      max-width: 200px; 
    }
  </style>
</head>
<body>
    <?php
      // Incluir el menú de navegación desde navbar.php
      include 'navBar.php';
    ?>
  <h2>Editar perfil</h2>
  <form action="miPerfil.php" method="post" enctype="multipart/form-data" onsubmit="return validarFormulario(this)">
    
    <br>

    <input type="hidden" name="paginaCorrecta" value="true">

    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre" value="<?php echo $usuario->getNombre(); ?>" disabled><br><br>

    <label for="apellidos">Apellidos:</label>
    <input type="text" id="apellidos" name="apellidos" value="<?php echo $usuario->getApellidos(); ?>" disabled><br><br>

    <label for="nick">Nick:</label>
    <input type="text" id="nick" name="nick" value="<?php echo $usuario->getNick(); ?>" disabled><br><br>

    <label for="contrasena">Contraseña:</label>
    <input type="password" id="contrasena" name="contrasena" value="<?php echo $usuario->getContrasegna(); ?>" readonly required><br><br>

    <label for="repetir_contrasena">Repetir Contraseña:</label>
    <input type="password" id="repetir_contrasena" name="repetir_contrasena" value="<?php echo $usuario->getContrasegna(); ?>" readonly required><br><br>

    <label for="correo">Correo Electrónico:</label>
    <input type="email" id="correo" name="correo" value="<?php echo $usuario->getCorreo(); ?>" readonly><br><br>

    <label for="telefono">Teléfono:</label>
    <input type="tel" id="telefono" name="telefono" value="<?php echo $usuario->getTelefono(); ?>" readonly><br><br>

    <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo $usuario->getFechaNacimiento(); ?>" disabled><br><br>
    
    <label for="imagen">Seleccionar nueva imagen de perfil:</label>
    <input type="file" id="imagen" name="imagen" accept="image/*" disabled><br><br>

    <div class="divImagen">
      <?php 
        if(isset($data_uri)) {
          echo '<label for="imagenActual">Imagen actual de perfil:</label>';
          echo '<img src="' . $data_uri . '" class="imagenPerfil" name="imagenActual "alt="Imagen de perfil">';
        }
      ?>
    </div>
    
    <div class="checkbox-container">
      <span>Marque el check para eliminar la foto de perfil: </span>
      <input type="checkbox" id="checkEliminarFoto" name="checkEliminarFoto" value="eliminarFoto" disabled>
    </div>
      
      <div class="botones">
        <input type="button" name="Editar" value="Editar perfil" onclick="habilitarEdicion()">
        <input type="submit" name="Guardar" value="Guardar" style="display: none;">
      </div>
    </div>
  </form>

  <script>
    function habilitarEdicion() {
      // Obtener todos los campos de entrada
      var campos = document.querySelectorAll("input[type='text'], input[type='password'], input[type='email'], input[type='tel'], input[type='date']");
      var archivos = document.querySelectorAll("input[type='file'], input[type='checkbox']");
      // Habilitar la edición de los campos
      campos.forEach(function (campo) {
        campo.removeAttribute("readonly");
      });

      archivos.forEach(function (archivo) {
        archivo.removeAttribute("disabled");
      });

      // Ocultar el botón "Editar" y mostrar el botón "Guardar"
      var botonEditar = document.querySelector("input[value='Editar perfil']");
      var botonGuardar = document.querySelector("input[value='Guardar']");
      botonEditar.style.display = "none";
      botonGuardar.style.display = "inline-block";
    }

    // Esta función se ejecutará cuando se envíe el formulario
    function validarFormulario(formulario) {

        var contrasena = formulario.contrasena.value;
        var repetir_contrasena = formulario.repetir_contrasena.value;

        if(contrasena != repetir_contrasena) {
          alert('Error: Los campos contraseña y repetir contraseña deben ser iguales.');
          return false;
        }

        var telefono = formulario.telefono.value;

        // Validar el número de teléfono (debe tener exactamente 9 dígitos)
        if (telefono !== "" && !/^\d{9}$/.test(telefono)) {
            alert('Error: El teléfono debe tener exactamente 9 dígitos.');
            return false; // Evitar que se envíe el formulario
        }

        // Mostrar el confirm aquí
        var confirmar = confirm('¿Seguro que deseas guardar los datos?');
        
        // Si el usuario acepta el confirm, se envía el formulario
        if (confirmar) {
            alert('Los datos se han guardado correctamente.');
            return true; // Aquí se agrega el ejercicio si el usuario acepta el confirm
        } else {
            alert('Se ha cancelado la operación.');
            return false; // Si el usuario cancela, no se envía el formulario
        }
    }
  </script>
</body>
</html>