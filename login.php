<?php

  $carga = fn($clase)=> require "bbdd/$clase.php";
  spl_autoload_register($carga);

  $bd = new BD();

  $error_mensaje = "";

  if(isset($_POST['loginSubmit'])) {
    $nick = $_POST['nick'];
    $contrasegna = $_POST['contrasegna'];

    $usuario = $bd->comprobarNickYContrasegna($nick, $contrasegna);

    if($usuario != null) {
      session_start();
      $_SESSION['id'] = $usuario->getID();

      header("Location:pantallaPrincipal.php?paginaCorrecta=true");
      exit();
    }
    else {
      $error_mensaje = "El nick o la contraseña son incorrectos.";
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Gimnasio</title>

    <style> 
      #bodyLogin {
          background: url('../images/loginGym.webp');
          background-size: cover;
      }

      #containerLogin {
          display: flex;
          justify-content: center;
          align-items: center;
          height: 100vh;
      }

      #textoRegistrar {
          text-decoration: underline;
      }
    </style>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
  </head>

  <body id="bodyLogin">
  <div id="containerLogin" class="container-fluid">
      <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
          <div class="card">
            <img src="images/panelLogin.jpg" class="card-img-top">
            <div class="card-body">
              <center>
              <h5>Inicio sesión</h5><br>
              <form class="form-group" method="POST">
                <div class="row">
                  <div class="col-md-4"><label>Nick: </label></div>
                  <div class="col-md-8"><input type="text" name="nick" class="form-control" placeholder="Introduzca el nick" required/></div><br><br>
                  <div class="col-md-4"><label>Contraseña: </label></div>
                  <div class="col-md-8"><input type="password" class="form-control" name="contrasegna" placeholder="Introduzca la contraseña" required/></div><br><br><br>
                </div>
                <center><input type="submit" id="inputbtn" name="loginSubmit" value="Login" class="btn btn-primary"></center>
                
                <br>
                <?php if (!empty($error_mensaje)) { ?>
                    <span style="color: red;"><?php echo $error_mensaje; ?></span><br>
                <?php } ?>
              </form>
              <a id="textoRegistrar" href="registrar.php?paginaCorrecta=true">Sino está registrado, pulse aquí</a>
            
            </center>
            </div>
          </div>
        </div>
         <div class="col-md-7"></div>
      </div>
  </body>
</html>