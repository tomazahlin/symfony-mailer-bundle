<?php

namespace Ahlin\Bundle\MailerBundle\Mailer;

use Ahlin\Bundle\MailerBundle\Factory\MailFactory;

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
