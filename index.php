<?php

require __DIR__ . "/jossecurity.php";

?>
<!doctype html>
<html lang="es-MX">

<head>
  <title><?php echo $nombre_app," versión: ", $version_app; ?></title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.0-beta1 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css"
    integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

    <?php head(); ?>

</head>

<body>

    <nav class="navbar navbar-expand-sm navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="http://github.com/josprox/JosSecurity"><?php echo $nombre_app; ?></a>
            <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavId">
                <ul class="navbar-nav me-auto mt-2 mt-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="./" aria-current="page">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https//josprox.com/">Sitio web</a>
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

        <div class="alert alert-primary" role="alert">
          <h4 class="alert-heading"><?php echo $nombre_app; ?></h4>
          <p>Sistema de control de datos. Versión: <?php echo $version_app; ?>.</p>
          <hr>
          <p class="mb-0" align="justify">Muchas gracias por instalar <?php echo $nombre_app; ?>, este es el apartado principal donde deberás incluir en php cualquier función a usar dentro de php.</p>
        </div>

    </div>

    <?php
    if (isset($_POST["ingresar"])){
        login($host,$user,$pass,$DB,$_POST['txtCorreo'],$_POST['txtPassword'],"users");
        header("Location: ./admin/");
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

                            <button type="submit" name="ingresar" class="btn btn-success">Entrar</button>

                        </form>

                    </div>
                    <div class="card-footer text-muted">
                        JOSPROX MX | Internacional
                    </div>
                </div>
            </div>

            <div class="col-md-4">
            </div>
            
        </div>
    </div>

    
    <script>
      var alertList = document.querySelectorAll('.alert');
      alertList.forEach(function (alert) {
        new bootstrap.Alert(alert)
      })
    </script>
    

  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js"
    integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js"
    integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous">
  </script>
</body>

</html>