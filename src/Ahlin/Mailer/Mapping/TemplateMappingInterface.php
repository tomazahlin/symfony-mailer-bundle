<?php

namespace Ahlin\Mailer\Mapping;

interface TemplateMappingInterface
{
    /**
     * Get mappings
     *
     * @return array
     *
     * Example:
     *     array('default' => array(array('view' => 'MyBundle:Mail:default.html.twig', 'contentType' => 'text/html')))
     *
     * Key view is mandatory
     * Key contentType is optional, default one is defined in the bundle
     *
     */
    public function getMappings();
}
