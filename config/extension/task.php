<?php

//Cron del sistema por defecto.
function limpiar_tabla_check_users()
{
    $consulta = new GranMySQL();
    $consulta -> tabla = "table_check_users";
    $respuesta = json_decode($consulta -> clasic("json"),true);
    foreach ($respuesta as $row){
        if($row['expiracion'] < \FECHA){
            eliminar_datos_con_where("table_check_users","id",$row['id']);
        }
    }
}

evento_programado("limpiar_tabla_check_users",\FECHA,"1 hours");

//Cron extendido disponible para el programador.

if(file_exists(__DIR__ . DIRECTORY_SEPARATOR . "task_custom.php")){
    include (__DIR__ . DIRECTORY_SEPARATOR . "task_custom.php");
}

?>