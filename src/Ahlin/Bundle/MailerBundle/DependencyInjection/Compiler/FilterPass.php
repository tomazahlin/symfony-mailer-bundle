<?php

namespace Ahlin\Bundle\MailerBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class FilterPass implements CompilerPassInterface
{
    /**
     * Adds all template mappings to the renderer
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $renderer = $container->getDefinition('ahlin_mailer.filter_chain');

        $filters = $container->findTaggedServiceIds(
            'ahlin_mailer.filter'
        );

        foreach ($filters as $filter => $tags) {
            $renderer->addMethodCall('addFilter', array(new Reference($filter)));
        }
    }
}
