<?php

namespace Ahlin\Bundle\MailerBundle\Event\Listener;

use Ahlin\Bundle\MailerBundle\Mailer\MailerInterface;
use Ahlin\Bundle\MailerBundle\Mailer\QueueableMailerInterface;

/**
 * Class TerminateListener listens to kernel.terminate event and sends (forwards) all the queued mails to the mailer (ex. Swiftmailer)
 */
class TerminateListener
{
    /**
     * @var MailerInterface
     */
    private $mailer;

    /**
     * @param MailerInterface $mailer
     */
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Sends all mail from the queue, only if the mailer supports it
     */
    public function execute()
    {
        if ($this->mailer instanceof QueueableMailerInterface) {
            $this->mailer->sendAllFromQueue();
        }
    }
}
