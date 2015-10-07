<?php

namespace Ahlin\Mailer\Model;

use Ahlin\Mailer\Model\Interfaces\MailUserInterface;
use Symfony\Component\Templating\EngineInterface;

/**
 * Class SimpleMail represents a mail which can be sent with a Mailer instance
 */
class SimpleMail extends AbstractMail
{
    const DEFAULT_PRIORITY = 100;

    /**
     * @var MailUserInterface
     */
    private $recipient;

    /**
     * Constructor. Accepts all mandatory data.
     * @param MailUserInterface $sender
     * @param MailUserInterface $recipient
     * @param $subject - subject of the message
     * @param string $template - type of the message
     * @param int $priority - priority of the message, when it is sent
     */
    public function __construct(
        MailUserInterface $sender,
        MailUserInterface $recipient,
        $subject,
        $template,
        $priority = self::DEFAULT_PRIORITY
    ) {
        $this->recipient = $this->getUserModel($recipient);
        $this->init($sender, $subject, $template, $priority);
    }

    /**
     * {@inheritdoc}
     */
    public function transform(EngineInterface $templating, array $templates)
    {
        $message = $this->createSwiftMessage();
        $message->setTo($this->recipient->getEmail(), $this->recipient->getFullName());

        $message->setBody($templating->render($templates[0]['view'], $this->parameters), $templates[0]['contentType']);

        for ($i = 1; $i < count($templates); $i++) {
            $message->addPart($templating->render($templates[$i]['view'], $this->parameters), $templates[$i]['contentType']);
        }

        return $message;
    }
}
