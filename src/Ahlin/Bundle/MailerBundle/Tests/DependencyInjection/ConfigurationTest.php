<?php

namespace Ahlin\Bundle\CoreBundle\Tests\DependencyInjection;

use Ahlin\Bundle\MailerBundle\DependencyInjection\Configuration;
use Matthias\SymfonyConfigTest\PhpUnit\AbstractConfigurationTestCase;

class ConfigurationTest extends AbstractConfigurationTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function getConfiguration()
    {
        return new Configuration();
    }

    /**
     * Tests that the bundle configuration is loaded properly without any provided configuration values
     * @group config
     */
    public function testWithoutAnyProvidedValues()
    {
        $this->assertConfigurationIsValid(
            array(
                array()
            )
        );
    }
}
