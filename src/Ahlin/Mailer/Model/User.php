<?php

namespace Ahlin\Mailer\Model;

use Ahlin\Mailer\Model\Interfaces\MailUserInterface;

/**
 * Class User represents a sender or a recipient of the Mail message
 */
class User implements MailUserInterface
{
    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $name;

    /**
     * Constructor
     * @param $email
     * @param $name
     */
    public function __construct($email, $name)
    {
        $this->email = $email;
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * {@inheritdoc}
     */
    public function getFullName()
    {
        return $this->name;
    }
}
