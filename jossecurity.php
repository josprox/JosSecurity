<?php

// JosSecurity, la mejor seguridad al alcance de tus manos.

// NO ELIMINES las lineas 6 a 9 por seguridad, si tu borras esta linea dejará de funcionar JosSecurity.
require_once (__DIR__ .'/vendor/autoload.php');
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
session_start();


//Configuración por defecto de JosSecurity
date_default_timezone_set($_ENV['ZONA_HORARIA']);
$fecha = date("Y-m-d H:i:s");
$nombre_app = $_ENV['NAME_APP'];
$version_app = $_ENV['VERSION'];

$host = (string)$_ENV['HOST'];
$user = (string)$_ENV['USUARIO'];
$pass = (string)$_ENV['CONTRA'];
$DB = (string)$_ENV['BASE_DE_DATOS'];

if ($_ENV['DEBUG'] == 1) {
    echo "<script>console.log('".$nombre_app." está funcionando.');</script>";
}

function head(){
    if ($_ENV['DEBUG'] == 1){
        echo "<script>console.log('".$_ENV['NAME_APP']." Head está activo.');</script>";
    }
    $pagina = nombre_de_pagina();
    if($pagina == "panel.php" OR $pagina == "reset.php"){
        $head = '<!-- JosSecurity está funcionando -->
        <link rel="stylesheet" href="./../node_modules/bootstrap/dist/css/bootstrap.min.css">
        <link rel="shortcut icon" href="./../resourses/img/logo transparente/vector/default.svg" type="image/x-icon">
        <script src="./../node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>';
        if($_ENV['RECAPTCHA'] == 1){
            $head .= '
        <script src="https://www.google.com/recaptcha/api.js"></script>
        ';
            return $head;
        }elseif($_ENV['RECAPTCHA'] != 1){
            return $head;
        }
    }elseif($pagina != "panel.php" OR $pagina != "reset.php"){
        return include (__DIR__ . "/routes/head/head.php");
    }
}

function head_admin(){
    if ($_ENV['DEBUG'] == 1){
        echo "<script>console.log('".$_ENV['NAME_APP']." Head admin está activo.');</script>";
    }
    return include (__DIR__ . "/routes/head/head_admin.php");
}

function navbar_admin(){
    if ($_ENV['DEBUG'] == 1){
        echo "<script>console.log('".$_ENV['NAME_APP']." navbar admin está activo.');</script>";
    }
    include (__DIR__ . "./routes/navbar/navbar.php");
}

function footer(){
    if ($_ENV['DEBUG'] == 1){
        echo "<script>console.log('".$_ENV['NAME_APP']." footer está activo.');</script>";
    }
    $pagina = nombre_de_pagina();
    if($pagina == "panel.php" OR $pagina == "reset.php"){
        return '<!-- JosSecurity está funcionando -->
        <!-- Bootstrap JavaScript Libraries -->
        <script src="./../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
        <!-- Video.js base JS -->
        <script src="./../resourses/js/video.min.js"></script>
        <!--Funciones del video, desactivar si no se usa-->
        <script>
            var reproductor = videojs("form-video", {
              fluid: true
            });
          </script>';
    }
    return include (__DIR__ . "/routes/footer/footer.php");
}

