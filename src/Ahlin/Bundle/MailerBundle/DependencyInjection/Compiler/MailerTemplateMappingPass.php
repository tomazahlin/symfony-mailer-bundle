<?php

namespace Ahlin\Bundle\MailerBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class MailerTemplateMappingPass implements CompilerPassInterface
{
    /**
     * Adds all template mappings to the renderer
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $renderer = $container->getDefinition('ahlin_mailer.renderer');

        $mappings = $container->findTaggedServiceIds(
            'ahlin_mailer.mapping'
        );

        foreach ($mappings as $mapping => $tags) {
            $renderer->addMethodCall('addMapping', array(new Reference($mapping)));
        }
    }
}
