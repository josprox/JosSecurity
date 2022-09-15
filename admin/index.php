<?php

include __DIR__ . "/../jossecurity.php";
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
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.0-beta1 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css"
    integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

</head>

<body>

<div class="card" style="width:18rem;">
  <img src="https://images.unsplash.com/photo-1561154464-82e9adf32764?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=800&q=60" class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title">Iniciaste sesión</h5>
    <h6 class="card-subtitle mb-2 text-muted ">ID: <?php echo $iduser; ?></h6>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
    b5
  </div>
</div>

<div class="container">
  <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
    <div class="mb-3 row">
      <div class="offset-sm-4 col-sm-8">
        <button name ="salir" type="submit" class="btn btn-primary">Salir</button>
      </div>
    </div>
  </form>
</div>

  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js"
    integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js"
    integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous">
  </script>
  <script src="../node_modules/jquery/dist/jquery.min.js"></script>
</body>

</html>