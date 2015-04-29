<?php

namespace spec\Ahlin\Bundle\MailerBundle;

use Ahlin\Bundle\MailerBundle\Factory\MailFactory;
use Ahlin\Bundle\MailerBundle\Mailer\MailerInterface;
use Ahlin\Bundle\MailerBundle\Mailer\Mailing;
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
        $this->shouldHaveType('Ahlin\Bundle\MailerBundle\Mailer\Mailing');
        $this->shouldImplement('Ahlin\Bundle\MailerBundle\Mailer\MailingInterface');
    }

    function it_returns_a_mailer()
    {
        $this->getMailer()->shouldImplement('Ahlin\Bundle\MailerBundle\Mailer\MailerInterface');
    }

    function it_returns_a_factory()
    {
        $this->getFactory()->shouldImplement('Ahlin\Bundle\MailerBundle\Factory\MailFactory');
    }
}
