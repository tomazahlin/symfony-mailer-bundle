<?php

namespace spec\Ahlin\Bundle\MailerBundle\Mapping;

use Ahlin\Bundle\MailerBundle\Mapping\DefaultMapping;
use PhpSpec\ObjectBehavior;

/**
 * Class DefaultMappingSpec
 * @mixin DefaultMapping
 */
class DefaultMappingSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Ahlin\Bundle\MailerBundle\Mapping\DefaultMapping');
        $this->shouldImplement('Ahlin\Bundle\MailerBundle\Mapping\TemplateMappingInterface');
    }

    function it_returns_default_mapping()
    {
        $this->getMappings()->shouldHaveKey('default');
        $mapping = $this->getMappings()['default'];
        $mapping->shouldHaveKey('view');
        $mapping->shouldHaveKey('contentType');
    }
}
