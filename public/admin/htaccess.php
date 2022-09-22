<?php

include __DIR__ . "/../../jossecurity.php";

login_cookie("users");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../");
}
$iduser = $_SESSION['id_usuario'];

if(isset($_POST['salir'])){
  logout($iduser,"users");
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

    <?php edit_file("Reglas htaccess","../../.htaccess"); ?>


  </div>

  <!-- Bootstrap JavaScript Libraries -->
  <?php footer_admin(); ?>
  <script src="../node_modules/jquery/dist/jquery.min.js"></script>
</body>

</html>