function footer_admin(){
    if ($_ENV['DEBUG'] == 1){
        echo "<script>console.log('".$_ENV['NAME_APP']." footer admin está activo.');</script>";
    }
    return include (__DIR__ . "/routes/footer/footer_admin.php");
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

        function conect_mysqli(){
            global $host,$user,$pass,$DB;
            $conexion = new mysqli("$host","$user", "$pass","$DB", 3306);
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

    }
    if($_ENV['CONECT_MYSQLI'] != 1){
        if ($_ENV['DEBUG'] == 1){
            echo "<script>console.log('La conexión mysqli está desactivada.');</script>";
        }
    }

    if($_ENV['CONECT_MYSQL'] == 1){

        function conect_mysql(){

            global $host,$user,$pass,$DB;
        
            try {
                $pdo = new PDO('mysql:host='.$host.';dbname='.$DB.'', $user, $pass);
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

function login($login_email,$login_password,$table_DB,$location){

    $conexion = conect_mysqli();

        $table_DB= $table_DB;
        $email_catch = $login_email;
        $password_catch = $login_password;
        $table = mysqli_real_escape_string($conexion, $table_DB);
        $usuario = mysqli_real_escape_string($conexion, $email_catch);
        $password = mysqli_real_escape_string($conexion, $password_catch);
        $ip = $_SERVER['REMOTE_ADDR'];
    
        
        $sql = "SELECT id, password FROM $table WHERE email = '$usuario'";
        $resultado = $conexion->query($sql);
        $rows = $resultado->num_rows;
        if ($rows > 0) {
            $row = $resultado->fetch_assoc();
            $password_encriptada = $row['password'];
            $id = $row['id'];
            if(password_verify($password,$password_encriptada) == TRUE){

                $_SESSION['id_usuario'] = $row['id'];
                
                //Cookie de usuario y contraseña
                setcookie("COOKIE_INDEFINED_SESSION", TRUE, time()+$_ENV['COOKIE_SESSION'], "/");
                setcookie("COOKIE_DATA_INDEFINED_SESSION[user]", $usuario, time()+$_ENV['COOKIE_SESSION'], "/");
                setcookie("COOKIE_DATA_INDEFINED_SESSION[pass]", $password, time()+$_ENV['COOKIE_SESSION'], "/");

                actualizar_datos_mysqli("users","`last_ip` = '$ip'","id",$id);

                mysqli_close($conexion);

                header("Location: $location");

                }else{
                    mysqli_close($conexion);
                }
            }
        else{
        mysqli_close($conexion);
        }
            
}

function login_admin($login_email,$login_password,$table_DB,$location){

    $conexion = conect_mysqli();
        $table = mysqli_real_escape_string($conexion, $table_DB);
        $usuario = mysqli_real_escape_string($conexion, $login_email);
        $password = mysqli_real_escape_string($conexion, $login_password);
        $ip = $_SERVER['REMOTE_ADDR'];
    
        
        $sql = "SELECT id, password, id_rol FROM $table WHERE email = '$usuario'";
        $resultado = $conexion->query($sql);
        $rows = $resultado->num_rows;
        if ($rows > 0) {
            $row = $resultado->fetch_assoc();
            $password_encriptada = (string)$row['password'];
            $rol = $row['id_rol'];
            $id = $row['id'];
            if($rol == 1 OR $rol == 2 OR $rol == 4){

                if(password_verify($password,$password_encriptada) == TRUE){
    
                    $_SESSION['id_usuario'] = $row['id'];
                    
                    //Cookie de usuario y contraseña
                    setcookie("COOKIE_INDEFINED_SESSION", TRUE, time()+$_ENV['COOKIE_SESSION'], "/");
                    setcookie("COOKIE_DATA_INDEFINED_SESSION[user]", $usuario, time()+$_ENV['COOKIE_SESSION'], "/");
                    setcookie("COOKIE_DATA_INDEFINED_SESSION[pass]", $password, time()+$_ENV['COOKIE_SESSION'], "/");

                    actualizar_datos_mysqli("users","`last_ip` = '$ip'","id",$id);
    
                    mysqli_close($conexion);
    
                    header("Location: $location");
    
                    }else{
                        mysqli_close($conexion);
                    }
            }
            }
        else{
        mysqli_close($conexion);
        }
            
}

function login_cookie($table_DB){
    $conexion = conect_mysqli();
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
                    mysqli_close($conexion);
                }
            }
        }
    }
}

function registro($table_db,$name_user,$email_user,$contra_user,$rol_user){
    global $fecha;
    $conexion = conect_mysqli();
    $nombre = mysqli_real_escape_string($conexion, $name_user);
    $email = mysqli_real_escape_string($conexion, $email_user);
	$password = mysqli_real_escape_string($conexion, $contra_user);
	$password_encriptada = password_hash($password,PASSWORD_BCRYPT,["cost"=>10]);
	$rol = mysqli_real_escape_string($conexion,$rol_user);
    $rol = (int)$rol;


    $sql_check = "SELECT id FROM $table_db WHERE email = '$email'";
    $sql_rest = $conexion->query($sql_check);
    $filas = $sql_rest -> num_rows;
    mysqli_close($conexion);

    if ($filas <= 0) {
        insertar_datos_clasic_mysqli($table_db,"name, email, password, id_rol, created_at, updated_at","'$nombre', '$email', '$password_encriptada', '$rol', '$fecha', NULL");
        $success = "
        <script>
            Swal.fire(
            'Completado',
            'Se ha registrado correctamente el usuario',
            'success'
            )
        </script>";
        return $success;
    }elseif($filas >= 1){
        $error = "
        <script>
            Swal.fire(
            'Falló',
            'El usuario ya existe',
            'error'
            )
        </script>";
        return $error;
    }
}

