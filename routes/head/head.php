<!-- JosSecurity head está funcionando -->
<?php 
$pagina = nombre_de_pagina();
if ($pagina  == "panel.php"){
  global $nombre_app;
  ?>
  <!-- Meta descripcion -->
  <meta name="description" content="Inicia sesión de una manera rápida y segura con <?php echo $nombre_app; ?>, un sistema fácil de usar.">
  <!-- Hestia -->
  <link rel="stylesheet" href="../resourses/scss/hestia.css">
  <!-- Bootstrap min -->
  <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
  <!-- fontawesome -->
  <link rel="stylesheet" href="../node_modules/@fortawesome/fontawesome-free/css/all.min.css">
  <!-- logo -->
  <link rel="shortcut icon" href="../resourses/img/logo transparente/vector/default.svg" type="image/x-icon">
  <!-- SweetAlert2 -->
  <script src="../node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
  <!-- Video.js base CSS -->
  <link href="../resourses/css/video-js.min.css" rel="stylesheet">
  <?php
}elseif($pagina  != "panel.php"){
  ?>
  <!-- Aquí va el código del head propio -->
  <?php
}
?>

<?php

if($_ENV['RECAPTCHA'] == 1){?>

<script src="https://www.google.com/recaptcha/api.js"></script>

<?php
  }
?>