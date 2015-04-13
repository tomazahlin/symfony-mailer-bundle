<?php

namespace Ahlin\Bundle\MailerBundle\Mailer;

use Ahlin\Bundle\MailerBundle\Exception\MailerException;
use Ahlin\Bundle\MailerBundle\Model\AbstractMail;

interface MailerInterface
{
    /**
     * Send message directly without adding it to queue first
     * @param AbstractMail $mail
     * @return MailerInterface
     * @throws MailerException
     */
    public function send(AbstractMail $mail);
}
