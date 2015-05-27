<?php

namespace spec\Ahlin\Mailer\Factory;

use Ahlin\Mailer\Factory\MailFactory;
use Ahlin\Mailer\Model\Interfaces\MailUserInterface;
use PhpSpec\ObjectBehavior;
use spec\Ahlin\Mailer\Model\UserSpec;

/**
 * Class MailFactorySpec
 * @mixin MailFactory
 */
class MailFactorySpec extends ObjectBehavior
{
    const SUBJECT = 'Test subject';
    const TEMPLATE = 'template';
    const TEMPLATE_DEFAULT = 'default';

    function let(MailUserInterface $user)
    {
        $user->getEmail()->willReturn(UserSpec::EMAIL);
        $user->getFullName()->willReturn(UserSpec::NAME);
        $this->beConstructedWith(self::TEMPLATE_DEFAULT);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Ahlin\Mailer\Factory\MailFactory');
    }

    function it_can_create_simple_mail(MailUserInterface $user)
    {
        $mail = $this->create($user, $user, self::SUBJECT);
        $mail->shouldBeAnInstanceOf('Ahlin\Mailer\Model\SimpleMail');
    }

    function it_can_create_simple_mail_with_template_and_priority(MailUserInterface $user)
    {
        $mail = $this->create($user, $user, self::SUBJECT, self::TEMPLATE, 110);
        $mail->shouldBeAnInstanceOf('Ahlin\Mailer\Model\SimpleMail');
    }

    function it_can_create_advanced_mail(MailUserInterface $user)
    {
        $mail = $this->createAdvanced($user, $user, self::SUBJECT);
        $mail->shouldBeAnInstanceOf('Ahlin\Mailer\Model\AdvancedMail');
    }

    function it_can_create_advanced_mail_with_template_and_priority(MailUserInterface $user)
    {
        $mail = $this->createAdvanced($user, $user, self::SUBJECT, self::TEMPLATE, 120);
        $mail->shouldBeAnInstanceOf('Ahlin\Mailer\Model\AdvancedMail');
    }
}
