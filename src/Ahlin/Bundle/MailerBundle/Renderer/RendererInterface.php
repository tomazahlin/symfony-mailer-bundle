<?php

namespace Ahlin\Bundle\MailerBundle\Renderer;

use Ahlin\Bundle\MailerBundle\Exception\MailingException;
use Ahlin\Bundle\MailerBundle\Mapping\TemplateMappingInterface;
use Ahlin\Bundle\MailerBundle\Model\Interfaces\MailInterface;

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
