<?php

namespace Ahlin\Bundle\MailerBundle\Tests\Mock;

use Ahlin\Mailer\Mapping\TemplateMappingInterface;
use Ahlin\Mailer\Model\Interfaces\MailInterface;
use Ahlin\Mailer\Renderer\Renderer;

class RendererMock extends Renderer
{
    /**
     * @var array
     */
    public $visibleMappings = array();

    public function __construct()
    {
        $this->defaultContentType = 'text';
        $this->defaultTemplate = 'default';
        $this->title = 'Title';
        $this->homeUrl = 'https://localhost';
        $this->logoUrl = 'https://localhost/img/logo.png';
        $this->unsubscribeUrl = 'https://localhost/unsubscribe';
    }

    /**
     * {@inheritdoc}
     */
    public function addMapping(TemplateMappingInterface $mapping)
    {
        $this->visibleMappings = array_merge($this->visibleMappings, $mapping->getMappings());
    }

    /**
     * {@inheritdoc}
     */
    public function render(MailInterface $mail)
    {
        // No implementation
    }
}
