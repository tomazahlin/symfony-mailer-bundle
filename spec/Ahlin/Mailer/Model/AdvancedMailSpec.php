<?php

namespace spec\Ahlin\Mailer\Model;

use Ahlin\Mailer\Filter\FilterChainInterface;
use Ahlin\Mailer\Model\Attachment;
use Ahlin\Mailer\Model\Interfaces\MailUserInterface;
use Ahlin\Mailer\Model\AdvancedMail;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Templating\EngineInterface;

/**
 * Class AdvancedMailSpec
 * @mixin AdvancedMail
 */
class AdvancedMailSpec extends ObjectBehavior
{
    const SENDER_EMAIL = 'sender@test.com';
    const SENDER_NAME  = 'Sender';

    const SUBJECT  = 'Subject';
    const TEMPLATE  = 'test';
    const PRIORITY  = 90;

    function let(MailUserInterface $sender)
    {
        $sender->getEmail()->willReturn(self::SENDER_EMAIL);
        $sender->getFullName()->willReturn(self::SENDER_NAME);

        $this->beConstructedWith($sender, self::SUBJECT, self::TEMPLATE, self::PRIORITY);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Ahlin\Mailer\Model\AdvancedMail');
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

    function it_can_have_multiple_attachments()
    {
        $this->addAttachment(new Attachment('data', 'test.txt',  'text'));
        $this->addAttachment(new Attachment('data', 'test2.txt', 'text'));
        $this->getAttachments()->count()->shouldBe(2);
    }

    function it_can_have_multiple_recipients(MailUserInterface $recipient)
    {
        $this->addRecipient($recipient);
        $this->addRecipient($recipient);
        $this->getRecipients()->count()->shouldBe(2);
    }

    function it_can_have_multiple_recipients_added_as_array(MailUserInterface $recipient)
    {
        $recipients = [$recipient, $recipient, $recipient];
        $this->addRecipients($recipients);
        $this->getRecipients()->count()->shouldBe(3);
    }

    function it_can_have_multiple_bcc_recipients(MailUserInterface $recipient)
    {
        $this->addBccRecipient($recipient);
        $this->addBccRecipient($recipient);
        $this->getBccRecipients()->count()->shouldBe(2);
    }

    function it_can_have_multiple_bcc_recipients_added_as_array(MailUserInterface $recipient)
    {
        $bccRecipients = [$recipient, $recipient, $recipient];
        $this->addBccRecipients($bccRecipients);
        $this->getBccRecipients()->count()->shouldBe(3);
    }

    function it_can_be_transformed(EngineInterface $templating, FilterChainInterface $filterChain, MailUserInterface $recipient1, MailUserInterface $recipient2, Attachment $attachment)
    {
        $html = '<html><head></head><body>Test</body></html>';
        $templating->render(Argument::type('string'), Argument::type('array'))->willReturn($html);
        $filterChain->apply(Argument::type('string'), Argument::any())->willReturn($html);

        $recipient1->getFullName()->willReturn('Test recipient 1');
        $recipient1->getEmail()->willReturn('recipient1@test.com');

        $recipient2->getFullName()->willReturn('Test recipient 2');
        $recipient2->getEmail()->willReturn('recipient2@test.com');

        $attachmentFileName = 'test.txt';
        $attachment->getData()->willReturn('test');
        $attachment->getFilename()->willReturn($attachmentFileName);
        $attachment->getContentType()->willReturn('text');
        $attachment->isFilePath()->willReturn(false);

        $this->addRecipients([$recipient1, $recipient2]);
        $this->addBccRecipients([$recipient1, $recipient2]);
        $this->addAttachment($attachment);

        $message = $this->transform($templating, $filterChain, array(array('view' => 'default', 'contentType' => 'text/html')));

        $message->shouldHaveType('\Swift_Message');
        $message->getSubject()->shouldBeLike(self::SUBJECT);
        $message->getBody()->shouldBeLike($html);
        $message->getFrom()->shouldBeLike(array(self::SENDER_EMAIL => self::SENDER_NAME));

        $message->getTo()->shouldHaveCount(2);
        $message->getBcc()->shouldHaveCount(2);

        $message->getChildren()->shouldHaveCount(1); // 1 attachment
        $attachment = $message->getChildren()[0];
        $attachment->shouldHaveType('Swift_Mime_Attachment');
        $attachment->getFileName()->shouldBeLike($attachmentFileName);
    }
}
