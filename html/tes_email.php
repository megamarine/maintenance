<?php
    require_once("module/model/koneksi/koneksi.php");
    require 'phpmailer/PHPMailerAutoload.php';
    $mail = new PHPMailer;
    $mail->isSendmail();
    $mail->setFrom('no-replymaintenance@megamarinepride.com','no-reply maintenance');
    $mail->addAddress('sysdev@megamarinepride.com');
    $mail->Subject = "Tes";
    $mail->msgHTML("Coba email");
    
    try
    {
        $mail->send();
        echo "Success";
    }
    catch (Exception $e)
    {
        echo "Mailer Error : " . $mail->ErrorInfo;
    }
?>