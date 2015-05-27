<?php

namespace spec\Ahlin\Mailer\Exception;

use Ahlin\Mailer\Mapping\DefaultMapping;
use PhpSpec\ObjectBehavior;

/**
 * Class DefaultMappingSpec
 * @mixin DefaultMapping
 */
class DefaultMappingSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Ahlin\Mailer\Mapping\DefaultMapping');
        $this->shouldImplement('Ahlin\Mailer\Mapping\TemplateMappingInterface');
    }

    function it_returns_default_mapping()
    {
        $this->getMappings()->shouldHaveKey('default');
        $mapping = $this->getMappings()['default'];
        $mapping->shouldHaveKey('view');
        $mapping->shouldHaveKey('contentType');
    }
}
