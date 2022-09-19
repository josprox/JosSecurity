<?php

// JosSecurity, la mejor seguridad al alcance de tus manos.

// NO ELIMINES las lineas 6 a 9 por seguridad, si tu borras esta linea dejará de funcionar JosSecurity.
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

if ($_ENV['DEBUG'] == 1) {
    echo "<script>console.log('".$nombre_app." está funcionando.');</script>";
}


function head(){
    if ($_ENV['DEBUG'] == 1){
        echo "<script>console.log('".$_ENV['NAME_APP']." Head está activo.');</script>";
    }
    include __DIR__ . "./routes/head/head.php";
}

function head_admin(){
    if ($_ENV['DEBUG'] == 1){
        echo "<script>console.log('".$_ENV['NAME_APP']." Head admin está activo.');</script>";
    }
    include __DIR__ . "./routes/head/head_admin.php";
}

function navbar_admin(){
    if ($_ENV['DEBUG'] == 1){
        echo "<script>console.log('".$_ENV['NAME_APP']." navbar admin está activo.');</script>";
    }
    include __DIR__ . "./routes/navbar/navbar.php";
}

function footer(){
    if ($_ENV['DEBUG'] == 1){
        echo "<script>console.log('".$_ENV['NAME_APP']." footer está activo.');</script>";
    }
    include __DIR__ . "./routes/footer/footer.php";
}

function footer_admin(){
    if ($_ENV['DEBUG'] == 1){
        echo "<script>console.log('".$_ENV['NAME_APP']." footer admin está activo.');</script>";
    }
    include __DIR__ . "./routes/footer/footer_admin.php";
}

function edit_file($titulo,$directorio){
    $archivo = strip_tags($directorio);
    if(isset($_POST['enviar'])){
        $fp=fopen($archivo, "w+");
        fputs($fp,$_POST['contenido']);
        fclose($fp);
        echo "Editado correctamente";
    }

    $fp=fopen($archivo, "r");
    $contenido = fread($fp, filesize($archivo));
    $contenido = htmlspecialchars($contenido);
    fclose($fp);
    echo '<h1 align="center">'.$titulo.'</h1>';
    echo '<form action="" method="post">';
    echo '<div class="mb-3">';
    echo "<textarea class='form-control' name='contenido' rows='15'>$contenido</textarea>";
    echo '</div>';
    echo "<center><input type='submit' class='btn btn-success' name='enviar' value='Guardar archivo'></center>";
    echo "</form>";
}

if ($_ENV['CONECT_DATABASE'] == 1){

    if ($_ENV['DEBUG'] == 1){
        echo "<script>console.log('Se ha activado la función para usar la base de datos.');</script>";
    }


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
                if ($_ENV['DEBUG'] == 1){
                    echo "<script>console.log('La conexión mysqli ha funcionado.');</script>";
                }
            }else{
                if ($_ENV['DEBUG'] == 1){
                    echo "<script>console.log('La conexión mysqli ha fallado.');</script>";
                }
            }
        
            return $conexion;
        
        }

        $conexion = conect_mysqli($host,$user,$pass,$DB);

    }
    if($_ENV['CONECT_MYSQLI'] != 1){
        if ($_ENV['DEBUG'] == 1){
            echo "<script>console.log('La conexión mysqli está desactivada.');</script>";
        }
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
                if ($_ENV['DEBUG'] == 1){
                    echo "<script>console.log('La conexión mysql ha funcionado.');</script>";
                }
            }else{
                if ($_ENV['DEBUG'] == 1){
                    echo "<script>console.log('La conexión mysql ha fallado.');</script>";
                }
            }
        
            return $pdo;
        }

        $pdo = conect_mysql($host,$DB,$user,$pass);

    }
    if($_ENV['CONECT_MYSQL'] != 1){
        if ($_ENV['DEBUG'] == 1){
            echo "<script>console.log('La conexión mysql está desactivada.');</script>";
        }
    }

}else{
    if ($_ENV['DEBUG'] == 1){
        echo "<script>console.log('Se ha desactivado el uso de bases de datos.');</script>";
    }
}

function login($host,$user,$pass,$DB,$login_email,$login_password,$table_DB,$location){

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

                header("Location: $location");

                }
            }

            
}

function login_cookie($host,$user,$pass,$DB,$table_DB){
    $conexion = conect_mysqli($host,$user,$pass,$DB);
    if (isset($_COOKIE['COOKIE_INDEFINED_SESSION'])) {
        if ($_COOKIE['COOKIE_INDEFINED_SESSION']) {
            $nombre_user = $_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['user'];
            $password_user = $_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['pass'];
    
            $sql = "SELECT id, password FROM $table_DB WHERE email = '$nombre_user'";
            $resultado = $conexion->query($sql);
            $rows = $resultado->num_rows;
            if ($rows > 0) {
                $row = $resultado->fetch_assoc();
                $password_encriptada = $row['password'];
                if(password_verify($password_user,$password_encriptada) == TRUE){
                    $_SESSION['id_usuario'] = $row['id'];
                }
            }
        }
    }
}

