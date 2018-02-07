<?php

namespace Ahlin\Mailer\Model;

use Ahlin\Mailer\Filter\FilterChainInterface;
use Ahlin\Mailer\Model\Interfaces\MailUserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Templating\EngineInterface;

/**
 * Class AdvancedMail represents a more complex mail which can be sent with a Mailer instance
 */
class AdvancedMail extends AbstractMail
{
    const DEFAULT_PRIORITY = 90;

    /**
     * @var ArrayCollection|Attachment[]
     */
    private $attachments;

    /**
     * @var ArrayCollection|MailUserInterface[]
     */
    private $recipients;

    /**
     * @var ArrayCollection|MailUserInterface[]
     */
    private $bccRecipients;

    /**
     * Constructor. Accepts all mandatory data.
     * @param MailUserInterface $sender
     * @param $subject
     * @param $template
     * @param int $priority
     * @param string|null $returnPath
     */
    public function __construct(
        MailUserInterface $sender,
        $subject,
        $template,
        $priority = self::DEFAULT_PRIORITY,
        $returnPath = null
    ) {
        $this->attachments = new ArrayCollection();
        $this->recipients = new ArrayCollection();
        $this->bccRecipients = new ArrayCollection();
        $this->init($sender, $subject, $template, $priority, $returnPath);
    }

    /**
     * Add recipients
     * @param MailUserInterface[] $recipients
     * @return AdvancedMail
     */
    public function addRecipients(array $recipients)
    {
        foreach ($recipients as $recipient) {
            $this->addRecipient($recipient);
        }
        
        return $this;
    }

    /**
     * @param MailUserInterface $recipient
     * @return AdvancedMail
     */
    public function addRecipient(MailUserInterface $recipient)
    {
        $recipient = $this->getUserModel($recipient);
        $this->recipients->add($recipient);
        
        return $this;
    }

    /**
     * Get recipients
     * @return MailUserInterface[]|ArrayCollection
     */
    public function getRecipients()
    {
        return $this->recipients;
    }

    /**
     * Add blind carbon copy recipients
     * @param MailUserInterface[] $recipients
     * @return AdvancedMail
     */
    public function addBccRecipients(array $recipients)
    {
        foreach ($recipients as $recipient) {
            $this->addBccRecipient($recipient);
        }
        
        return $this;
    }

    /**
     * Add blind carbon copy recipient
     * @param MailUserInterface $recipient
     * @return AdvancedMail
     */
    public function addBccRecipient(MailUserInterface $recipient)
    {
        $recipient = $this->getUserModel($recipient);
        $this->bccRecipients->add($recipient);
        
        return $this;
    }

    /**
     * Get blind carbon copy recipients
     * @return MailUserInterface[]|ArrayCollection
     */
    public function getBccRecipients()
    {
        return $this->bccRecipients;
    }

    /**
     * Add attachment (any file, can also be image)
     * @param Attachment $attachment
     * @return AdvancedMail
     */
    public function addAttachment(Attachment $attachment)
    {
        $this->attachments->add($attachment);
        
        return $this;
    }

    /**
     * Get attachments
     * @return Attachment[]|ArrayCollection
     */
    public function getAttachments()
    {
        return $this->attachments;
    }

    /**
     * {@inheritdoc}
     */
    public function transform(EngineInterface $templating, FilterChainInterface $filterChain, array $templates)
    {
        $message = $this->createSwiftMessage();

        foreach ($this->recipients as $recipient) {
            $message->addTo($recipient->getEmail(), $recipient->getFullName());
        }

        foreach ($this->bccRecipients as $recipient) {
            $message->addBcc($recipient->getEmail(), $recipient->getFullName());
        }

        foreach($this->attachments as $attachment) {
            $message->attach(\Swift_Attachment::newInstance($attachment->getData(), $attachment->getFilename(), $attachment->getContentType()));
        }

        if ($this->hasReturnPath()) {
            $message->setReturnPath($this->getReturnPath());
        }

        $message->setContentType($templates[0]['contentType']);
        
        $body = $templating->render($templates[0]['view'], $this->parameters);
        $body = $filterChain->apply($body, $message);
        $message->setBody($body);

        for ($i = 1; $i < count($templates); $i++) {
            $body = $templating->render($templates[$i]['view'], $this->parameters);
            $body = $filterChain->apply($body, $message);
            $message->addPart($body, $templates[$i]['contentType']);
        }

        return $message;
    }
}
