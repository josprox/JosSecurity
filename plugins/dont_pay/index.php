<?php

/* 

    Esta es una versión mejorada de did not pay.
    Consulta el código fuente en: https://github.com/kleampa/not-paid
    El siguiente código está preparado solo para el uso de JosSecurity, no sengarantiza el uso de este plugin en otros sistemas.

*/
function not_paid_datos(){
    return consulta_mysqli_clasic("*","not_pay");
}

if(isset($_POST['create_not_pay'])){
    $conexion = conect_mysqli();
    if(isset($_POST['check_pay'])){
        $check = mysqli_real_escape_string($conexion, $_POST['check_pay']);
        if ($check == "on"){
            $check = TRUE;
        }
    }else{
        $check = FALSE;
    }
    $fecha_updated = mysqli_real_escape_string($conexion, $_POST['fecha']);
    if($_POST['dias'] <= 60 OR $_POST['dias'] >= 0){
        $dias = (int)mysqli_real_escape_string($conexion, $_POST['dias']);
    }elseif($_POST['dias'] > 60 OR $_POST['dias'] < 0){
        $dias = (int)60;
    }

    insertar_datos_clasic_mysqli("not_pay","check_pay, fecha, dias, created_at, updated_at"," '$check', '$fecha_updated', '$dias','$fecha', NULL");
}

if(isset($_POST['receptor_not_paid'])){
    $conexion = conect_mysqli();
    $id = mysqli_real_escape_string($conexion, $_POST['id']);
    if(isset($_POST['check_pay'])){
        $check = mysqli_real_escape_string($conexion, $_POST['check_pay']);
        if ($check == "on"){
            $check = TRUE;
        }
    }else{
        $check = FALSE;
    }
    $fecha_updated = mysqli_real_escape_string($conexion, $_POST['fecha']);
    if($_POST['dias'] <= 60 OR $_POST['dias'] >= 0){
        $dias = (int)mysqli_real_escape_string($conexion, $_POST['dias']);
    }elseif($_POST['dias'] > 60 OR $_POST['dias'] < 0){
        $dias = (int)60;
    }

    actualizar_datos_mysqli("not_pay"," `check_pay` = '$check', `fecha` = '$fecha_updated', `dias` = '$dias'","id",$id);

    mysqli_close($conexion);

}

if(isset($_POST['eliminar_not_paid'])){
    $conexion = conect_mysqli();
    $pdo = conect_mysql();
    $id = mysqli_real_escape_string($conexion, $_POST['id']);
    mysqli_close($conexion);
    eliminar_datos_con_where("not_pay","id",$id);

}


function correr_not_pay(){

    if (leer_tablas_mysql_custom("SELECT * FROM not_pay")>1){

        $datos = not_paid_datos();

        if($datos['check_pay'] == TRUE){?>


        <script type="text/javascript">

            (function(){
                /* change these variables as you wish */
                var due_date = new Date('<?php echo $datos['fecha']; ?>');
                var days_deadline = <?php echo $datos['dias']; ?>;
                /* stop changing here */
                
                var current_date = new Date();
                var utc1 = Date.UTC(due_date.getFullYear(), due_date.getMonth(), due_date.getDate());
                var utc2 = Date.UTC(current_date.getFullYear(), current_date.getMonth(), current_date.getDate());
                var days = Math.floor((utc2 - utc1) / (1000 * 60 * 60 * 24));
                
                if(days > 0) {
                    var days_late = days_deadline-days;
                    var opacity = (days_late*100/days_deadline)/100;
                        opacity = (opacity < 0) ? 0 : opacity;
                        opacity = (opacity > 1) ? 1 : opacity;
                    if(opacity >= 0 && opacity <= 1) {
                        document.getElementsByTagName("BODY")[0].style.opacity = opacity;
                    }
                }
            })();
        </script>

        <?php }

    }?>

    <?php
}

function check_not_paid(){
    if(leer_tablas_mysql_custom("SELECT * FROM not_pay")<1){

        ?>

        <h2 align="center">Vamos a activarlo</h2>
        <p align="justify">Por defecto el sistema viene desactivado para poder evitar el mal uso del sistema, si deseas activarlo por favor llene los siguientes datos.</p>
        <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
        <div class="form-check form-switch">
            <input class="form-check-input" name="check_pay" type="checkbox" id="flexSwitchCheckDefault" >
            <label class="form-check-label" for="flexSwitchCheckDefault">Por favor, selecciona si deseas activarlo ahorita o después</label>
        </div>
        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="date" class="form-control" name="fecha" id="fecha" aria-describedby="fecha" placeholder="fecha">
            <small id="fecha" class="form-text text-muted">Pon la fecha máxima.</small>
        </div>
        <div class="mb-3">
            <label for="dias" class="form-label">Dias</label>
            <input type="number"
            class="form-control" min="0" max="60" name="dias" id="dias" aria-describedby="dias" placeholder="dias">
            <small id="dias" class="form-text text-muted">Pon los días cuando inicie el script</small>
        </div>
        <button type="submit" name="create_not_pay" class="btn btn-success">Crear</button>
        </form>

    </div>

        <?php

    }elseif(leer_tablas_mysql_custom("SELECT * FROM not_pay")>=1){ ?>
    <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
    <?php
        not_paid_check(); 
        not_paid_fecha();
        not_paid_dias();
        not_paid_submit();
        not_paid_delete();
        ?>
    </form>
    <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
        
    </form>
        <?php
        
    }
}

function not_paid_check() { 
    $datos = not_paid_datos();
	?>
    <div class="form-check form-switch">
        <input type="hidden" name="id" value="<?php echo $datos['id']; ?>">
        <input class="form-check-input" name="check_pay" type="checkbox" id="flexSwitchCheckDefault" <?php if($datos['check_pay'] == TRUE){ echo "checked"; } ?>>
        <label class="form-check-label" for="flexSwitchCheckDefault">Sistema: <?php if($datos['check_pay'] == TRUE){ echo "Activado"; }elseif($datos['check_pay'] != TRUE){ echo "Desactivado"; } ?></label>
    </div>
	<?php

}

function not_paid_fecha() { 
    $datos = not_paid_datos();
	?>
    <div class="mb-3">
        <label for="fecha" class="form-label">Fecha</label>
        <input type="date"
          class="form-control" name="fecha" id="fecha" aria-describedby="fecha" placeholder="fecha" value='<?php echo $datos['fecha']; ?>'>
        <small id="fecha" class="form-text text-muted">Pon la fecha máxima.</small>
    </div>
	<?php

}


function not_paid_dias() { 
    $datos = not_paid_datos();
	?>
    <div class="mb-3">
        <label for="dias" class="form-label">Dias</label>
        <input type="number"
          class="form-control" min="0" max="60" name="dias" id="dias" aria-describedby="dias" placeholder="dias" value="<?php echo $datos['dias']; ?>">
        <small id="dias" class="form-text text-muted">Pon los días cuando inicie el script</small>
    </div>
	<?php

}

function not_paid_submit(){
    $datos = not_paid_datos();
    ?> 

    <button type="submit" name="receptor_not_paid" class="btn btn-primary"><?php if($datos['check_pay'] == TRUE){ echo "Actualizar"; }elseif($datos['check_pay'] != TRUE){ echo "Guardar"; } ?></button>
    
    <?php
}

function not_paid_delete(){
    $datos = not_paid_datos();
    ?> 
    <input type="hidden" name="id" value="<?php echo $datos['id']; ?>">
    <button type="submit" name="eliminar_not_paid" class="btn btn-warning">Eliminar</button>
    
    <?php
}

?>