<?php

class Send_Mail {

    public function Send_Mail($subject, $mail, $list) {
        date_default_timezone_set('Europe/Berlin');


        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = "smtp.1und1.de";
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->Username = "ocd@goldwingstudios.de";
        $mail->Password = "L#/2nO1";
        $mail->isHTML(true);
        $mail->setFrom('ocd@goldwingstudios.de', 'Goldwingstudios');

        if (is_array($list)) {
            foreach ($list as $item) {
                $mail->addAddress($item);
            }
        } else {
            $mail->addAddress($list);
        }

        $mail->Subject = $subject;
        $mail->Body = $mail;

        if (!$mail->send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            echo "Message sent!";
        }
    }

}
