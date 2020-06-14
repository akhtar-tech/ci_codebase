<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/**
 * Mailer Class
 *
 * @author    Sandeep Kumar <ki.sandeep11@gmail.com>
 */
class Mailer
{

    public $mailx;
    public $config;

    public function __construct()
    {
    }

    public function load()
    {
        $objMail = new PHPMailer;
        return $objMail;
    }


    public function sendMail($subject, $content, array $to = array(), $global = TRUE)
    {
        if ($this->config) {


            $config = $this->config;

            if ($global) {
                if (count($config['default_recipient'])) {
                    foreach ($config['default_recipient'] as $default_recipient) {
                        $to[] = $default_recipient;
                    }
                }
            }

            if (count($to)) {


                $mail = $this->load();

                $mail->SMTPDebug = 3;                               // Enable verbose debug output

                $mail->isSMTP();                                      // Set mailer to use SMTP
                $mail->Host = $config['host'];  // Specify main and backup SMTP servers
                $mail->SMTPAuth = $config['auth'];                               // Enable SMTP authentication
                $mail->Username = $config['username'];                 // SMTP username
                $mail->Password = $config['password'];                           // SMTP password
                $mail->SMTPSecure = $config['smtpsecure'];                            // Enable TLS encryption, `ssl` also accepted
                $mail->Port = $config['port'];                                    // TCP port to connect to

                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );

                $mail->setFrom($config['from'], @$config['from_name']);

                foreach ($to as $to_email) {
                    $mail->addAddress($to_email);     // Add a recipient
                }


                //$mail->addAddress('ellen@example.com');               // Name is optional
                //$mail->addReplyTo('info@example.com', 'Information');
                //$mail->addCC('cc@example.com');
                //$mail->addBCC('bcc@example.com');

                //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
                //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
                $mail->isHTML(true);                                  // Set email format to HTML

                $mail->Subject = $subject;
                $mail->Body = $content;
                //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                if (!$mail->send()) {
                    //echo 'Message could not be sent.';
                    return array('message' => 'Mailer Error: ' . $mail->ErrorInfo, 'status' => false);
                } else {
                    return array('message' => 'Message has been sent', 'status' => true);
                }
            }
        } else {
            return array('message' => 'config not found', 'status' => false);
        }
    }
}
