<!-- JosSecurity está funcionando -->
<link rel="shortcut icon" href="./../../resourses/img/logo transparente/vector/default.svg" type="image/x-icon">
<link rel="stylesheet" href="./../../node_modules/bootstrap/dist/css/bootstrap.min.css">
<script src="./../../node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>

<!-- Video.js base CSS -->
<link href="./../../resourses/css/video-js.min.css" rel="stylesheet">

<?php

if($_ENV['RECAPTCHA'] == 1){?>

<script src="https://www.google.com/recaptcha/api.js"></script>

<?php
  }
?>