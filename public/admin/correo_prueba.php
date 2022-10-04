<?php

include (__DIR__ . "/../../jossecurity.php");

login_cookie("users");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../panel");
}
$iduser = $_SESSION['id_usuario'];

if(isset($_POST['salir'])){
  logout($iduser,"users");
  header("Location: ./../panel");
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
  <script src="./../../node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>

</head>

<body>

  <?php navbar_admin(); ?>

  <br>

  <div class="container">

    <?php 
    if($_ENV['SMTP_ACTIVE'] != 1){?>

    <div class="alert alert-warning" role="alert">
        <strong>Advertencia:</strong> El sistema para enviar correos se encuentra desactivado, favor de activarlo en el archivo de configuración env.
    </div>
    
    <?php
    }
    ?>

    <?php
    
    if(isset($_POST['mail'])){
        mail_smtp_v1_3_check($_POST['correo']);
        echo "
        <script>
        Swal.fire(
        'Enviado',
        'El mensaje ha sido enviado con éxito',
        'success'
        )
    </script>
        ";
        }

    ?>
        <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
        <div class="mb-3 row">
            <div class="mb-3 row">
                <label for="inputName" class="col-4 col-form-label">correo</label>
                <div class="col-8">
                    <input type="email" class="form-control" name="correo" id="correo" placeholder="correo">
                </div>
            </div>
            <div class="mb-3 row">
                <div class="offset-sm-4 col-sm-8">
                    <button type="submit" name="mail" class="btn btn-primary">Enviar</button>
                </div>
            </div>
        </form>
    </div>

  <!-- Bootstrap JavaScript Libraries -->
  <?php footer_admin(); ?>
  <script src="../node_modules/jquery/dist/jquery.min.js"></script>
</body>

</html>