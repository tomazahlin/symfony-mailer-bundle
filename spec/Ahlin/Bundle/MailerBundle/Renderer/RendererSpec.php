<?php

namespace spec\Ahlin\Bundle\MailerBundle\Renderer;

use Ahlin\Bundle\MailerBundle\Mapping\DefaultMapping;
use Ahlin\Bundle\MailerBundle\Mapping\TemplateMappingInterface;
use Ahlin\Bundle\MailerBundle\Model\Interfaces\MailInterface;
use Ahlin\Bundle\MailerBundle\Renderer\Renderer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Templating\EngineInterface;

/**
 * Class RendererSpec
 * @mixin Renderer
 */
class RendererSpec extends ObjectBehavior
{
    function let(EngineInterface $templating)
    {
        $this->beConstructedWith($templating, 'text/html', 'default', 'Title', 'https://localhost', 'https://localhost/img/test.png', 'https://localhost/unsubscribe');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Ahlin\Bundle\MailerBundle\Renderer\Renderer');
        $this->shouldImplement('Ahlin\Bundle\MailerBundle\Renderer\RendererInterface');
    }

    function it_can_have_mappings()
    {
        $this->addMapping(new DefaultMapping());
    }

    function it_uses_the_given_template_when_found(MailInterface $mail, TemplateMappingInterface $testMapping)
    {
        $template = 'test';
        $view = 'TestBundle:Mail:test.html.twig';
        $contentType = 'text';
        $testMapping->getMappings()->willReturn(array($template => array('view' => $view, 'contentType' => $contentType)));

        $this->addMapping(new DefaultMapping());
        $this->addMapping($testMapping);

        $mail->addParameter(Argument::any(), Argument::any())->willReturn(null);
        $mail->getTemplate()->willReturn('test');
        $mail->transform(
            Argument::type('Symfony\Component\Templating\EngineInterface'),
            $view,
            $contentType
        )->willReturn(new \Swift_Message());

        $message = $this->render($mail);
        $message->shouldHaveType('\Swift_Message');
    }

    function it_falls_back_to_defaults_during_rendering_when_necessary(MailInterface $mail)
    {
        $this->addMapping(new DefaultMapping());

        $mail->addParameter(Argument::any(), Argument::any())->willReturn(null);
        $mail->getTemplate()->willReturn('test');
        $mail->transform(
            Argument::type('Symfony\Component\Templating\EngineInterface'),
            DefaultMapping::VIEW,
            DefaultMapping::CONTENT_TYPE
        )->willReturn(new \Swift_Message());

        $message = $this->render($mail);
        $message->shouldHaveType('\Swift_Message');
    }

    function it_throws_exception_during_rendering_when_no_default_template_found(MailInterface $mail)
    {
        $mail->getTemplate()->willReturn('test');
        $this->shouldThrow('Ahlin\Bundle\MailerBundle\Exception\MailerException')
             ->duringRender($mail);
    }
}
