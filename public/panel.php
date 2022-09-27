<?php

require __DIR__ . "./../jossecurity.php";

if (isset($_SESSION['id_usuario'])) {
    header("Location: ./admin/");
}

login_cookie("users");

if (file_exists("./../installer.php")){
    unlink('./../installer.php');
}

?>
<!doctype html>
<html lang="es-MX">

<head>
  <title><?php echo $nombre_app," versión: ", $version_app; ?></title>
  <link rel="shortcut icon" href="./resourses/img/logo transparente/vector/default.svg" type="image/x-icon">
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <?php head(); ?>

</head>

<body>

    <nav class="navbar navbar-expand-sm navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="https://github.com/josprox/JosSecurity"><?php echo $nombre_app; ?></a>
            <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavId">
                <ul class="navbar-nav me-auto mt-2 mt-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="./panel" aria-current="page">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://josprox.com/">Sitio web</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Otros proyectos</a>
                        <div class="dropdown-menu" aria-labelledby="dropdownId">
                            <a class="dropdown-item" href="https://github.com/josprox/Cetis-CWP">Cetis CWP</a>
                            <a class="dropdown-item" href="https://github.com/josprox/Facilito">Facilito f(x)</a>
                        </div>
                    </li>
                </ul>
            </div>
    </div>
    </nav>


    <div class="container">

        <?php
        if($_ENV['DEBUG'] ==1){?>

        <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <strong>Advertencia</strong> Actualmente tienes el modo DEBUG activado, si estás en modo prueba no hay de que preocuparse, si estás en un entorno de producción favor de desactivar el modo DEBUG en el panel de administración o modificando el archivo .env.
        </div>

        <div class="alert alert-primary" role="alert">
          <h4 class="alert-heading"><?php echo $nombre_app; ?></h4>
          <p>Sistema de control de datos. Versión: <?php echo $version_app; ?>.</p>
          <hr>
          <p class="mb-0" align="justify">Muchas gracias por instalar <?php echo $nombre_app; ?>, para poder usar la librería deberas incluir al archivo jossecurity.php en tus archivos principales del proyecto.</p>
        </div>

        <?php
        }
        ?>
        
        <script>
          var alertList = document.querySelectorAll('.alert');
          alertList.forEach(function (alert) {
            new bootstrap.Alert(alert)
          })
        </script>
        


    </div>

    <?php
    if (isset($_POST["ingresar"])){
        if(recaptcha() == TRUE){
            login_admin($_POST['txtCorreo'],$_POST['txtPassword'],"users","./admin/");
        }
        if (recaptcha() == FALSE){
            echo "
            <script>
                Swal.fire(
                'Falló',
                'El inicio de sesión ha fallado, favor de volver a intentarlo.',
                'error'
                )
            </script>";
        }
    }

    ?>

    <div class="container">
        
        <div class="row">

            <div class="col-md-4">
            </div>

            <div class="col-md-4">
                <br>
                <div class="card">
                    <div class="card-header">
                        Inicio de sesión
                    </div>
                    <div class="card-body">
                        
                        <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">

                            <div class="mb-3">
                              <label for="txtCorreo" class="form-label">Correo:</label>
                              <input type="email" class="form-control" name="txtCorreo" id="txtCorreo" aria-describedby="helpId" placeholder="Inserta tu usuario">
                            </div>

                            <div class="mb-3">
                                <label for="txtPassword" class="form-label">Contraseña:</label>
                                <input type="password" class="form-control" name="txtPassword" id="txtPassword" aria-describedby="helpId" placeholder="Inserta tu contraseña">
                              </div>

                              <div class="mb-3">
                                <div class="g-recaptcha" data-sitekey="<?php echo $_ENV['RECAPTCHA_CODE_PUBLIC']; ?>"></div>
                              </div>

                            <button type="submit" name="ingresar" class="btn btn-success">Entrar</button>

                        </form>

                    </div>
                    <div class="card-footer text-muted">
                        JOSPROX MX | Internacional
                        <a href="./reset">Olvidé mi contraseña</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
            </div>
            
        </div>
    </div>

    <br>

    <div class="container">
    <?php
        if($_ENV['DEBUG'] !=1){?>

            <div class="alert alert-success" role="alert">
                <strong><?php echo $nombre_app; ?></strong> El sistema se encuentra funcionando.
            </div>
            

        <?php
        }
        ?>
    
    </div>

    <?php footer(); ?>
    
    <script>
      var alertList = document.querySelectorAll('.alert');
      alertList.forEach(function (alert) {
        new bootstrap.Alert(alert)
      })
    </script>
    

</body>

</html>