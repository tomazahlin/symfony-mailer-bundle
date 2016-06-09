<?php

namespace Ahlin\Mailer\Filter;

interface FilterInterface
{
    /**
     * Apply a filter to the body after the template was rendered.
     *
     * Can be used for example:
     *  - To replace relative image paths with absolute paths, or make inline images with cid
     *    This means the html (body) will have some paths replaced, and in the same time some attachments must be added to the Swift_Message.
     *
     * @param string $body
     * @param \Swift_Message $message
     * @return string
     */
    public function apply($body, \Swift_Message $message);
}
