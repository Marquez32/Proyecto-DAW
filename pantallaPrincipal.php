<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Pantalla principal</title>

    <style>
      .contenedorEjercicios,
      .contenedorClases,
      .contenedorDietas {
        overflow: auto;
        margin-bottom: 20px;
      }

      .contenedorEjercicios::after,
      .contenedorClases::after,
      .contenedorDietas::after {
        content: "";
        display: table;
        clear: both;
      }

      .contenedorEjercicios h1,
      .contenedorClases h1,
      .contenedorDietas h1 {
        text-align: center;
        font-size: 32px; 
        color: #2f4f4f; 
        text-transform: uppercase; 
        margin-bottom: 10px; 
      }

      .contenedorEjercicios img,
      .contenedorDietas img {
        float: left;
        margin-left: 25px;
        margin-right: 25px;
        width: 35%;
        height: 35%;
      }

      .contenedorClases img {
        float: right;
        margin-left: 25px;
        margin-right: 25px;
        width: 35%;
        height: 35%;
      }

      .contenedorEjercicios p,
      .contenedorClases p,
      .contenedorDietas p {
        overflow: hidden;
      }

      .contenedorEjercicios p#textoEjercicios,
      .contenedorDietas p#textoDietas {
        margin-left: 0;
        margin-right: 25px;
      }
      .contenedorClases p#textoClases {
        margin-right: 0;
        margin-left: 25px;      
      }

      p {
        font-family: Arial, sans-serif;
        font-size: 20px;
        line-height: 1.5;
        color: #333;
        margin-bottom: 10px;
      }

      body {
        background-color: #e0ffff;
      }
    </style>

  </head>
  <body>
    <?php
      // Incluye el menú de navegación desde navbar.php
        include 'navBar.php';
    ?>
    <div class="contenedorEjercicios">
      <h1>Ejercicios</h1>
      <img id="imgEjercicios" src="images/principal_ejercicios.webp" alt="Ejercicios">
      <p id="textoEjercicios">
        En nuestro gimnasio tenemos una gran variedad de máquinas para hacer diferentes ejercicios. 
        También contamos con varios monitores que te pueden aconsejar a la hora de hacer deporte 
        según tus necesidades.<br/>
        Para añadir ejercicios a tu rutina debes ir al apartado de "ejercicios" y pulsar el botón +.
        Una vez añadidos puedes ir a la pestaña "mis ejercicios" donde podrás ver los ejercicios que has 
        seleccionado.
      </p>
    </div>
    <div class="contenedorClases">
      <h1>Clases</h1>
      <img id="imgClases" src="images/principal_clases.jpg" alt="Clases">
      <p id="textoClases">
        Tenemos una gran variedad de clases grupales. Cada una de ellas tiene diferente intensidad por lo que
        puedes apuntarte a la clase en la que estés más cómodo. Cada clase tiene un horario diferente según el día 
        de la semana. Cualquier duda la puede consultar con los monitores o con el personal del gimnasio.<br/> 
        Para añadir clases a tu rutina debes ir al apartado de "clases" y pulsar el botón +.
        Una vez añadidos puedes ir a la pestaña "mis clases" donde podrás ver las clases que has 
        seleccionado.
      </p>
    </div>
    <div class="contenedorDietas">
      <h1>Dietas</h1>
      <img id="imgDietas" src="images/principal_dietas.jpeg" alt="Dietas">
      <p id="textoDietas">
        Contamos con un excelente servicio de nutrición. Solamente nos tienes que proporcionar tus datos
        y tus objetivos y nuestro personal le proporcionará una dieta personalizada que le ayude a cumplir
        estos objetivos. <br/>
        Para añadir una dieta debes ir al apartado dietas, seleccionar la dieta que deseas y pulsar el botón 
        "añadir dieta". En cualquier momento puedes eliminar esta dieta o cambiarla por otra dieta.
      </p>
    </div>
  </body>
</html>