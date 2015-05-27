<?php

namespace spec\Ahlin\Mailer;

use Ahlin\Mailer\Mailer;
use Ahlin\Mailer\Model\AbstractMail;
use Ahlin\Mailer\Model\Interfaces\MailInterface;
use Ahlin\Mailer\Renderer\RendererInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Swift_Mailer;
use Swift_Mime_Message;

/**
 * Class MailerSpec
 * @mixin Mailer
 */
class MailerSpec extends ObjectBehavior
{
    function let(Swift_Mailer $swiftMailer,
                 RendererInterface $renderer,
                 MailInterface $mail,
                 Swift_Mime_Message $message
    ) {
        $renderer->render($mail)->willReturn($message);
        $this->beConstructedWith($swiftMailer, $renderer);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Ahlin\Mailer\Mailer');
        $this->shouldImplement('Ahlin\Mailer\QueueableMailerInterface');
    }

    function it_can_have_queued_mails(AbstractMail $mail)
    {
        $this->enqueue($mail);
    }

    function it_can_send_mail_directly(AbstractMail $mail, Swift_Mailer $swiftMailer)
    {
        $this->send($mail);
        $swiftMailer->send(Argument::any())->shouldHaveBeenCalled();
    }

    function it_can_send_first_mail_from_queue(AbstractMail $mail, Swift_Mailer $swiftMailer)
    {
        $this->enqueue($mail);
        $this->sendFirstFromQueue();
        $swiftMailer->send(Argument::any())->shouldHaveBeenCalled();
    }

    function it_can_send_all_emails_from_queue(AbstractMail $mail, Swift_Mailer $swiftMailer)
    {
        $this->enqueue($mail);
        $this->enqueue($mail);
        $this->enqueue($mail);
        $this->sendAllFromQueue();
        $swiftMailer->send(Argument::any())->shouldHaveBeenCalled(3);
    }

    function it_throws_exception_when_sending_from_empty_queue()
    {
        $this->shouldThrow('Ahlin\Mailer\Exception\MailerException')
            ->duringSendFirstFromQueue();
    }
}
