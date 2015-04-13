<?php

namespace Ahlin\Bundle\MailerBundle;

use Ahlin\Bundle\MailerBundle\Mailer\MailerInterface;
use Ahlin\Bundle\MailerBundle\Mailer\QueueableMailerInterface;
use Ahlin\Bundle\MailerBundle\Factory\MailFactory;

/**
 * Class Mailing is a composite class which holds Mailer and the Factory,
 * so only one service is publicly exposed and to be injected in other services
 */
class Mailing
{
    /**
     * @var MailerInterface
     */
    private $mailer;

    /**
     * @var MailFactory
     */
    private $factory;

    /**
     * Constructor.
     * @param MailerInterface $mailer
     * @param MailFactory $factory
     */
    public function __construct(MailerInterface $mailer, MailFactory $factory)
    {
        $this->mailer = $mailer;
        $this->factory = $factory;
    }

    /**
     * Get mailer
     * @return MailerInterface|QueueableMailerInterface
     */
    public function getMailer()
    {
        return $this->mailer;
    }

    /**
     * Get mail factory
     * @return MailFactory
     */
    public function getFactory()
    {
        return $this->factory;
    }
}
