<?php

// JosSecurity, la mejor seguridad al alcance de tus manos.
require __DIR__ . './vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
session_start();


//Configuración por defecto de JosSecurity
date_default_timezone_set($_ENV['ZONA_HORARIA']);
$fecha = date("Y-m-d H:i:s");
$nombre_app = $_ENV['NAME_APP'];
$version_app = $_ENV['VERSION'];

$host = $_ENV['HOST'];
$user = $_ENV['USUARIO'];
$pass = $_ENV['CONTRA'];
$DB = $_ENV['BASE_DE_DATOS'];

echo "<script>console.log('".$nombre_app." está funcionando.');</script>";

function head(){
    echo "<script>console.log('".$_ENV['NAME_APP']." Head está activo.');</script>";
    include __DIR__ . "./routes/head.php";
}


function footer(){
    echo "<script>console.log('".$_ENV['NAME_APP']." footer está activo.');</script>";
}

if ($_ENV['CONECT_DATABASE'] == 1){

    echo "<script>console.log('Se ha activado la función para usar la base de datos.');</script>";

    if($_ENV['CONECT_MYSQLI'] == 1){

        function conect_mysqli($host,$user,$pass,$database){
            $conexion = new mysqli("$host","$user", "$pass","$database");;
            $conexion->set_charset("utf8");
            
            // AGREGANDO CHARSET UTF8
            if (!$conexion->set_charset("utf8")) {
                printf("Error código JSS_utf8, no se puede cargar el conjunto de caracteres utf8: %s\n.", $conexion->error);
                exit();
            }
            
            if($conexion == TRUE){
                echo "<script>console.log('La conexión mysqli ha funcionado.');</script>";
            }else{
                echo "<script>console.log('La conexión mysqli ha fallado.');</script>";
            }
        
            return $conexion;
        
        }

        $conexion = conect_mysqli($host,$user,$pass,$DB);

    }
    if($_ENV['CONECT_MYSQLI'] != 1){
        echo "<script>console.log('La conexión mysqli está desactivada.');</script>";
    }

    if($_ENV['CONECT_MYSQL'] == 1){

        function conect_mysql($host,$database,$user,$pass){
        
            try {
                $pdo = new PDO('mysql:host='.$host.';dbname='.$database.'', $user, $pass);
                //echo "conectado";
            } catch (PDOException $e) {
                print "¡Error!: " . $e->getMessage() . "<br/>";
                die();
            }
        
            if($pdo == TRUE){
                echo "<script>console.log('La conexión mysql ha funcionado.');</script>";
            }else{
                echo "<script>console.log('La conexión mysql ha fallado.');</script>";
            }
        
            return $pdo;
        }

        $pdo = conect_mysql($host,$DB,$user,$pass);

    }
    if($_ENV['CONECT_MYSQL'] != 1){
        echo "<script>console.log('La conexión mysql está desactivada.');</script>";
    }

}else{
    echo "<script>console.log('Se ha desactivado el uso de bases de datos.');</script>";
}

function login($host,$user,$pass,$DB,$login_email,$login_password,$table_DB){

    $conexion = conect_mysqli($host,$user,$pass,$DB);

        $table_DB= $table_DB;
        $email_catch = $login_email;
        $password_catch = $login_password;
        $table = mysqli_real_escape_string($conexion, $table_DB);
        $usuario = mysqli_real_escape_string($conexion, $email_catch);
        $password = mysqli_real_escape_string($conexion, $password_catch);
    
        
        $sql = "SELECT id, password FROM $table WHERE email = '$usuario'";
        $resultado = $conexion->query($sql);
        $rows = $resultado->num_rows;
        if ($rows > 0) {
            $row = $resultado->fetch_assoc();
            $password_encriptada = $row['password'];
            if(password_verify($password,$password_encriptada) == TRUE){

                $_SESSION['id_usuario'] = $row['id'];
                
                //Cookie de usuario y contraseña
                setcookie("COOKIE_INDEFINED_SESSION", TRUE, time()+$_ENV['COOKIE_SESSION'], "/");
                setcookie("COOKIE_DATA_INDEFINED_SESSION[user]", $usuario, time()+$_ENV['COOKIE_SESSION'], "/");
                setcookie("COOKIE_DATA_INDEFINED_SESSION[pass]", $password, time()+$_ENV['COOKIE_SESSION'], "/");

                }else{
                    echo "<script>
                    alert('Contraseña incorrecta, vuélvelo a intentar o cambia la contraseña. Error ".$_ENV['NAME_APP']."_219');
                    window.location= './';
                  </script>";
                  }
            } else {
                echo "<script>
                    alert('Ninguno de los dos datos existen. Error ".$_ENV['NAME_APP']."_220');
                    window.location= './';
                </script>";
            }

            
}

function logout($host,$user,$pass,$DB,$id,$table_DB){

    $conexion = conect_mysqli($host,$user,$pass,$DB);
    $table_DB= $table_DB;
    $table = mysqli_real_escape_string($conexion, $table_DB);
    $sql = "SELECT email,password FROM $table WHERE id = '$id'";
    $resultado = $conexion->query($sql);
    $row = $resultado->fetch_assoc();
    $usuario = $row['email'];
    $password = $row['password'];

    //eliminar cookies creadas por el sistema
    if (isset($_COOKIE['COOKIE_INDEFINED_SESSION'])) {
        setcookie("COOKIE_INDEFINED_SESSION", FALSE, time()-$_ENV['COOKIE_SESSION'], "/");
        setcookie("COOKIE_DATA_INDEFINED_SESSION[user]", $usuario, time()-$_ENV['COOKIE_SESSION'], "/");
        setcookie("COOKIE_DATA_INDEFINED_SESSION[pass]", $password, time()-$_ENV['COOKIE_SESSION'], "/");
    }

    session_destroy();
}

function mail_smtp_v1_3($nombre,$asunto,$cuerpo,$correo){
    $nombre = $nombre;
    $asunto = $asunto;
    $cuerpo = $cuerpo;
    $correo = $correo;
    require "./config/correo.php";

}


if(isset($_POST['mail'])){
	$nombre = $_POST['nombre'];
	$asunto = $_POST['asunto'];
	$cuerpo = $_POST['cuerpo'];
	$correo = $_POST['correo'];
    mail_smtp_v1_3($nombre,$asunto,$cuerpo,$correo);
    echo "<script>console.log('Se ha mandado un correo');
    window.location= './';
    </script>";
}


?>