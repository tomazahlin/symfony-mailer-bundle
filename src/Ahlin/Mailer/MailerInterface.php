<?php

namespace Ahlin\Mailer;

use Ahlin\Mailer\Exception\MailerException;
use Ahlin\Mailer\Model\Interfaces\MailInterface;

interface MailerInterface
{
    /**
     * Send message directly without adding it to queue first
     * @param MailInterface $mail
     * @return MailerInterface
     * @throws MailerException
     */
    public function send(MailInterface $mail);
}
