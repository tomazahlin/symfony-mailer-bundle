<?php

namespace Ahlin\Mailer;

use Ahlin\Mailer\Factory\MailFactory;

interface MailingInterface
{
    /**
     * Get mailer
     * @return MailerInterface|QueueableMailerInterface
     */
    public function getMailer();

    /**
     * Get mail factory
     * @return MailFactory
     */
    public function getFactory();
}
