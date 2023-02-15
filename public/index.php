<?php

include (__DIR__ . "/../jossecurity.php");

?>
<!DOCTYPE html>
<html lang="es-MX">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<link rel="stylesheet" href="./../resourses/scss/cookies.css">
<title>Próximamente</title>
<style type="text/css">
    body {
        background-color: #f5f5f5;
        margin-top: 8%;
        color: #5d5d5d;
        font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
        text-shadow: 0px 1px 1px rgba(255,255,255,0.75);
        text-align: center !important;
    }

    h1 {
        font-size: 2.45em;
        font-weight: 700;
        color: #5d5d5d;
        letter-spacing: -0.02em;
        margin-bottom: 30px;
        margin-top: 30px;
    }

    .container {
        width: 100%;
        margin-right: auto;
        margin-left: auto;
    }

    .animated {
        -webkit-animation-duration: 1s;
        animation-duration: 1s;
        -webkit-animation-fill-mode: both;
        animation-fill-mode: both;
    }

    .fadeIn {
        -webkit-animation-name: fadeIn;
        animation-name: fadeIn;
    }
    
    .info {
        color:#5594cf;
        fill:#5594cf;
    }

    .error {
        color:#c92127;
        fill:#c92127;
    }

    .warning {
        color:#ffcc33;
        fill:#ffcc33;
    }

    .success {
        color:#5aba47;
        fill:#5aba47;
    }

    .icon-large {
        height: 132px;
        width: 132px;
    }

    .description-text {
        color: #707070;
        letter-spacing: -0.01em;
        font-size: 1.25em;
        line-height: 20px;
    }

    .footer {
        margin-top: 40px;
        font-size: 0.7em;
    }

    .delay-1s {
        -webkit-animation-delay: 1s;
        animation-delay: 1s;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to   { opacity: 1; }
    }

</style>

    <?php head(); ?>
</head>
<body>
<div class="container text-center">
    <div class="row">
        <div class="col">
            <div class="animated fadeIn">
                <svg class="warning icon-large fa-hard-hat" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path d="M480 288c0-80.25-49.28-148.92-119.19-177.62L320 192V80a16 16 0 0 0-16-16h-96a16 16 0 0 0-16 16v112l-40.81-81.62C81.28 139.08 32 207.75 32 288v64h448zm16 96H16a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h480a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16z"></path>
                </svg>
            </div>
            <h1 class="animated fadeIn">¡Estamos trabajando en ello!</h1>
            <div class="description-text animated fadeIn delay-1s">
                <p>Este sitio está actualmente en construcción.</p>
                <p>Por favor, revise luego.</p>
                <section class="footer"><strong>Dominio:</strong> <?php echo $_ENV['DOMINIO']; ?></section>
            </div>
        </div>
    </div>
</div>

<?php cookie(); footer();?>
</body>
</html>