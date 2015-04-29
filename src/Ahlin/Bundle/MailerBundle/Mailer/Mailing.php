<?php

namespace Ahlin\Bundle\MailerBundle\Mailer;

use Ahlin\Bundle\MailerBundle\Factory\MailFactory;

/**
 * Class Mailing is a composite class which holds Mailer and the Factory,
 * so only one service is publicly exposed and to be injected in other services
 */
class Mailing implements MailingInterface
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
     * {@inheritDoc}
     */
    public function getMailer()
    {
        return $this->mailer;
    }

    /**
     * {@inheritDoc}
     */
    public function getFactory()
    {
        return $this->factory;
    }
}
