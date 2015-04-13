<?php

namespace Ahlin\Bundle\MailerBundle\Tests\Controller;

use Ahlin\Bundle\MailerBundle\Mailing;
use Ahlin\Bundle\MailerBundle\Model\Attachment;
use Ahlin\Bundle\MailerBundle\Model\User;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ExampleController shows some examples how to use the mailing service. Of course, you should inject and use the
 * mailing in your other services prior to controller.
 */
class ExampleController
{
    /**
     * @var Mailing
     */
    private $mailing;

    /**
     * @param Mailing $mailing
     */
    public function __construct(Mailing $mailing)
    {
        $this->mailing = $mailing;
    }

    /**
     * A simple example
     *
     * @return Response
     */
    public function simpleAction()
    {
        // Creates the test users
        // However you are encouraged to user your own User entity class, you only need to implement MailUserInterface
        $sender     = new User('sender@test.com',    'Test sender user');
        $recipient  = new User('recipient@test.com', 'Test recipient user');

        // Creates the mail, note that the message itself is defined in template
        $mail = $this->mailing->getFactory()
            ->create($sender, $recipient, 'Test subject');

        // Send email (Swiftmailer can also add it to spool, if you configure it like that)
        $this->mailing->getMailer()->send($mail);

        // Simple response
        return new Response('Mail sent successfully!', 200);
    }

    /**
     * An advanced example
     *
     * @return Response
     */
    public function advancedAction()
    {
        // Creates the test users
        $sender     = new User('sender@test.com',    'Test sender user');
        $recipient  = new User('recipient@test.com', 'Test recipient user');

        // Blind carbon copy recipients
        $bcc  = array(
            new User('bcc1@test.com', 'Bcc1 user'),
            new User('bcc2@test.com', 'Bcc2 user')
        );

        // Create an attachment (You can attach images, files...)
        $attachment = new Attachment('test', 'test.txt', 'text');

        // Some test object, whose values we want to display in the template
        $test = new \stdClass();

        // Creates the mail, note that the message itself is defined in template
        $mail = $this->mailing->getFactory()
            ->createAdvanced($sender, 'Test subject')
            ->addAttachment($attachment)
            ->addParameter('test', $test)
            ->addRecipient($recipient)
            ->addBccRecipients($bcc);

        // Send email (Swiftmailer can also add it to spool, if you configure it like that)
        $this->mailing->getMailer()->send($mail);

        // Simple response
        return new Response('Mail(s) sent successfully!', 200);
    }

    /**
     * An example how to use deferred mail sending which is executed in kernel.terminate
     *
     * @return Response
     */
    public function deferredAction()
    {
        // Creates the test users
        $sender     = new User('sender@test.com',    'Test sender user');
        $recipient  = new User('recipient@test.com', 'Test recipient user');

        // Creates the mail, note that the message itself is defined in template
        $mail = $this->mailing->getFactory()
            ->create($sender, $recipient, 'Test subject');

        // Add message to the queue email
        $this->mailing->getMailer()->enqueue($mail);

        // Simple response
        return new Response('Mail will be sent shortly...', 200);
    }
}
