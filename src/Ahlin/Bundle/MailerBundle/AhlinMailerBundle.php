<?php

namespace Ahlin\Bundle\MailerBundle;

use Ahlin\Bundle\MailerBundle\DependencyInjection\Compiler\FilterPass;
use Ahlin\Bundle\MailerBundle\DependencyInjection\Compiler\MailerTemplateMappingPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AhlinMailerBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container
            ->addCompilerPass(new MailerTemplateMappingPass())
            ->addCompilerPass(new FilterPass());
    }
}
