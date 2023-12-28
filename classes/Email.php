<?php

namespace Classes;

use Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class Email {
    public $email;
    public $nombre;
    public $token;


    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion(){
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);
        //Crear el objeto de email
        try {
            $mail->isSMTP();
            $mail->Host = $_ENV['EMAIL_HOST'];
            $mail->SMTPAuth = true;
            $mail->Port = $_ENV['EMAIL_PORT'];
            $mail->Username = $_ENV['EMAIL_USER'];
            $mail->Password = $_ENV['EMAIL_PASS'];
            $mail->setFrom('cuentas@appsalon.com'); // Define el email y nombre del remitente del mensaje.
            $mail->addAddress('cuentas@appsalon.com', 'appsalon.com');
            $mail->Subject = "Confirma tu Cuenta";

            //Content
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';

            $contenido = "<html>";
            $contenido .= "<p>Hola <strong>" . $this->nombre . "<br></strong> Haz creado tú cuenta en App Salon, Solo debes confirmarla presionando el siguiente enlace</p>";
            $contenido .= "<p>Presiona aquí: <a href='". $_ENV['DOMINIO_URL'] . "/confirmar-cuenta?token=" . $this->token . "'>Confirmar Cuenta</a></p>";
            $contenido .= "<p>Si tú no solicitaste esta cuenta, puedes ignorar el mensaje</p>";
            $contenido .= "</html>";

            $mail->Body = $contenido;

            //Enviar el mail
            $mail->send();
            // echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
    
    public function enviarInstrucciones(){
        $mail = new PHPMailer(true);
        //Crear el objeto de email
        try {
            $mail->isSMTP();
            $mail->Host = $_ENV['EMAIL_HOST'];
            $mail->SMTPAuth = true;
            $mail->Port = $_ENV['EMAIL_PORT'];
            $mail->Username = $_ENV['EMAIL_USER'];
            $mail->Password = $_ENV['EMAIL_PASS'];
            $mail->setFrom('cuentas@appsalon.com'); // Define el email y nombre del remitente del mensaje.
            $mail->addAddress('cuentas@appsalon.com', 'appsalon.com');
            $mail->Subject = "Reestablece tú password";

            //Content
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';

            $contenido = "<html>";
            $contenido .= "<p>Hola <strong>" . $this->nombre . "<br></strong>Haz solicitado reestablecer tú password, sigue el siguiente enlace</p>";
            $contenido .= "<p>Presiona aquí: <a href='". $_ENV['DOMINIO_URL'] . "/recuperar?token=" . $this->token . "'>Reestablecer Password </a></p>";
            $contenido .= "<p>Si tú no solicitaste esta cuenta, puedes ignorar el mensaje</p>";
            $contenido .= "</html>";

            $mail->Body = $contenido;

            //Enviar el mail
            $mail->send();
            // echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}