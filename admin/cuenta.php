<?php

include __DIR__ . "/../jossecurity.php";

login_cookie($host,$user,$pass,$DB,"users");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../");
}

$iduser = $_SESSION['id_usuario'];

$row = consulta_mysqli($host,$user,$pass,$DB,"*","users","","clasic","","","");

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
    <form>

      <div class="mb-3">
        <label for="id" class="form-label"><i class="fa fa-id-badge" aria-hidden="true"></i></label>
        <input type="text"
          class="form-control" name="id" id="id" aria-describedby="id" disabled placeholder="ID" value="<?php echo $row['id']; ?>">
        <small id="id" class="form-text text-muted">Mi ID</small>
      </div>

      <div class="mb-3">
        <label for="name" class="form-label">Nombre</label>
        <input type="text" class="form-control" name="name" id="name" aria-describedby="name" placeholder="Nombre" value="<?php echo $row['name']; ?>">
        <small id="name" class="form-text text-muted">Nombre registrado</small>
      </div>

      <div class="mb-3">
        <label for="correo" class="form-label">Correo</label>
        <input type="text" class="form-control" name="correo" id="correo" aria-describedby="correo" placeholder="correo" value="<?php echo $row['email']; ?>">
        <small id="correo" class="form-text text-muted">Correo Registrado</small>
      </div>

      <h3 align="center">Para modificar la información, favor de volver a poner la contraseña</h3>

      <div class="mb-3">
        <label for="password" class="form-label"><i class="fa fa-y-combinator-square" aria-hidden="true"></i></label>
        <input type="password"
          class="form-control" name="password" id="password" aria-describedby="password" placeholder="">
        <small id="password" class="form-text text-muted">Pon tu contraseña para modificar los datos.</small>
      </div>

      <div class="mb-3 row">
        <div class="offset-sm-4 col-sm-8">
          <button type="submit" name="actualizar" class="btn btn-primary">Action</button>
        </div>
      </div>
    </form>
  </div>

  <!-- Bootstrap JavaScript Libraries -->
  <?php footer_admin(); ?>
  <script src="../node_modules/jquery/dist/jquery.min.js"></script>
</body>

</html>