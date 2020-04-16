<?php
require './vendor/autoload.php';
class Mail
{
    //email sturen
    public static function sendMail($subject, $email,$content){
        $key = "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";
        $mail = new \SendGrid\Mail\Mail(); 
        $mail->setFrom("frederichermans@hotmail.com", "Amigos User");
        $mail->setSubject($subject);
        $mail->addTo($email);
        $mail->addContent("text/html", $content);
        $sendgrid = new \SendGrid($key);
        try {
            $response = $sendgrid->send($mail);
            return $response;
        } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }
    }
}