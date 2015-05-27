<?php

namespace Ahlin\Bundle\MailerBundle\Tests\DependencyInjection;

use Ahlin\Bundle\MailerBundle\DependencyInjection\Compiler\MailerTemplateMappingPass;
use Ahlin\Bundle\MailerBundle\Tests\Mock\RendererMock;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractContainerBuilderTestCase;

class MailerTemplateMappingPassTest extends AbstractContainerBuilderTestCase
{
    /**
     * Tests that the template mapping pass adds the template mappings
     * @group compiler
     */
    public function testPass()
    {
        $renderer = new RendererMock();
        $this->registerService('ahlin_mailer.renderer', $renderer);
        $this->registerService('ahlin_mailer.test_mapping', 'Ahlin\Mailer\Mapping\DefaultMapping')
             ->addTag('ahlin_mailer.mapping');
        $this->assertEquals(0, count($renderer->visibleMappings));

        $pass = new MailerTemplateMappingPass();
        $pass->process($this->container);

        $renderer = $this->container->get('ahlin_mailer.renderer');
        $this->assertEquals(1, count($renderer->visibleMappings));
        $this->assertArrayHasKey('default', $renderer->visibleMappings);
    }
}
