<?php

namespace Ahlin\Bundle\MailerBundle\Tests\DependencyInjection;

use Ahlin\Bundle\MailerBundle\DependencyInjection\AhlinMailerExtension;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;

class AhlinMailerExtensionTest extends AbstractExtensionTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function getContainerExtensions()
    {
        return array(
            new AhlinMailerExtension()
        );
    }

    /**
     * Tests that the bundle extension has provided container with the desired parameters
     * @group extension
     */
    public function testParameters()
    {
        $this->load();
        // $this->assertContainerBuilderHasParameter('ahlin_mailer.parameter'); ...
    }

    /**
     * Tests that the bundle extension has provided container with the desired services
     * @group extension
     */
    public function testServices()
    {
        $this->load();

        $this->assertContainerBuilderHasService('ahlin_mailer.templating');

        $this->assertContainerBuilderHasAlias('ahlin_mailer.templating', 'templating.engine.twig');
    }
}
