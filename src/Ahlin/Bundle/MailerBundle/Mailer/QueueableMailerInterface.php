<?php

namespace Ahlin\Bundle\MailerBundle\Mailer;

use Ahlin\Bundle\MailerBundle\Exception\MailerException;
use Ahlin\Bundle\MailerBundle\Model\AbstractMail;

interface QueueableMailerInterface extends MailerInterface
{
    /**
     * Add mail to queue
     * @param AbstractMail $mail
     * @return QueueableMailerInterface
     */
    public function enqueue(AbstractMail $mail);

    /**
     * Send first message from the queue
     * @return QueueableMailerInterface
     * @throws MailerException
     */
    public function sendFirstFromQueue();

    /**
     * Send all mails from the queue
     * @return QueueableMailerInterface
     */
    public function sendAllFromQueue();
}
