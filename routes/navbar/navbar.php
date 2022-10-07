<nav class="navbar navbar-expand-sm navbar-light bg-light">
    <div class="container">
    <a class="navbar-brand" href="https://github.com/josprox/JosSecurity" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-shield-halved"></i> JS</a>
    <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId"
      aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavId">
      <ul class="navbar-nav me-auto mt-2 mt-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="./" aria-current="page"><i class="fa-solid fa-house"></i> Inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="cuenta" aria-current="page"><i class="fa-solid fa-user"></i> Mi Cuenta</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="usuarios" aria-current="page"><i class="fa-solid fa-users"></i> Usuarios</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="registrar" aria-current="page"><i class="fa-solid fa-plus"></i> Registrar</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa-solid fa-gear"></i> Configuraciones</a>
          <div class="dropdown-menu" aria-labelledby="dropdownId">
            <a class="dropdown-item" href="env"><i class="fa-solid fa-file"></i> Archivo env</a>
            <a class="dropdown-item" href="htaccess_public"><i class="fa-solid fa-file"></i> Archivo htaccess público</a>
            <a class="dropdown-item" href="htaccess_jossecurity"><i class="fa-solid fa-file"></i> Archivo htaccess JosSecurity</a>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa-solid fa-gear"></i> Herramientas</a>
          <div class="dropdown-menu" aria-labelledby="dropdownId">
            <a class="dropdown-item" href="head"><i class="fa-solid fa-file-arrow-up"></i> Head global</a>
            <a class="dropdown-item" href="footer"><i class="fa-solid fa-file-arrow-down"></i> Footer global</a>
            <a class="dropdown-item" href="head_admin"><i class="fa-solid fa-file-arrow-up"></i> Head del administrador</a>
            <a class="dropdown-item" href="footer_admin"><i class="fa-solid fa-file-arrow-down"></i> Footer del administrador</a>
            <a class="dropdown-item" href="correo_prueba"><i class="fa-solid fa-envelope"></i> Probar email</a>
            <?php
            if ($_ENV['CONECT_POSTGRESQL'] == 1 OR $_ENV['CONECT_POSTGRESQL_PDO'] == 1){?>
              <a class="dropdown-item" href="postgresql"><i class="fa-solid fa-database"></i> PostgreSQL</a>
              <?php
            }
            ?>
            <?php
            if($_ENV['PLUGINS']==1){?>
            <a class="dropdown-item" href="backups"><i class="fa-solid fa-file-zipper"></i> Realizar Backup</a>
            <a class="dropdown-item" href="not_pay"><i class="fa-regular fa-money-bill-1"></i> didn´t pay</a>
            <?php
            }
            ?>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa-solid fa-code"></i> Avanzado</a>
          <div class="dropdown-menu" aria-labelledby="dropdownId">
            <a class="dropdown-item" href="directorio_admin"><i class="fa-solid fa-folder-tree"></i> Directorios</a>
            <a class="dropdown-item" href="edit_jossecurity"><i class="fa-solid fa-signs-post"></i> Editar funciones</a>
          </div>
        </li>
      </ul>
      <form class="d-flex my-2 my-lg-0" action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
        <button class="btn btn-outline-success my-2 my-sm-0" name ="salir" type="submit">Salir</button>
      </form>
    </div>
  </div>
</nav>

<br>

<div class="container">
<?php
    if($_ENV['DEBUG'] ==1){
  ?>

    <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    <strong>Advertencia</strong> Actualmente tienes el modo DEBUG activado, si estás en modo prueba no hay de que preocuparse, si estás en un entorno de producción favor de desactivar el modo DEBUG en el panel de administración o modificando el archivo .env.
    </div>

  <?php
    }
  ?>
</div>