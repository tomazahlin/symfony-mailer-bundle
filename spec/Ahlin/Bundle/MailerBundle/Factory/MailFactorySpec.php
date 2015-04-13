<?php

namespace spec\Ahlin\Bundle\MailerBundle\Factory;

use Ahlin\Bundle\MailerBundle\Factory\MailFactory;
use Ahlin\Bundle\MailerBundle\Model\Interfaces\MailUserInterface;
use PhpSpec\ObjectBehavior;
use spec\Ahlin\Bundle\MailerBundle\Model\UserSpec;

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
        $this->shouldHaveType('Ahlin\Bundle\MailerBundle\Factory\MailFactory');
    }

    function it_can_create_simple_mail(MailUserInterface $user)
    {
        $mail = $this->create($user, $user, self::SUBJECT);
        $mail->shouldBeAnInstanceOf('Ahlin\Bundle\MailerBundle\Model\SimpleMail');
    }

    function it_can_create_simple_mail_with_template_and_priority(MailUserInterface $user)
    {
        $mail = $this->create($user, $user, self::SUBJECT, self::TEMPLATE, 110);
        $mail->shouldBeAnInstanceOf('Ahlin\Bundle\MailerBundle\Model\SimpleMail');
    }

    function it_can_create_advanced_mail(MailUserInterface $user)
    {
        $mail = $this->createAdvanced($user, $user, self::SUBJECT);
        $mail->shouldBeAnInstanceOf('Ahlin\Bundle\MailerBundle\Model\AdvancedMail');
    }

    function it_can_create_advanced_mail_with_template_and_priority(MailUserInterface $user)
    {
        $mail = $this->createAdvanced($user, $user, self::SUBJECT, self::TEMPLATE, 120);
        $mail->shouldBeAnInstanceOf('Ahlin\Bundle\MailerBundle\Model\AdvancedMail');
    }
}
