<!-- JosSecurity está funcionando -->
<link rel="stylesheet" href="./../node_modules/bootstrap/dist/css/bootstrap.min.css">
<script src="./../node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
<?php

if($_ENV['RECAPTCHA'] == 1){?>

<script src="https://www.google.com/recaptcha/api.js"></script>

<?php
  }
?>