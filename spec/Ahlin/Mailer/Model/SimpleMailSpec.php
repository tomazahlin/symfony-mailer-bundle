<?php

namespace spec\Ahlin\Mailer\Model;

use Ahlin\Mailer\Filter\FilterChainInterface;
use Ahlin\Mailer\Model\Interfaces\MailUserInterface;
use Ahlin\Mailer\Model\SimpleMail;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Templating\EngineInterface;

/**
 * Class SimpleMailSpec
 * @mixin SimpleMail
 */
class SimpleMailSpec extends ObjectBehavior
{
    const SENDER_EMAIL = 'sender@test.com';
    const SENDER_NAME  = 'Sender';
    const RECIPIENT_EMAIL = 'recipient@test.com';
    const RECIPIENT_NAME  = 'Recipient';

    const SUBJECT  = 'Subject';
    const TEMPLATE  = 'test';
    const PRIORITY  = 100;

    function let(
        MailUserInterface $sender,
        MailUserInterface $recipient
    ) {
        $sender->getEmail()->willReturn(self::SENDER_EMAIL);
        $sender->getFullName()->willReturn(self::SENDER_NAME);

        $recipient->getEmail()->willReturn(self::RECIPIENT_EMAIL);
        $recipient->getFullName()->willReturn(self::RECIPIENT_NAME);

        $this->beConstructedWith($sender, $recipient, self::SUBJECT, self::TEMPLATE, self::PRIORITY);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Ahlin\Mailer\Model\SimpleMail');
        $this->shouldHaveType('Ahlin\Mailer\Model\AbstractMail');
        $this->shouldImplement('Ahlin\Mailer\Model\Interfaces\MailInterface');
    }

    function it_returns_valid_template()
    {
        $this->getTemplate()->shouldBe(self::TEMPLATE);
    }

    function it_returns_valid_priority()
    {
        $this->getPriority()->shouldBe(self::PRIORITY);
    }

    function it_can_be_transformed(EngineInterface $templating, FilterChainInterface $filterChain)
    {
        $html = '<html><head></head><body>Test</body></html>';
        $templating->render(Argument::type('string'), Argument::type('array'))->willReturn($html);

        $message = $this->transform($templating, $filterChain, array(array('view' => 'default', 'contentType' => 'text/html')));

        $message->shouldHaveType('\Swift_Message');
        $message->getSubject()->shouldBeLike(self::SUBJECT);
        $message->getBody()->shouldBeLike($html);
        $message->getFrom()->shouldBeLike(array(self::SENDER_EMAIL => self::SENDER_NAME));
        $message->getTo()->shouldBeLike(array(self::RECIPIENT_EMAIL => self::RECIPIENT_NAME));
    }
}
