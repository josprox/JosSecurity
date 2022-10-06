<?php

$host_psg = (string)$_ENV['HOST_PSG'];
$user_psg = (string)$_ENV['USUARIO_PSG'];
$pass_psg = (string)$_ENV['CONTRA_PSG'];
$DB_psg = (string)$_ENV['BASE_DE_DATOS_PSG'];
$puerto_psg = (string)$_ENV['PUERTO_PSG'];

if($_ENV['CONECT_POSTGRESQL'] == 1){
    function conect_pg(){
        global $host_psg,$user_psg,$pass_psg,$DB_psg;
        $conexion = pg_connect("host=$host_psg dbname=$DB_psg user=$user_psg password=$pass_psg");

        if($conexion == TRUE){
            if ($_ENV['DEBUG'] == 1){
                echo "<script>console.log('La conexión PostgreSQL ha funcionado.');</script>";
            }
        }else{
            if ($_ENV['DEBUG'] == 1){
                echo "<script>console.log('La conexión PostgreSQL ha fallado.');</script>";
            }
        }
        return $conexion;
    }
}
if($_ENV['CONECT_POSTGRESQL'] != 1){
    if ($_ENV['DEBUG'] == 1){
        echo "<script>console.log('La conexión PostgreSQL está desactivada.');</script>";
    }
}
if($_ENV['CONECT_POSTGRESQL_PDO'] == 1){
    function conect_pg_PDO(){
        global $host_psg,$user_psg,$pass_psg,$DB_psg,$puerto_psg;
        $conexion = new PDO("pgsql:host=$host_psg;port=$puerto_psg;dbname=$DB_psg", $user_psg, $pass_psg);

        if($conexion == TRUE){
            if ($_ENV['DEBUG'] == 1){
                echo "<script>console.log('La conexión PostgreSQL PDO ha funcionado.');</script>";
            }
        }else{
            if ($_ENV['DEBUG'] == 1){
                echo "<script>console.log('La conexión PostgreSQL PDO ha fallado.');</script>";
            }
        }
        return $conexion;
    }
}
if($_ENV['CONECT_POSTGRESQL_PDO'] != 1){
    if ($_ENV['DEBUG'] == 1){
        echo "<script>console.log('La conexión PostgreSQL PDO está desactivada.');</script>";
    }
}

?>