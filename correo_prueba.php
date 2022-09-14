<!doctype html>
<html lang="es-MX">

<head>
  <title>Formulario</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.0-beta1 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css"
    integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

</head>

<body>

    <div class="container">
        <form action="index.php" method="post">
        <div class="mb-3 row">
                <label for="inputName" class="col-4 col-form-label">Nombre</label>
                <div class="col-8">
                    <input type="text" class="form-control" name="nombre" id="nombre" placeholder="nombre">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="inputName" class="col-4 col-form-label">Asunto</label>
                <div class="col-8">
                    <input type="text" class="form-control" name="asunto" id="asunto" placeholder="asunto">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="inputName" class="col-4 col-form-label">cuerpo</label>
                <div class="col-8">
                    <input type="text" class="form-control" name="cuerpo" id="cuerpo" placeholder="cuerpo">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="inputName" class="col-4 col-form-label">correo</label>
                <div class="col-8">
                    <input type="email" class="form-control" name="correo" id="correo" placeholder="correo">
                </div>
            </div>
            <div class="mb-3 row">
                <div class="offset-sm-4 col-sm-8">
                    <button type="submit" name="mail" class="btn btn-primary">Enviar</button>
                </div>
            </div>
        </form>
    </div>

    <!-- place footer here -->
  </footer>
  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js"
    integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js"
    integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous">
  </script>
</body>

</html>