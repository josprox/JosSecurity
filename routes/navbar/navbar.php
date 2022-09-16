<nav class="navbar navbar-expand-sm navbar-light bg-light">
    <div class="container">
    <a class="navbar-brand" href="https://github.com/josprox/JosSecurity">JS Panel</a>
    <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId"
      aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavId">
      <ul class="navbar-nav me-auto mt-2 mt-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="./" aria-current="page">Inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="cuenta" aria-current="page">Mi Cuenta</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="registrar" aria-current="page">Registrar</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="env">Configuración</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Herramientas</a>
          <div class="dropdown-menu" aria-labelledby="dropdownId">
            <a class="dropdown-item" href="head">Head global</a>
            <a class="dropdown-item" href="footer">Footer global</a>
            <a class="dropdown-item" href="head_admin">Head del administrador</a>
            <a class="dropdown-item" href="footer_admin">Footer del administrador</a>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Avanzado</a>
          <div class="dropdown-menu" aria-labelledby="dropdownId">
            <a class="dropdown-item" href="directorio_admin">Directorios</a>
            <a class="dropdown-item" href="edit_jossecurity">Editar funciones</a>
          </div>
        </li>
      </ul>
      <form class="d-flex my-2 my-lg-0" action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
        <button class="btn btn-outline-success my-2 my-sm-0" name ="salir" type="submit">Salir</button>
      </form>
    </div>
  </div>
</nav>