function resetear_contra($correo){
    $conexion = conect_mysqli();
    $key = "";
    $pattern = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
    $max = strlen($pattern)-1;
    for($i = 0; $i < 16; $i++){
        $key .= substr($pattern, mt_rand(0,$max), 1);
    }
    $password = $key;
    $password_encriptada = password_hash($key,PASSWORD_BCRYPT,["cost"=>10]);
    date_default_timezone_set($_ENV['ZONA_HORARIA']);
    $fecha = date("Y-m-d H:i:s");
    $insert = "UPDATE `users` SET `password` = '$password_encriptada' WHERE `users`.`email` = '$correo'";
    mysqli_query($conexion, $insert);
    
    $row = consulta_mysqli_where("name","users","email","'$correo'");
    
    $name = $row['name'];
    
    if($_ENV['SMTP_ACTIVE'] == 1){
        include (__DIR__ . "/config/correo_reset_password.php");
    }
    if($_ENV['SMTP_ACTIVE'] != 1){
        echo "<p>No puedes enviar correos porque no está activado en el sistema.</p>";
    }
    
    mysqli_close($conexion);
    return $key;
}

function logout($id,$table_DB){

    $conexion = conect_mysqli();
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
    mysqli_close($conexion);

}

function mail_smtp_v1_3($nombre,$asunto,$cuerpo,$correo){
    if($_ENV['SMTP_ACTIVE'] == 1){
        include (__DIR__ . "/config/correo.php");
    }elseif($_ENV['SMTP_ACTIVE'] != 1){
        echo "<p>No puedes enviar correos porque no está activado en el sistema.</p>";
    }
}

function mail_smtp_v1_3_check($correo){
    if($_ENV['SMTP_ACTIVE'] == 1){
        include (__DIR__ . "/config/correo_check.php");
    }elseif($_ENV['SMTP_ACTIVE'] != 1){
        echo "<p>No puedes enviar correos porque no está activado en el sistema.</p>";
    }
}

function consulta_mysqli($select_db,$table_db,$custom,$sentence,$data,$compare,$inner){
    $conexion = conect_mysqli();
    if ($sentence == "clasic"){
        $sql = "SELECT $select_db FROM $table_db";
        $resultado = $conexion->query($sql);
        return $resultado->fetch_assoc();
    }elseif($sentence == "where"){
        $sql = "SELECT $select_db FROM $table_db $custom WHERE $data = $compare";
        $resultado = $conexion->query($sql);
        return $resultado->fetch_assoc();
    }elseif($sentence == "innerjoin"){
        $sql = "SELECT $select_db FROM $table_db INNER JOIN $inner ON $compare = $data $custom";
        $resultado = $conexion->query($sql);
        return $resultado->fetch_assoc();
    }
    mysqli_close($conexion);
}

function consulta_mysqli_clasic($select_db,$table_db){
    $conexion = conect_mysqli();
    $sql = "SELECT $select_db FROM $table_db";
    $resultado = $conexion->query($sql);
    return $resultado->fetch_assoc();
    mysqli_close($conexion);
}

function consulta_mysqli_where($select_db,$table_db,$data,$compare){
    $conexion = conect_mysqli();
    $sql = "SELECT $select_db FROM $table_db WHERE $data = $compare";
    $resultado = $conexion->query($sql);
    return $resultado->fetch_assoc();
    mysqli_close($conexion);
}

function consulta_mysqli_innerjoin($select_db,$table_db,$inner,$compare,$data){
    $conexion = conect_mysqli();
    $sql = "SELECT $select_db FROM $table_db INNER JOIN $inner ON $compare = $data";
    $resultado = $conexion->query($sql);
    return $resultado->fetch_assoc();
    mysqli_close($conexion);
}

function consulta_mysqli_custom_all($code){
    $conexion = conect_mysqli();
    $sql = "$code";
    $resultado = $conexion->query($sql);
    return $resultado->fetch_assoc();
    mysqli_close($conexion);
}

function leer_tablas_mysql_custom($code){
    $conexion = conect_mysqli();
    $sql = "$code";
    $resultado = $conexion->query($sql);
    return $resultado->num_rows;
    mysqli_close($conexion);
}

function insertar_datos_clasic_mysqli($tabla,$datos,$contenido){
    $conexion = conect_mysqli();
    $sql = "INSERT INTO $tabla ($datos) VALUES ($contenido);";
    mysqli_query($conexion, $sql);
    mysqli_close($conexion);
}

function insertar_datos_custom_mysqli($codigo_sql){
    $conexion = conect_mysqli();
    $sql = "$codigo_sql";
    mysqli_query($conexion, $sql);
    mysqli_close($conexion);
}

