<?php

namespace Classes;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Email {
    public $nombre;
    public $email;
    public $token;

    public function __construct($nombre, $email, $token)
    {
        $this->nombre = $nombre;
        $this->email = $email;
        $this->token = $token;
    }
    public function enviarEmail() {
        $mail = new PHPMailer(true);
        $mail->isSMTP();                                             // Enviar usando SMTP
        $mail->Host       = $_ENV["EMAIL_HOST"];              // Configura el servidor SMTP para enviar
        $mail->SMTPAuth   = true;                                    // Habilitar autenticación SMTP
        $mail->Username   = $_ENV["EMAIL_USER"];                        // Usuario SMTP
        $mail->Password   = $_ENV["EMAIL_PASS"];                        // Contraseña SMTP
        // $mail->SMTPSecure = 'tls';                                   // Habilitar encriptación TLS
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = $_ENV["EMAIL_PORT"];                                    // Puerto TCP para conectar

        $mail->setFrom($_ENV["EMAIL_FROM"], 'AppSalon Barberia y Peluqueria');
        $mail->addAddress($this->email);
    
        $mail->isHTML(true);
        $mail->CharSet = "UTF-8";
        $mail->Subject = "Appsalon Validar cuenta";
        $mail->Body = '<h1>Verificación de cuenta</h1>';
        $mail->Body .='<p>Buenos dias, <strong>' . $this->nombre . '</strong>, esto es un mensaje para validar la creación de tu cuenta en <strong>App Salon Barbería y Peluqueria</strong></p>';
        $mail->Body .='<p>Para la verificacíon de tu cuenta vamos a necesitar que ingreses al siguiente enlace para validar tu cuenta ';
        $mail->Body .='<a href="'. $_ENV["APP_URL"] .'/verificarCuenta?token='. $this->token.'">Verificar Cuenta</a>';
        $mail->Body .='<br>';
        $mail->Body .='Si no fuiste tú, puedes ignorar el mensaje.';
        $mail->AltBody = 'Esta es la versión en texto plano del contenido del email';
        $mail->send();
    }
    public function mensajeReestablecerPassword() {
        $mail = new PHPMailer(true);
        $mail->isSMTP();                                             // Enviar usando SMTP
        $mail->Host       = $_ENV["EMAIL_HOST"];              // Configura el servidor SMTP para enviar
        $mail->SMTPAuth   = true;                                    // Habilitar autenticación SMTP
        $mail->Username   = $_ENV["EMAIL_USER"];                        // Usuario SMTP
        $mail->Password   = $_ENV["EMAIL_PASS"];                        // Contraseña SMTP
        $mail->SMTPSecure = 'tls';                                   // Habilitar encriptación TLS
        $mail->Port       = $_ENV["EMAIL_PORT"];                                    // Puerto TCP para conectar

        $mail->setFrom($_ENV["EMAIL_FROM"], 'AppSalon Barberia y Peluqueria');
        $mail->addAddress($this->email, 'Para: ');

        $mail->isHTML(true);
        $mail->CharSet = "UTF-8";
        $mail->Subject = "Appsalon Recuperar Password";
        $mail->Body = '<h1>Recuperar Password</h1>';
        $mail->Body .='<p>Buenos dias, <strong>' . $this->nombre . '</strong>, esto es un mensaje para reestablecer tu Password en <strong>App Salon Barbería y Peluqueria</strong></p>';
        $mail->Body .='<p>Para la verificacíon de tu cuenta vamos a necesitar que ingreses al siguiente enlace para reestablecer tu password';
        $mail->Body .='<a href="'. $_ENV["APP_URL"] .'/reestablecerPassword?token='. $this->token.'">Reestablecer Password</a>';
        $mail->Body .='<br>';
        $mail->Body .='Si no fuiste tú, puedes ignorar el mensaje.';
        $mail->AltBody = 'Esta es la versión en texto plano del contenido del email';
        $mail->send();
    }
    public function passwordSuccess() {
        $mail = new PHPMailer(true);
        $mail->isSMTP();                                             // Enviar usando SMTP
        $mail->Host       = $_ENV["EMAIL_HOST"];              // Configura el servidor SMTP para enviar
        $mail->SMTPAuth   = true;                                    // Habilitar autenticación SMTP
        $mail->Username   = $_ENV["EMAIL_USER"];                        // Usuario SMTP
        $mail->Password   = $_ENV["EMAIL_PASS"];                        // Contraseña SMTP
        $mail->SMTPSecure = 'tls';                                   // Habilitar encriptación TLS
        $mail->Port       = $_ENV["EMAIL_PORT"];                                    // Puerto TCP para conectar

        $mail->setFrom($_ENV["EMAIL_FROM"], 'AppSalon Barberia y Peluqueria');
        $mail->addAddress($this->email, 'Para: ');

        $mail->isHTML(true);
        $mail->CharSet = "UTF-8";
        $mail->Subject = "Appsalon Cambio de contraseña";
        $mail->Body = '<h1>Cambio de contraseña</h1>';
        $mail->Body .='<p>Tu cambio de contraseña fue exitoso ';
        $mail->Body .='<br>';
        $mail->Body .='<a href="'. $_ENV["APP_URL"] .'/" >Iniciar Sesion</a>';
        $mail->Body .= "</p>";
        $mail->send();
    }

}
