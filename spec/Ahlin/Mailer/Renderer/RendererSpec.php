<?php

namespace spec\Ahlin\Mailer\Renderer;

use Ahlin\Mailer\Filter\FilterChainInterface;
use Ahlin\Mailer\Mapping\DefaultMapping;
use Ahlin\Mailer\Mapping\TemplateMappingInterface;
use Ahlin\Mailer\Model\Interfaces\MailInterface;
use Ahlin\Mailer\Renderer\Renderer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Templating\EngineInterface;

/**
 * Class RendererSpec
 * @mixin Renderer
 */
class RendererSpec extends ObjectBehavior
{
    function let(EngineInterface $templating, FilterChainInterface $filterChain)
    {
        $this->beConstructedWith(
            $templating,
            $filterChain,
            'text/html',
            'default',
            array(
                '_title' => 'Title',
                '_homeUrl' => 'https://localhost',
                '_logoUrl' => 'https://localhost/img/logo.png',
                '_unsubscribeUrl' => 'https://localhost/unsubscribe',
                '_infoEmail' => 'test@localhost',
            )
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Ahlin\Mailer\Renderer\Renderer');
        $this->shouldImplement('Ahlin\Mailer\Renderer\RendererInterface');
    }

    function it_can_have_mappings()
    {
        $this->addMapping(new DefaultMapping());
    }

    function it_uses_the_given_template_when_found(MailInterface $mail, TemplateMappingInterface $testMapping, FilterChainInterface $filterChain)
    {
        $template = 'test';
        $view = 'TestBundle:Mail:test.html.twig';
        $contentType = 'text';
        $testMapping->getMappings()->willReturn(array($template => array(array('view' => $view, 'contentType' => $contentType))));

        $this->addMapping(new DefaultMapping());
        $this->addMapping($testMapping);

        $mail->addParameter(Argument::any(), Argument::any())->willReturn(null);
        $mail->getTemplate()->willReturn('test');
        $mail->transform(
            Argument::type('Symfony\Component\Templating\EngineInterface'),
            $filterChain,
            array(array('view' => $view, 'contentType' => $contentType)))->willReturn(new \Swift_Message());

        $message = $this->render($mail);
        $message->shouldHaveType('\Swift_Message');
    }

    function it_falls_back_to_defaults_during_rendering_when_necessary(MailInterface $mail, FilterChainInterface $filterChain)
    {
        $this->addMapping(new DefaultMapping());

        $mail->addParameter(Argument::any(), Argument::any())->willReturn(null);
        $mail->getTemplate()->willReturn('test');
        $mail->transform(
            Argument::type('Symfony\Component\Templating\EngineInterface'),
            $filterChain,
            array(array('view' => DefaultMapping::VIEW, 'contentType' => DefaultMapping::CONTENT_TYPE)))->willReturn(new \Swift_Message());

        $message = $this->render($mail);
        $message->shouldHaveType('\Swift_Message');
    }

    function it_throws_exception_during_rendering_when_no_default_template_found(MailInterface $mail)
    {
        $mail->getTemplate()->willReturn('test');
        $this->shouldThrow('Ahlin\Mailer\Exception\MailerException')
             ->duringRender($mail);
    }
}
