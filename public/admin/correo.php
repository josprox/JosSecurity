<?php

include __DIR__ . ("/../../jossecurity.php");

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
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <?php head_admin(); ?>

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
        mail_smtp_v1_3($_POST['nombre'],$_POST['asunto'],$_POST['cuerpo'],$_POST['correo']);
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
                <label for="inputName" class="col-4 col-form-label">Nombre</label>
                <div class="col-8">
                    <input type="text" class="form-control" name="nombre" id="nombre" placeholder="nombre">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="inputName" class="col-4 col-form-label">Asunto</label>
                <div class="col-8">
                    <input type="text" class="form-control" name="asunto" id="asunto" placeholder="asunto">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="inputName" class="col-4 col-form-label">correo</label>
                <div class="col-8">
                    <input type="email" class="form-control" name="correo" id="correo" placeholder="correo">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="inputName" class="col-4 col-form-label">cuerpo</label>
                <textarea name="contenido" class="form-control textarea" id="textarea" rows="3"></textarea>
            </div>
            <div class="mb-3 row">
                <div class="offset-sm-4 col-sm-8">
                    <button type="submit" name="mail" class="btn btn-primary">Enviar</button>
                </div>
            </div>
        </form>
    </div>


  <?php footer_admin(); ?>
</body>

</html>