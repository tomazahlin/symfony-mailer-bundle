<?php

namespace spec\Ahlin\Mailer;

use Ahlin\Mailer\Factory\MailFactory;
use Ahlin\Mailer\MailerInterface;
use Ahlin\Mailer\Mailing;
use PhpSpec\ObjectBehavior;

/**
 * Class MailingSpec
 * @mixin Mailing
 */
class MailingSpec extends ObjectBehavior
{
    function let(MailerInterface $mailer, MailFactory $factory)
    {
        $this->beConstructedWith($mailer, $factory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Ahlin\Mailer\Mailing');
        $this->shouldImplement('Ahlin\Mailer\MailingInterface');
    }

    function it_returns_a_mailer()
    {
        $this->getMailer()->shouldImplement('Ahlin\Mailer\MailerInterface');
    }

    function it_returns_a_factory()
    {
        $this->getFactory()->shouldImplement('Ahlin\Mailer\Factory\MailFactory');
    }
}
