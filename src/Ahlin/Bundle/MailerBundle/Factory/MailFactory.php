<?php

namespace Ahlin\Bundle\MailerBundle\Factory;

use Ahlin\Bundle\MailerBundle\Model\Interfaces\MailUserInterface;
use Ahlin\Bundle\MailerBundle\Model\AdvancedMail;
use Ahlin\Bundle\MailerBundle\Model\SimpleMail;

/**
 * Class MailFactory is responsible of creating all new Mail instances.
 */
class MailFactory
{
    /**
     * @var integer
     */
    private $defaultTemplate;

    /**
     * Constructor
     * @param string $defaultTemplate
     */
    public function __construct($defaultTemplate)
    {
        $this->defaultTemplate = $defaultTemplate;
    }

    /**
     * Create new Simple Mail
     * @param MailUserInterface $sender
     * @param MailUserInterface $recipient
     * @param string $subject
     * @param string|null $template (if null, default template will be used)
     * @param int|null $priority (if null, default mail priority will be used)
     * @return SimpleMail
     */
    public function create(
        MailUserInterface $sender,
        MailUserInterface $recipient,
        $subject,
        $template = null,
        $priority = null
    ) {
        if ($template === null) {
            $template = $this->defaultTemplate;
        }
        return new SimpleMail($sender, $recipient, $subject, $template, $priority);
    }

    /**
     * Create new Advanced Mail
     * @param MailUserInterface $sender
     * @param $subject
     * @param string|null $template (if null, default template will be used)
     * @param int|null $priority (if null, default mail priority will be used)
     * @return AdvancedMail
     */
    public function createAdvanced(
        MailUserInterface $sender,
        $subject,
        $template = null,
        $priority = null
    ) {
        if ($template === null) {
            $template = $this->defaultTemplate;
        }
        return new AdvancedMail($sender, $subject, $template, $priority);
    }
}
