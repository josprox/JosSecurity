<?php

// JosSecurity, la mejor seguridad al alcance de tus manos.
require __DIR__ . './vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

date_default_timezone_set($_ENV['ZONA_HORARIA']);
$fecha = date("Y-m-d H:i:s");

$host = $_ENV['HOST'];
$user = $_ENV['USUARIO'];
$pass = $_ENV['CONTRA'];
$DB = $_ENV['BASE_DE_DATOS'];

echo "<script>console.log('JosSecurity está funcionando');</script>";

function head(){
    echo "<script>console.log('JosSecurity Head está activo');</script>";
    include "./routes/head.php";
}


function footer(){
    echo "<script>console.log('JosSecurity footer está activo');</script>";
}

function conect_mysqli($host,$user,$pass,$database){
    $conexion = new mysqli("$host","$user", "$pass","$database");;
    $conexion->set_charset("utf8");
    
    // AGREGANDO CHARSET UTF8
    if (!$conexion->set_charset("utf8")) {
        printf("Error código JSS_utf8, no se puede cargar el conjunto de caracteres utf8: %s\n", $conexion->error);
        exit();
    }
    
    if($conexion == TRUE){
        echo "<script>console.log('La conexión mysqli ha funcionado');</script>";
    }else{
        echo "<script>console.log('La conexión mysqli ha fallado');</script>";
    }

}

function conect_mysql($host,$database,$user,$pass){

    try {
        $pdo = new PDO('mysql:host='.$host.';dbname='.$database.'', $user, $pass);
        //echo "conectado";
    } catch (PDOException $e) {
        print "¡Error!: " . $e->getMessage() . "<br/>";
        die();
    }

    if($pdo == TRUE){
        echo "<script>console.log('La conexión mysql ha funcionado');</script>";
    }else{
        echo "<script>console.log('La conexión mysql ha fallado');</script>";
    }
}

function mail_smtp_v1_3($nombre,$asunto,$cuerpo,$correo){
    $nombre = $nombre;
    $asunto = $asunto;
    $cuerpo = $cuerpo;
    $correo = $correo;
    require "./config/correo.php";

}

conect_mysqli($host,$user,$pass,$DB);
conect_mysql($host,$DB,$user,$pass);

if(isset($_POST['mail'])){
	$nombre = $_POST['nombre'];
	$asunto = $_POST['asunto'];
	$cuerpo = $_POST['cuerpo'];
	$correo = $_POST['correo'];
    mail_smtp_v1_3($nombre,$asunto,$cuerpo,$correo);
    echo "<script>console.log('Se ha mandado un correo');</script>";
}


?>

<!doctype html>
<html lang="es-MX">

<head>
  <title>Title</title>
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
            <a class="navbar-brand" href="http://github.com/josprox/JosSecurity">JosSecurity</a>
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
          <h4 class="alert-heading">JosSecurity</h4>
          <p>Sistema de control de datos</p>
          <hr>
          <p class="mb-0">Muchas gracias por instalar JosSecurity, este es el apartado principal donde deberás incluir en php cualquier función a usar dentro de php.</p>
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