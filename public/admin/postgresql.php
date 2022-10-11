<?php

include (__DIR__ . "/../../jossecurity.php");

login_cookie("users");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../panel");
}

$iduser = $_SESSION['id_usuario'];

if($_ENV['CONECT_POSTGRESQL'] != 1){
  header("location: ./");
}

if(isset($_POST['salir'])){
  logout($iduser,"users");
  header("Location: ./../panel");
}

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

  <?php navbar_admin(); ?>

  <br>

  <div class="container">

    <h1 align="Center">Sistema de PostgreSQL</h1>
    <p align="justify">Aquí podrás hacer todo lo que requieras con PostgreSQL.</p>

    <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
      <div class="col-auto">
        <div class="mb-3">
          <label for="usos" class="form-label">Usos</label>
          <select multiple class="form-select form-select-lg" name="usos" id="usos">
            <option selected>Selecciona alguna acción</option>
            <option value="1">Crear una Tabla</option>
            <option value="2">seleccionar tabla</option>
            <option value="3">seleccionar tabla con condición</option>
            <option value="4">Insertar datos</option>
            <option value="5">Eliminar tabla</option>
          </select>
        </div>
      </div>
      <div class="col-auto">
        <button name="ejecutar" type="submit" class="btn btn-primary">Ejecutar</button>
      </div>
    </form>

    <?php
    if(isset($_POST['nuevo'])){
      $tabla = $_POST['tabla'];
      $contenido = $_POST['contenido'];
      echo crear_tabla_psg($tabla,$contenido);
    }
    if(isset($_POST['eliminar_tabla'])){
      $tabla = $_POST['tabla'];
      echo eliminar_tabla_psg($tabla);
    }
    if(isset($_POST['insertar'])){
      $tabla = $_POST['tabla'];
      $valores = $_POST['valores'];
      $contenido = $_POST['contenido'];
      echo insertar_datos_psg($tabla,$valores,$contenido);
    }
    if(isset($_POST['consulta'])){
      $tabla = $_POST['tabla'];
      $consulta = $_POST['consulta'];
      echo consulta_psg_clasic($consulta,$tabla);
    }
    if(isset($_POST['consulta_where'])){
      $tabla = $_POST['tabla'];
      $consulta = $_POST['consulta'];
      $comparar = $_POST['comparar'];
      $valores = $_POST['valores'];
      echo consulta_psg_where($consulta,$tabla,$comparar,$valores);
    }

    if (isset($_POST['ejecutar'])){
      $opcion = $_POST['usos'];
      if($opcion == 1){
        ?>
        <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">

          <div class="row justify-content-center">

            <div class="col-5">
              <div class="mb-3">
                <label for="tabla" class="form-label">Nombre de la tabla</label>
                <input type="text"
                  class="form-control" name="tabla" id="tabla" aria-describedby="tabla" placeholder="Escribe el nombre de la tabla">
                <small id="tabla" class="form-text text-muted">Pon el nombre de la tabla a crear</small>
              </div>
            </div>

            <div class="col-5">
              <div class="mb-3">
                <label for="contenido" class="form-label">Inserta los valores que contendrá la tabla.</label>
                <textarea class="form-control" name="contenido" id="contenido" rows="4"></textarea>
              </div>
            </div>

            <div class="col-auto">
              <button name ="nuevo" type="submit" class="btn btn-primary">Añadir</button>
            </div>

          </div>

        </form>
        <?php
      }elseif($opcion == 2){
        ?>

        <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">

          <div class="row justify-content-center">

            <div class="col-5">
              <div class="mb-3">
                <label for="tabla" class="form-label">Nombre de la tabla</label>
                <input type="text"
                  class="form-control" name="tabla" id="tabla" aria-describedby="tabla" placeholder="Pon el nombre">
                <small id="tabla" class="form-text text-muted">Inserta el nombre de la tabla por consultar</small>
              </div>
            </div>

            <div class="col-5">
              <div class="mb-3">
                <label for="consulta" class="form-label">Consulta</label>
                <input type="text"
                  class="form-control" name="consulta" id="consulta" aria-describedby="consulta" placeholder="Pon aquí lo que vas a consultar">
                <small id="consulta" class="form-text text-muted">Pon los valores a consultar en la base de datos</small>
              </div>
            </div>

            <div class="col-auto">
              <button name ="consulta" type="submit" class="btn btn-primary">Consultar</button>
            </div>

          </div>

        </form>

        <?php
      }elseif($opcion == 3){
        ?>
        <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
          <div class="row justify-content-center">
          
          <div class="col-5">
              <div class="mb-3">
                <label for="tabla" class="form-label">Nombre de la tabla</label>
                <input type="text"
                  class="form-control" name="tabla" id="tabla" aria-describedby="tabla" placeholder="Pon el nombre">
                <small id="tabla" class="form-text text-muted">Inserta el nombre de la tabla por consultar</small>
              </div>
            </div>

            <div class="col-5">
              <div class="mb-3">
                <label for="consulta" class="form-label">Consulta</label>
                <input type="text"
                  class="form-control" name="consulta" id="consulta" aria-describedby="consulta" placeholder="Pon aquí lo que vas a consultar">
                <small id="consulta" class="form-text text-muted">Pon los valores a consultar en la base de datos</small>
              </div>
            </div>

            <div class="col-5">
              <div class="mb-3">
                <label for="comparar" class="form-label">Pon la comparación</label>
                <input type="text"
                  class="form-control" name="comparar" id="comparar" aria-describedby="comparar" placeholder="Pon la comparación">
                <small id="comparar" class="form-text text-muted">Aquí pones lo que vas a comparar, por ejemplo el id</small>
              </div>
            </div>

            <div class="col-5">
              <div class="mb-3">
                <label for="valor" class="form-label">Valor</label>
                <input type="text"
                  class="form-control" name="valor" id="valor" aria-describedby="valor" placeholder="Pon aquí el valor a comparar">
                <small id="valor" class="form-text text-muted">Aquí pones el valor con el cuál vas a comparar, por ejemplo 1</small>
              </div>
            </div>

            <div class="col-auto">
              <button name ="consulta_where" type="submit" class="btn btn-primary">Consultar</button>
            </div>

          </div>
        </form>
        <?php
      }elseif($opcion == 4){
        ?>
        <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">

          <div class="row justify-content-center">

            <div class="col-5">
              <div class="mb-3">
                <label for="tabla" class="form-label">Tabla</label>
                <input type="text"
                  class="form-control" name="tabla" id="tabla" aria-describedby="tabla" placeholder="Pon el nombre de la tabla">
                <small id="tabla" class="form-text text-muted">Pon la tabla donde se insertará la información.</small>
              </div>
            </div>

            <div class="col-5">
              <div class="mb-3">
                <label for="valores" class="form-label">Valores</label>
                <input type="text"
                  class="form-control" name="valores" id="valores" aria-describedby="valores" placeholder="Pon los valores que se agregarán">
                <small id="valores" class="form-text text-muted">Pon los valores que se insertarán.</small>
              </div>
            </div>

            <div class="col-10">
              <div class="mb-3">
                <label for="contenido" class="form-label">Inserta el contenido a ingresar</label>
                <textarea class="form-control" name="contenido" id="contenido" rows="4"></textarea>
              </div>
            </div>

            <div class="col-auto">
              <button name ="insertar" type="submit" class="btn btn-primary">Añadir</button>
            </div>

          </div>

        </form>
      <?php
      }elseif($opcion == 5){
        ?>
        <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">

          <div class="row justify-content-center">

            <div class="col-10">
              <div class="mb-3">
                <label for="tabla" class="form-label">Tabla</label>
                <input type="text"
                  class="form-control" name="tabla" id="tabla" aria-describedby="tabla" placeholder="Pon el nombre de la tabla">
                <small id="tabla" class="form-text text-muted">Pon la tabla que eliminaremos</small>
              </div>
            </div>

            <div class="col-auto">
              <button name ="eliminar_tabla" type="submit" class="btn btn-primary">Eliminar</button>
            </div>

          </div>

        </form>
      <?php
      }
    }
    ?>

  </div>

  <!-- Bootstrap JavaScript Libraries -->
  <?php footer_admin(); ?>
  <script src="../node_modules/jquery/dist/jquery.min.js"></script>
</body>

</html>