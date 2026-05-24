<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../admin/libraries/phpmailer/src/Exception.php';
require_once __DIR__ . '/../admin/libraries/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/../admin/libraries/phpmailer/src/SMTP.php';

function sendShipmentEmail($to, $subject, $message)
{
    $mail = new PHPMailer(true);

    try {

        $mail->isSMTP();

        $mail->Host = 'smtp.gmail.com';

        $mail->SMTPAuth = true;

        $mail->Username = 'mhe.terrence@gmail.com';

        $mail->Password = 'fkab xiqm ljtk slye';

        $mail->SMTPSecure = 'tls';

        $mail->Port = 587;

        $mail->setFrom(
            'YOUR_EMAIL@gmail.com',
            'NexFreight'
        );

        $mail->addAddress($to);

        $mail->isHTML(true);

        $mail->Subject = $subject;

        $mail->Body = $message;

        $mail->send();

        return true;

    } catch (Exception $e) {

        return false;

    }
}