<?php

namespace Ahlin\Mailer\Renderer;

use Ahlin\Mailer\Exception\MailerException;
use Ahlin\Mailer\Mapping\TemplateMappingInterface;
use Ahlin\Mailer\Model\Interfaces\MailInterface;
use Symfony\Component\Templating\EngineInterface;

/**
 * Class Renderer renders the SwiftTransformationInterface mail instances and returns a Swift Message Instance
 */
class Renderer implements RendererInterface
{
    /**
     * @var EngineInterface
     */
    private $templating;

    /**
     * @var string
     */
    protected $defaultContentType;

    /**
     * @var string
     */
    protected $defaultTemplate;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $homeUrl;

    /**
     * @var string
     */
    protected $logoUrl;

    /**
     * @var string
     */
    protected $unsubscribeUrl;

    /**
     * @var string
     */
    protected $infoEmail;

    /**
     * @var array
     */
    private $mappings = array();

    /**
     * Constructor
     * @param EngineInterface $templating
     * @param $defaultContentType
     * @param $defaultTemplate
     * @param $title
     * @param $homeUrl
     * @param $logoUrl
     * @param $unsubscribeUrl
     * @param $infoEmail
     */
    public function __construct(
        EngineInterface $templating,
        $defaultContentType,
        $defaultTemplate,
        $title,
        $homeUrl,
        $logoUrl,
        $unsubscribeUrl,
        $infoEmail
    ) {
        $this->templating = $templating;
        $this->defaultContentType = $defaultContentType;
        $this->defaultTemplate = $defaultTemplate;
        $this->title = $title;
        $this->homeUrl = $homeUrl;
        $this->logoUrl = $logoUrl;
        $this->unsubscribeUrl = $unsubscribeUrl;
        $this->infoEmail = $infoEmail;
    }

    /**
     * {@inheritdoc}
     */
    public function addMapping(TemplateMappingInterface $mapping)
    {
        $this->mappings = array_merge($this->mappings, $mapping->getMappings());
    }

    /**
     * {@inheritdoc}
     *
     * If no template is found, it falls back to default template
     */
    public function render(MailInterface $mail)
    {
        $data = $this->getViewData($mail->getTemplate());

        isset($data['contentType']) ? $contentType = $data['contentType'] : $contentType = $this->defaultContentType;

        // Adds default parameters to the view
        $mail->addParameter('_title', $this->title);
        $mail->addParameter('_homeUrl', $this->homeUrl);
        $mail->addParameter('_logoUrl', $this->logoUrl);
        $mail->addParameter('_unsubscribeUrl', $this->unsubscribeUrl);
        $mail->addParameter('_infoEmail', $this->infoEmail);

        return $mail->transform(
            $this->templating,
            $data['view'],
            $contentType
        );
    }

    /**
     * Get view path and content type
     * @param $template
     * @return string
     * @throws MailerException
     */
    private function getViewData($template)
    {
        foreach ($this->mappings as $mappingTemplate => $mappingTemplateData) {
            if ($template === $mappingTemplate) {
                return $mappingTemplateData;
            }
        }

        if (!isset($this->mappings[$this->defaultTemplate])) {
            throw new MailerException('No default template found for mail message rendering.');
        }

        return $this->mappings[$this->defaultTemplate];
    }
}
