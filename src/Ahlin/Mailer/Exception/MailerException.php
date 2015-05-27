<?php

namespace Ahlin\Mailer\Exception;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class MailerException
 * The purpose of this exception is to be thrown during mail sending process
 */
class MailerException extends MailingException
{
    /**
     * {@inheritdoc}
     */
    public function __construct($message, $code = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        parent::__construct($message, $code);
    }
}
