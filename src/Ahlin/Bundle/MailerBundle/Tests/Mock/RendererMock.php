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

        $this->emailParameters = array(
            '_title' => 'Title',
            '_homeUrl' => 'https://localhost',
            '_logoUrl' => 'https://localhost/img/logo.png',
            '_unsubscribeUrl' => 'https://localhost/unsubscribe',
            '_infoEmail' => 'test@localhost',
        );
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