function insertar_datos_post_mysqli($tabla,$post){
    $conexion = conect_mysqli();

    $insert = "INSERT INTO $tabla (";
    $values = " VALUES (";
    
    foreach ( $post as $key => $value ) {
    $insert .= "$key, ";
    $values .= " '$value', ";
    }
    
    // Eliminar las ultimas comas y cerrar los parentesis
    $insert = substr($insert, 0, -2).')';
    $values = substr($values, 0, -2).')';
    
    $sql = $insert.$values; 

    mysqli_query($conexion, $sql);

    mysqli_close($conexion);
}

function actualizar_datos_mysqli($tabla,$edicion,$where,$dato){
    global $fecha;
    $miconexion = conect_mysqli();
    $sql = "UPDATE `$tabla` SET $edicion, `updated_at` = '$fecha' WHERE `$tabla`.`$where` = $dato";

    /*if ($miconexion->query($sql) === TRUE) {
        echo "OK";      
       }else {
        echo "ERROR";
       }*/
    
    $miconexion -> query($sql);
    $miconexion -> close();

}

function arreglo_consulta($code){

    $conexion = conect_mysql();
    $sql = "$code";
    return $conexion->query($sql);
    $conexion = null;

}

function eliminar_datos_con_where($tabla,$where,$dato){
    $conexion = conect_mysqli();
    $sql = "DELETE FROM $tabla WHERE $where = $dato";
    if ($conexion->query($sql) === TRUE) {
        $success = "
        <script>
            Swal.fire(
            'Completado',
            'Se ha eliminado todo de manera correcta.',
            'success'
            )
        </script>";
        return $success;    
       }else {
        $error = "
        <script>
            Swal.fire(
            'Falló',
            'No se ha podido eliminar de manera correcta.',
            'error'
            )
        </script>";
        return $error;
       }
    $conexion -> close();
}

function crear_tabla_mysqli($tabla,$contenido){
    $conexion = conect_mysqli();
    $sql = "CREATE TABLE `$tabla` (`id` bigint(25) NOT NULL PRIMARY KEY AUTO_INCREMENT, $contenido, `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    if($conexion ->query($sql)){
        mysqli_close($conexion);
        return TRUE;
    }else{
        mysqli_close($conexion);
        return FALSE;
    }

}
function crear_tabla_PDO($tabla,$contenido){
    $pdo = conect_mysql();
    $sql = "CREATE TABLE `$tabla` (`id` bigint(25) NOT NULL PRIMARY KEY AUTO_INCREMENT, $contenido, `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    $pdo ->exec($sql);
    if($pdo ->exec($sql)){
        $pdo = null;
        return TRUE;
    }else{
        $pdo = null;
        return FALSE;
    }
    
}

function eliminar_tabla_PDO($tabla){
    $pdo = conect_mysql();
    $sql = "TRUNCATE TABLE `$tabla`;";
    $pdo -> exec($sql);
}

function reproductor_video($url){
    echo '<video class="fm-video video-js vjs-16-9 vjs-big-play-centered" style="margin-top: 12px; margin-bottom: 12px;" data-setup="{}" controls id="form-video">
        <source src="'.$url.'" type="video/mp4">
    </video>';
}

function nombre_de_pagina(){
    $url = explode("/", $_SERVER['SCRIPT_NAME']);
    $url = array_reverse($url);
    $url = $url[0];
    return $url;
}

if($_ENV['RECAPTCHA'] == 1){

    function recaptcha(){
        $ip = $_SERVER['REMOTE_ADDR'];
        $captcha = $_POST['g-recaptcha-response'];
        $secretkey = $_ENV['RECAPTCHA_CODE_SECRET'];
    
        $respuesta_captcha = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretkey&response=$captcha&remoteip=$ip");
    
        $atributos = json_decode($respuesta_captcha, TRUE);
    
        if(!$atributos['success']){
            if ($_ENV['DEBUG'] == 1){
                echo "<script>console.log('".$_ENV['NAME_APP']." informa que ha fallado el recaptcha.');</script>";
                return FALSE;
            }
        }
        if($atributos['success']){
            return TRUE;
        }
    }

}

if ($_ENV['PLUGINS'] == 1){
    include (__DIR__ . "/plugins/autoload.php");
}
if ($_ENV['PLUGINS'] != 1){
    //Uso de la configuración plugins internos cuando el sistema de plugins no funcione o se encuentre desactivado.
    include (__DIR__ . "/config/not_paid.php");
}

?>