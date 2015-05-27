<?php

namespace Ahlin\Mailer\Exception;

use Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class MailingException
 * The purpose of this exception is present a base exception for mailing
 */
abstract class MailingException extends Exception
{
    /**
     * {@inheritdoc}
     */
    public function __construct($message, $code = Response::HTTP_INTERNAL_SERVER_ERROR, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
