<?php

namespace Ahlin\Mailer;

use Ahlin\Mailer\Exception\MailerException;
use Ahlin\Mailer\Model\AbstractMail;
use Ahlin\Mailer\Renderer\RendererInterface;
use Exception;
use SplPriorityQueue;
use Swift_Mailer;

/**
 * Class Mailer is actually a mail broker, which sends (forwards) mail messages to Swiftmailer
 */
class Mailer implements QueueableMailerInterface
{
    /**
     * @var Swift_Mailer
     */
    private $swiftMailer;

    /**
     * @var RendererInterface
     */
    private $renderer;

    /**
     * @var SplPriorityQueue
     */
    private $queue;

    /**
     * Constructor.
     * @param Swift_Mailer $swiftMailer
     * @param RendererInterface $renderer
     */
    public function __construct(Swift_Mailer $swiftMailer, RendererInterface $renderer)
    {
        $this->swiftMailer = $swiftMailer;
        $this->renderer = $renderer;
        $this->queue = new SplPriorityQueue();
        $this->queue->setExtractFlags(SplPriorityQueue::EXTR_DATA);
    }

    /**
     * {@inheritdoc}
     */
    public function enqueue(AbstractMail $mail)
    {
        $message = $this->renderer->render($mail);
        $this->queue->insert($message, $mail->getPriority());
    }

    /**
     * {@inheritdoc}
     */
    public function send(AbstractMail $mail)
    {
        try{
            $message = $this->renderer->render($mail);
            $this->swiftMailer->send($message);
        } catch(Exception $e) {
            throw new MailerException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function sendSwiftMessage(\Swift_Mime_Message $message)
    {
        try{
            $this->swiftMailer->send($message);
        } catch(Exception $e) {
            throw new MailerException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function sendFirstFromQueue()
    {
        if ($this->queue->isEmpty()) {
            throw new MailerException('Mailer queue is empty.');
        }
        $message = $this->queue->extract();
        $this->swiftMailer->send($message);
    }

    /**
     * {@inheritdoc}
     */
    public function sendAllFromQueue()
    {
        while (!$this->queue->isEmpty()) {
            $this->sendFirstFromQueue();
        }
    }
}
