<?php

namespace Ahlin\Mailer\Model;

use Ahlin\Mailer\Filter\FilterChainInterface;
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
    public function transform(EngineInterface $templating, FilterChainInterface $filterChain, array $templates)
    {
        $message = $this->createSwiftMessage();
        $message->setTo($this->recipient->getEmail(), $this->recipient->getFullName());

        $body = $templating->render($templates[0]['view'], $this->parameters);
        $body = $filterChain->apply($body, $message);
        $message->setBody($body, $templates[0]['contentType']);

        for ($i = 1; $i < count($templates); $i++) {
            $part = $templating->render($templates[$i]['view'], $this->parameters);
            $part = $filterChain->apply($part, $message);
            $message->addPart($part, $templates[$i]['contentType']);
        }

        return $message;
    }
}
