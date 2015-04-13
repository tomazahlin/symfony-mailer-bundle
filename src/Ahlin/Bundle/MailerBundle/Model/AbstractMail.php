<?php

namespace Ahlin\Bundle\MailerBundle\Model;

use Ahlin\Bundle\MailerBundle\Model\Interfaces\MailInterface;
use Ahlin\Bundle\MailerBundle\Model\Interfaces\MailUserInterface;
use Ahlin\Bundle\MailerBundle\Model\Interfaces\SwiftTransformationInterface;
use Swift_Message;
use UnexpectedValueException;

/**
 * Class AbstractMail represents a base mail for all Mail instances
 * Mailer can accept any concrete Mail instance which extends this class.
 */
abstract class AbstractMail implements MailInterface
{
    /**
     * @var MailUserInterface
     */
    protected $sender;

    /**
     * @var string
     */
    protected $subject;

    /**
     * @var string
     */
    protected $template;

    /**
     * Higher priority means that the message will be sent earlier, if multiple messages are to be sent at once
     * @var integer
     */
    protected $priority;

    /**
     * @var array
     */
    protected $parameters = array();

    /**
     * Initialization of the base data. Parent constructors might call this method.
     * @param MailUserInterface $sender
     * @param $subject - subject of the message
     * @param string $template - type of the message
     * @param int $priority - priority of the message, when it is sent
     */
    final protected function init(
        MailUserInterface $sender,
        $subject,
        $template,
        $priority
    ) {
        $this->sender = $this->getUserModel($sender);
        $this->subject = $subject;
        $this->template = $template;
        $this->priority = $priority;
    }

    /**
     * {@inheritdoc}
     */
    public function addParameter($key, $value)
    {
        if (array_key_exists($key, $this->parameters)) {
            throw new UnexpectedValueException('Parameter with the given key already exists.');
        }
        $this->parameters[$key] = $value;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * {@inheritdoc}
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Creates new instance of Swift_Message
     * @return \Swift_Mime_SimpleMessage
     */
    protected function createSwiftMessage()
    {
        return Swift_Message::newInstance()
            ->setSubject($this->subject)
            ->setFrom($this->sender->getEmail(), $this->sender->getFullName());
    }

    /**
     * Get user model
     * MailUserInterface might have additional data which is not needed, so it should be transformed to a minimal model
     * Besides if anything inside user gets changed, the changes will not be visible in the new User object, which is desirable behavior.
     * @param MailUserInterface $user
     * @return User
     */
    protected function getUserModel(MailUserInterface $user)
    {
        return new User($user->getEmail(), $user->getFullName());
    }
}
