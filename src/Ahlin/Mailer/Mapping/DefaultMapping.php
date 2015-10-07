<?php

namespace Ahlin\Mailer\Mapping;

/**
 * Class DefaultMapping represents a default mapping used when mapping template names into template paths
 */
class DefaultMapping implements TemplateMappingInterface
{
    const TEMPLATE = 'default';
    const VIEW = 'AhlinMailerBundle:Mail:default.html.twig';
    const CONTENT_TYPE = 'text/html';

    /**
     * {@inheritdoc}
     */
    public function getMappings()
    {
        return array(self::TEMPLATE => array(array('view' => self::VIEW, 'contentType' => self::CONTENT_TYPE)));
    }
}
