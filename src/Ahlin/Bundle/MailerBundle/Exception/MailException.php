<?php

namespace Ahlin\Bundle\MailerBundle\Exception;

/**
 * Class MailException
 * The purpose of this exception is to be thrown during mail creation process
 */
class MailException extends MailingException
{
    /**
     * {@inheritdoc}
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