function registro($host,$user,$pass,$DB,$table_db,$name_user,$email_user,$contra_user,$rol_user){
    $conexion = conect_mysqli($host,$user,$pass,$DB);
    $nombre = mysqli_real_escape_string($conexion, $name_user);
    $email = mysqli_real_escape_string($conexion, $email_user);
	$password = mysqli_real_escape_string($conexion, $contra_user);
	$password_encriptada = password_hash($password,PASSWORD_BCRYPT,["cost"=>10]);
	$rol = mysqli_real_escape_string($conexion,$rol_user);
    $rol = (int)$rol;
	date_default_timezone_set($_ENV['ZONA_HORARIA']);
    $fecha = date("Y-m-d H:i:s");


    $sql_check = "SELECT id FROM $table_db WHERE email = '$email'";
    $sql_rest = $conexion->query($sql_check);
    $filas = $sql_rest -> num_rows;

    if ($filas < 1) {
        $sql_insert = "INSERT INTO $table_db (name, email, password, id_rol, created_at, updated_at) VALUES ('$nombre', '$email', '$password_encriptada', '$rol', '$fecha', NULL) ";
        $sql_inyect = $conexion->query($sql_insert);
    }
}

function resetear_contra($host,$user,$pass,$DB,$email){
    $conexion = conect_mysqli($host,$user,$pass,$DB);
    $key = "";
    $pattern = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
    $max = strlen($pattern)-1;
    for($i = 0; $i < 12; $i++){
        $key .= substr($pattern, mt_rand(0,$max), 1);
    }
    $password_encriptada = password_hash($key,PASSWORD_BCRYPT,["cost"=>10]);
    date_default_timezone_set($_ENV['ZONA_HORARIA']);
    $fecha = date("Y-m-d H:i:s");
    $insert = "UPDATE `users` SET `password` = '$password_encriptada' WHERE `users`.`email` = '$email'";
    mysqli_query($conexion, $insert);
    return $key;
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
    if($_ENV['SMTP_ACTIVE'] == 1){
        require __DIR__ . "./config/correo.php";
    }
    if($_ENV['SMTP_ACTIVE'] != 1){
        echo "<p>No puedes enviar correos porque no está activado en el sistema.</p>";
    }
}

function consulta_mysqli($host,$user,$pass,$DB,$select_db,$table_db,$custom,$sentence,$data,$compare,$inner){
    $conexion = conect_mysqli($host,$user,$pass,$DB);
    if ($sentence == "clasic"){
        $sql = "SELECT $select_db FROM $table_db";
        $resultado = $conexion->query($sql);
        return $resultado->fetch_assoc();
    }
    if ($sentence == "where"){
        $sql = "SELECT $select_db FROM $table_db $custom WHERE $data = $compare";
        $resultado = $conexion->query($sql);
        return $resultado->fetch_assoc();
    }
    if ($sentence == "innerjoin"){
        $sql = "SELECT $select_db FROM $table_db INNER JOIN $inner ON $compare = $data $custom";
        $resultado = $conexion->query($sql);
        return $resultado->fetch_assoc();
    }
}

function consulta_mysqli_clasic($host,$user,$pass,$DB,$select_db,$table_db){
    $conexion = conect_mysqli($host,$user,$pass,$DB);
    $sql = "SELECT $select_db FROM $table_db";
    $resultado = $conexion->query($sql);
    return $resultado->fetch_assoc();
}

function consulta_mysqli_where($host,$user,$pass,$DB,$select_db,$table_db,$data,$compare){
    $conexion = conect_mysqli($host,$user,$pass,$DB);
    $sql = "SELECT $select_db FROM $table_db WHERE $data = $compare";
    $resultado = $conexion->query($sql);
    return $resultado->fetch_assoc();
}

function consulta_mysqli_innerjoin($host,$user,$pass,$DB,$select_db,$table_db,$inner,$data,$compare){
    $conexion = conect_mysqli($host,$user,$pass,$DB);
    $sql = "SELECT $select_db FROM $table_db INNER JOIN $inner ON $compare = $data";
    $resultado = $conexion->query($sql);
    return $resultado->fetch_assoc();
}

function consulta_mysqli_custom_all($host,$user,$pass,$DB,$code){
    $conexion = conect_mysqli($host,$user,$pass,$DB);
    $sql = "$code";
    $resultado = $conexion->query($sql);
    return $resultado->fetch_assoc();
}

if ($_ENV['PLUGINS'] == 1){

    require __DIR__ . "./plugins/autoload.php";

}

?>