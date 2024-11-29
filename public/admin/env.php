<?php

include (__DIR__ . "/../../jossecurity.php");
use SysJosSecurity\SysNAND;

login_cookie("table_users");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../panel");
}
$iduser = $_SESSION['id_usuario'];
secure_auth_admin($iduser,"../");

?>

<!doctype html>
<html lang="es-MX">

<head>
  <title><?php echo $nombre_app," versión: ", $version_app; ?></title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <?php head_admin(); ?>

</head>

<body>

  <?php navbar_admin(); 
  if(isset($_POST['modificar_prefijo'])){
    $conexion = conect_mysqli();
    $prefijo_nuevo = mysqli_real_escape_string($conexion, $_POST['prefijo']??null);
    $sysnand = new SysNAND();
    $conexion -> close();
    if($prefijo_nuevo){
      try{
        $prefijo_actual = env("PREFIJO","js_");
        $sysnand->updateEnvValue("PREFIJO",$prefijo_nuevo);
        $modificacion = new GranMySQL();
        $respuesta = $modificacion->cambiarPrefijo($prefijo_actual,$prefijo_nuevo);

        ?>
        <div
          class="alert alert-success alert-dismissible fade show"
          role="alert"
        >
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
            aria-label="Close"
          ></button>
          <strong>Información:</strong> <?php echo $respuesta; ?>
        </div>
        
        <script>
          var alertList = document.querySelectorAll(".alert");
          alertList.forEach(function (alert) {
            new bootstrap.Alert(alert);
          });
        </script>
        
        <?php
      }catch(Exception $e){
        ?>
        <div
          class="alert alert-warning alert-dismissible fade show"
          role="alert"
        >
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
            aria-label="Close"
          ></button>
          <strong>Falló:</strong> No hemos podido modificar el prefijo <?php echo $e; ?>.
        </div>
        
        <script>
          var alertList = document.querySelectorAll(".alert");
          alertList.forEach(function (alert) {
            new bootstrap.Alert(alert);
          });
        </script>
        
        <?php
      }
    }
  }
  ?>

  <br>

  <div class="container">
    <form action="<?php echo htmlentities((string) $_SERVER['PHP_SELF']); ?>" method="post">
      <div class="mb-3">
        <label for="prefijo" class="form-label">Prefijo</label>
        <input
          type="text"
          class="form-control"
          name="prefijo"
          id="prefijo"
          aria-describedby="prefijo"
          placeholder="Pon el nuevo prefijo"
          value="<?php echo env("PREFIJO","js_"); ?>"
        />
        <small id="prefijo" class="form-text text-muted">Puedes cambiar el prefijo actual, así podrás evitar una posible modificación del algun usuario mal intensionado</small>
      </div>

      <button
        type="submit"
        class="btn btn-info"
        name="modificar_prefijo"
      >
        Actualizar
      </button>
      
      
    </form>
    <?php
    edit_file("Archivo principal env","../../.env"); 
    ?>

  </div>

  <!-- Bootstrap JavaScript Libraries -->
  <?php footer_admin(); ?>
</body>

</html>