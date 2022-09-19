<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . './../vendor/phpmailer/phpmailer/src/Exception.php';
require __DIR__ . './../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require __DIR__ .'./../vendor/phpmailer/phpmailer/src/SMTP.php';

// Load .env
require __DIR__ . './../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__, './../.env');
$dotenv->load();

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 0;
    $mail->isSMTP(); 
    $mail->Host       = $_ENV['SMTP_SERVER'];
    $mail->SMTPAuth   = true;
    $mail->Username   = $_ENV['SMTP_USERNAME'];
    $mail->Password   = $_ENV['SMTP_PASSWORD'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = $_ENV['SMTP_PORT'];

    //Recipients
    $mail->setFrom( $_ENV['SMTP_USERNAME'], $nombre);
    $mail->addAddress($correo);

    //Content
    $mail->isHTML(true);
    $mail->Subject = $asunto;
    $mail-> CharSet = 'UTF-8';
    $mail->Body    = $cuerpo;

    $mail->SMTPAutoTLS = false;
    $mail->SMTPOptions = array(
        'ssl' => array(
          'crypto_method' => STREAM_CRYPTO_METHOD_TLSv1_3_CLIENT
        )
    );

    $mail->send();
} catch (Exception $e) {
    echo "Tuvimos un error, pruebalo mas tarde: {$mail->ErrorInfo}";
}

?>