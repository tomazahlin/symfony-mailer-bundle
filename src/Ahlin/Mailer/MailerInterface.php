<?php

namespace Ahlin\Mailer;

use Ahlin\Mailer\Exception\MailerException;
use Ahlin\Mailer\Model\AbstractMail;

interface MailerInterface
{
    /**
     * Send message directly without adding it to queue first
     * 
     * @param AbstractMail $mail
     * @return MailerInterface
     * @throws MailerException
     */
    public function send(AbstractMail $mail);

    /**
     * Send a swift message
     * 
     * Useful when you have created swift message already by yourself
     * 
     * @param \Swift_Mime_Message $message
     * @return MailerInterface
     * @throws MailerException
     */
    public function sendSwiftMessage(\Swift_Mime_Message $message);
}
