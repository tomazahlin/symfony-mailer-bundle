<?php

namespace Ahlin\Bundle\MailerBundle\Model\Interfaces;

use Swift_Mime_Message;
use Symfony\Component\Templating\EngineInterface;

interface MailInterface extends MailParameterInterface
{
    /**
     * Transform MailInterface to Swift_Mime_Message interface
     * @param EngineInterface $templating
     * @param string $templatePath - Full template path for the EngineInterface to use
     * @param $contentType
     * @return Swift_Mime_Message
     */
    public function transform(EngineInterface $templating, $templatePath, $contentType);

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
