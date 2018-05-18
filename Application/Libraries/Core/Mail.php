<?php

namespace Libraries\Core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mail
{

    private $mailObject;
    private $error;

    /**
     * Server settings
     */
    public function __construct()
    {
        $mail = new PHPMailer(true);

        $mail->SMTPDebug = 0;
        $mail->CharSet = 'UTF-8';

        // Set mailer to use SMTP
        $mail->IsSMTP();

        $mail->Host = Config::get('EMAIL_SMTP_HOST');
        $mail->SMTPAuth = Config::get('EMAIL_SMTP_AUTH');
        $mail->Username = Config::get('EMAIL_SMTP_USERNAME');
        $mail->Password = Config::get('EMAIL_SMTP_PASSWORD');
        $mail->SMTPSecure = Config::get('EMAIL_SMTP_ENCRYPTION');
        $mail->Port = Config::get('EMAIL_SMTP_PORT');

        $this->mailObject = $mail;
    }

    /**
     * Add a "To" address.
     * @param string $address
     * @param string $name
     */
    public function addRecipient(string $address, string $name = '')
    {
        $this->mailObject->addAddress($address, $name);
    }

    /**
     * Add a "Reply-To" address.
     * @param string $address
     * @param string $name
     */
    public function addReplyTo(string $address, string $name = '')
    {
        $this->mailObject->addReplyTo($address, $name);
    }

    /**
     * Add a "CC" address.
     * @param string $address
     * @param string $name
     */
    public function addCC(string $address, string $name = '')
    {
        $this->mailObject->addCC($address, $name);
    }

    /**
     * Add a "BCC" address.
     * @param string $address
     * @param string $name
     */
    public function addBCC(string $address, string $name = '')
    {
        $this->mailObject->AddBCC($address, $name);
    }
    
    /**
     * Set email content
     * @param string $subject
     * @param string $body
     * @param bool $isHTML
     */
    public function addContent(string $subject, string $body, string $altBody = '', bool $isHTML = true)
    {
        $this->mailObject->isHTML($isHTML);
        $this->mailObject->Subject = $subject;
        $this->mailObject->Body = $body;
        $this->mailObject->AltBody = $altBody;
    }
    
    /**
     * Add an attachment from a path on the filesystem
     * @param string $path
     * @param string $name
     */
    public function addAttachment(string $path, string $name = '')
    {
        $this->mailObject->addAttachment($path, $name);
    }

    /**
     * Send email message
     * @param string $fromEmail
     * @param string $fromName
     * @return bool
     */
    public function sendMessage(string $fromEmail, string $fromName): bool
    {
        $this->mailObject->setFrom($fromEmail, $fromName);

        try {
            $this->mailObject->Send();
            return true;
        } catch (Exception $ex) {
            $this->error = $this->mailObject->ErrorInfo;
            return false;
        }
    }

    /**
     * Returns error message
     * @return string
     */
    public function getError(): string
    {
        return $this->error ?? '';
    }

}
