<?php

namespace Ahlin\Bundle\MailerBundle\Model\Interfaces;

interface MailUserInterface
{
    /**
     * Get email
     * @return string
     */
    public function getEmail();

    /**
     * Get name
     * @return string
     */
    public function getFullName();
}
