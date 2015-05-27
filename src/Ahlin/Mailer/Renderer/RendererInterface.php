<?php

namespace Ahlin\Mailer\Renderer;

use Ahlin\Mailer\Exception\MailingException;
use Ahlin\Mailer\Mapping\TemplateMappingInterface;
use Ahlin\Mailer\Model\Interfaces\MailInterface;

interface RendererInterface
{
    /**
     * @param TemplateMappingInterface $mapping
     * @return RendererInterface
     */
    public function addMapping(TemplateMappingInterface $mapping);

    /**
     * Transforms SwiftTransformationInterface to \Swift_Message using EngineInterface
     * In case of any errors an instance of MailingException is thrown
     * @param MailInterface $mail
     * @return \Swift_Message
     * @throws MailingException
     */
    public function render(MailInterface $mail);
}
