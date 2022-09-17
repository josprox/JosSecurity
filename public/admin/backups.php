<?php

include __DIR__ . "/../../jossecurity.php";

login_cookie($host,$user,$pass,$DB,"users");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../");
}

$iduser = $_SESSION['id_usuario'];

if($_ENV['PLUGINS'] != 1){
  header("location: ./");
}

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

    <h1 align="Center">Sistema de respaldo</h1>
    <p align="justify">Tener un respaldo garantiza que los datos estén seguros y que la información crítica no se pierda. Esto aplica para proteger configuración, robo de datos o cualquier otro tipo de emergencia.</p>

    <h2 align="center">Respaldar archivos</h2>

    <?php
    if(isset($_POST['respaldo'])){
      $archivo = cortana();
    }
    ?>

    <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
    <center>
      <button name="respaldo" type="submit" class="btn btn-warning">Respaldar</button>
    </center>
    </form>

    <h2 align="center">Realizar respaldo SQL</h2>

    <?php
    if(isset($_POST['respaldo_sql'])){
      echo "<p align='center'>El respaldo ha funcionado</p>";
      $archivo = sql_export($host,$user,$pass,$DB);
    }
    ?>

    <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
    <center>
      <button name="respaldo_sql" type="submit" class="btn btn-warning">Respaldar</button>
    </center>
    </form>

  </div>

  <!-- Bootstrap JavaScript Libraries -->
  <?php footer_admin(); ?>
  <script src="../node_modules/jquery/dist/jquery.min.js"></script>
</body>

</html>