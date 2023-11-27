<?php

//Al igual que tenemos funcione helper en includes, tmb podemos tener clases helper 
//que nos ayuden a no cargar tanto  a los controladores

//Esta clase sirve para el evio de emails


namespace Classes;


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class Email{

    public $email;
    public $nombre;
    public $token;


    public function __construct($email, $nombre, $token){

        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;

    }


    public function enviarConfirmacion(){

        //crear el objeto de email
        $mail = new PHPMailer();

        //Configurar SMTP
        $mail->isSMTP();
        $mail->Host = $_ENV["EMAIL_HOST"];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV["EMAIL_USER"];
        $mail->Password = $_ENV["EMAIL_PASS"];
        $mail->SMTPSecure = "tls";
        $mail->Port = $_ENV["EMAIL_PORT"];

        //Configurar el contenido del email
        $mail->setFrom("drasgadomiguel@gmail.com");
        $mail->addAddress("drasgadomiguel@gmail.com","Appsalon.com.mx");
        $mail->Subject = "Confirma tu cuenta";

        //Habilitar HTML
        $mail->isHTML(true);
        $mail->CharSet = "UTF-8";

        //Definir contenido
        $contenido = "<html>";
        $contenido .= "<p> <strong>Hola " . $this->nombre ."</strong> Has creado tu cuenta en App
        Salon, solo debes confirmarla presionando el siguiente enlace</p>";
        $contenido .= "<p>Presiona aquí: <a href='" . $_ENV["APP_URL"] . "/confirm-account?token="
        . $this->token . "'>Confirmar cuenta</a> </p>";
        $contenido .= "<p> Si tu no solicitaste esta cuenta, solo ignora este correo</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        //Enviar email creado
        $mail->send();

    }

    public function enviarInstrucciones(){

        //crear el objeto de email
        $mail = new PHPMailer();

        //Configurar SMTP
        $mail->isSMTP();
        $mail->Host = $_ENV["EMAIL_HOST"];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV["EMAIL_USER"];
        $mail->Password = $_ENV["EMAIL_PASS"];
        $mail->SMTPSecure = "tls";
        $mail->Port = $_ENV["EMAIL_PORT"];

        //Configurar el contenido del email
        $mail->setFrom("drasgadomiguel@gmail.com");
        $mail->addAddress("drasgadomiguel@gmail.com","Appsalon.com.mx");
        $mail->Subject = "Reestablce tu password";

        //Habilitar HTML
        $mail->isHTML(true);
        $mail->CharSet = "UTF-8";

        //Definir contenido
        $contenido = "<html>";
        $contenido .= "<p> <strong>Hola " . $this->nombre ."</strong> Has solicitado reestablcer tu contraseña de tu cuenta en App
        Salon, sigue el siguiente enlace para hacerlo.</p>";
        $contenido .= "<p>Presiona aquí: <a href='" . $_ENV["APP_URL"] . "/reset?token="
        . $this->token . "'>Reestablcer contraseña</a> </p>";
        $contenido .= "<p> Si tu no solicitaste este cambio, solo ignora este correo</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        //Enviar email creado
        $mail->send();

    }

}

