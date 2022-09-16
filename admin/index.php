<?php

include __DIR__ . "/../jossecurity.php";

login_cookie($host,$user,$pass,$DB,"users");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../");
}

$iduser = $_SESSION['id_usuario'];

$row = consulta_mysqli($host,$user,$pass,$DB,"name","users","","where","id",$iduser,"");

if(isset($_POST['salir'])){
  logout($host,$user,$pass,$DB,$iduser,"users");
  header("Location: ./../");
}

?>

<!doctype html>
<html lang="es-MX">

<head>
  <title><?php echo $nombre_app," versión: ", $version_app; ?></title>
  <?php head_admin(); ?>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

</head>

<body>

  <?php navbar_admin(); ?>

  <br>

  <div class="container">

  <?php
    if($_ENV['DEBUG'] ==1){
  ?>

    <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    <strong>Advertencia</strong> Actualmente tienes el modo DEBUG activado, si estás en modo prueba no hay de que preocuparse, si estás en un entorno de producción favor de desactivar el modo DEBUG en el panel de administración o modificando el archivo .env.
    </div>

  <?php
    }
  ?>

  <h1 align="center">Bienvenido a <?php echo $nombre_app; ?></h1>
  <p align="center">Un gusto volver a verte <?php echo $row['name']; ?></p>
  <p align="center">Versión: <?php echo $version_app; ?></p>


  <div class="card">
    <img class="card-img-top" src="./../resourses/img/logo azul/cover.png" alt="Title">
  </div>

  <br>

  </div>

  <!-- Bootstrap JavaScript Libraries -->
  <?php footer_admin(); ?>
  <script src="../node_modules/jquery/dist/jquery.min.js"></script>
</body>

</html>