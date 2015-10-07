<?php

namespace Ahlin\Mailer\Model\Interfaces;

use Swift_Mime_Message;
use Symfony\Component\Templating\EngineInterface;

interface MailInterface extends MailParameterInterface
{
    /**
     * Transform MailInterface to Swift_Mime_Message interface
     * @param EngineInterface $templating
     * @param array $templates
     * @return Swift_Mime_Message
     */
    public function transform(EngineInterface $templating, array $templates);

    /**
     * Get template name
     * @return string
     */
    public function getTemplate();

    /**
     * Get mail priority
     * @return integer
     */
    public function getPriority();
}
