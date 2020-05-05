<?php
require './vendor/autoload.php';
class Mail
{
    //email sturen
    public static function sendMail($key, $subject, $email,$content){
        $mail = new \SendGrid\Mail\Mail(); 
        $mail->setFrom("info@imdamigos.site", "Amigos");
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