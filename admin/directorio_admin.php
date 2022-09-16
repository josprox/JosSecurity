<?php

include __DIR__ . "/../jossecurity.php";

login_cookie($host,$user,$pass,$DB,"users");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../");
}
$iduser = $_SESSION['id_usuario'];

if(isset($_POST['salir'])){
  logout($host,$user,$pass,$DB,$iduser,"users");
  header("Location: ./../");
}

?>

<!doctype html>
<html lang="es-MX">

<head>
  <title><?php echo $nombre_app," versión: ", $version_app; ?></title>
  <?php head_admin(); ?>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

</head>

<body>

  <?php navbar_admin(); ?>

  <br>

  <div class="container">
    <?php

    error_reporting(0);
    
    $archivo = strip_tags($_GET['archivo']);

    if($archivo==""){
        $archivos = scandir("./");
        for ($i=0; $i < count($archivos); $i++) { 
            if ($archivos[$i] !="." && $archivos[$i] !="..") {
                if(!is_dir($archivos[$i])){
                    echo "<a href='?archivo=" . $archivos[$i] . "'>".$archivos[$i]."</a><br>";
                }else{
                    echo $archivos[$i] . "<br>";
                }
                
            }
        }
    }else{

        if($_POST['enviar']){
            $fp=fopen($archivo, "w+");
            fputs($fp,$_POST['contenido']);
            fclose($fp);
            echo "Editado correctamente";
        }

        $fp=fopen($archivo, "r");
        $contenido = fread($fp, filesize($archivo));
        $contenido = htmlspecialchars($contenido);
        fclose($fp);
        echo '<form action="" method="post">';
        echo "<textarea name='contenido' cols=60' rows='20'>$contenido</textarea>";
        echo "<input type='submit' name='enviar' value='Editar'>";
        echo "</form>";
        echo "<a href='".basename(__FILE__)."'>Regresar</a>";
    }

    ?>
  </div>

  <!-- Bootstrap JavaScript Libraries -->
  <?php footer_admin(); ?>
  <script src="../node_modules/jquery/dist/jquery.min.js"></script>
</body>

</html>