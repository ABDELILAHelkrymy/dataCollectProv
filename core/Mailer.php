<?php

namespace Core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception as PHPMailerException;
use Exception;

class MailerException extends Exception
{
}

class Mailer
{
    static $mail;

    public static function send($mailOptions)
    {
        $to = $mailOptions['to'];
        //$from = $mailOptions['from'];
        $cc = $mailOptions['cc'] ?? null;
        $subject = $mailOptions['subject'] ?? "Mail from Habilitation App";
        $body = $mailOptions['body'] ?? "This is a mail from Habilitation App.";
        $attachments = $mailOptions['attachments'] ?? null;
        $mode = $mailOptions['mode'] ?? null;

        if (!$to) {
            throw new MailerException(__METHOD__ . " : Recipient email not received");
        }
        // if (!$from) {
        //     throw new MailerException(__METHOD__ . " : Sender email not received");
        // }

        self::requireFiles();
        SMTP::DEBUG_SERVER;
        self::createMail($mode);
        // self::addFrom($from);
        // self::addRecipients($from);
        self::addRecipients($to);
        if ($cc !== null && !empty($cc) && $cc[0] !== "") {
            self::addCCs($cc);
        }
        self::addAttachments($attachments);

        self::$mail->isHTML(true);
        self::$mail->Subject = $subject;
        self::$mail->Body = $body;

        try {
            self::$mail->send();
        } catch (PHPMailerException $e) {
            throw new MailerException($e->getMessage());
        }
    }

    private static function requireFiles()
    {
        require_once APP_ROOT . '/packages/PHPMailer/src/Exception.php';
        require_once APP_ROOT . '/packages/PHPMailer/src/PHPMailer.php';
        require_once APP_ROOT . '/packages/PHPMailer/src/SMTP.php';
    }

    private static function createMail($mode)
    {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        // setup ssl encryption
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Host = $_ENV['SMTP_HOST'];
        if ($mode === 'COMPTE_CREATION') {
            $mail->Username = $_ENV['SMTP_RH_USERNAME'];
            $mail->Password = $_ENV['SMTP_RH_PASSWORD'];
            $mail->addEmbeddedImage(APP_ROOT . '/signatures/signature_srh1.png', 'signature');
        } else {
            $mail->Username = $_ENV['SMTP_ADMIN_USERNAME'];
            $mail->Password = $_ENV['SMTP_ADMIN_PASSWORD'];
        }
        $mail->Port = (int) $_ENV['SMTP_PORT'];

        //$mail->SMTPDebug = 4;
        self::$mail = $mail;
    }

    private static function addFrom($from)
    {
        if (is_array($from) && !isset($from['email'])) {
            throw new MailerException("Sender email not found");
        } elseif (is_array($from)) {
            self::$mail->setFrom($from['email'], $from['name'] ?? '');
        } elseif (is_string($from)) {
            self::$mail->setFrom($from);
        }
    }

    private static function addRecipients($to)
    {
        if (is_array($to) && isset($to['email'])) {
            self::addRecipient($to);
        } elseif (is_array($to)) {
            foreach ($to as $recipient) {
                self::addRecipient($recipient);
            }
        } else {
            self::addRecipient($to);
        }
    }

    private static function addRecipient($to)
    {
        if (is_array($to) && !isset($to['email'])) {
            throw new MailerException("Invalid recipient " . json_encode($to));
        } elseif (is_array($to)) {
            self::$mail->addAddress($to['email'], $to['name'] ?? '');
        } else {
            self::$mail->addAddress($to);
        }
    }

    private static function addCCs($cc)
    {
        if (is_array($cc) && isset($cc['email'])) {
            self::addCC($cc);
        } elseif (is_array($cc)) {
            foreach ($cc as $recipient) {
                self::addCC($recipient);
            }
        } else {
            self::addCC($cc);
        }
    }

    private static function addCC($cc)
    {
        if (is_array($cc) && !isset($cc['email'])) {
            throw new MailerException("Invalid CC recipient " . json_encode($cc));
        } elseif (is_array($cc)) {
            self::$mail->addCC($cc['email'], $cc['name'] ?? '');
        } else {
            self::$mail->addCC($cc);
        }
    }

    private static function addAttachments($attachments)
    {
        if (is_array($attachments) && isset($attachments["path"])) {
            self::addAttachment($attachments);
        } elseif (is_array($attachments)) {
            foreach ($attachments as $attachment) {
                self::addAttachment($attachment);
            }
        } else {
            self::addAttachment($attachments);
        }
    }

    private static function addAttachment($attachment)
    {
        if (is_array($attachment) && !isset($attachment["path"])) {
            throw new MailerException("Attachment path not found");
        } elseif (is_array($attachment)) {
            self::$mail->addAttachment($attachment["path"], $attachment["name"] ?? "Piece jointe");
        } else {
            self::$mail->addAttachment($attachment);
        }
    }
}
