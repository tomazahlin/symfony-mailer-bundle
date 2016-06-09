<?php

namespace Ahlin\Mailer\Renderer;

use Ahlin\Mailer\Exception\MailerException;
use Ahlin\Mailer\Filter\FilterChainInterface;
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
     * @var FilterChainInterface
     */
    private $filterChain;

    /**
     * @var string
     */
    protected $defaultContentType;

    /**
     * @var string
     */
    protected $defaultTemplate;

    /**
     * @var array
     */
    protected $emailParameters;

    /**
     * @var array
     */
    private $mappings = array();

    /**
     * Constructor.
     * 
     * @param EngineInterface $templating
     * @param FilterChainInterface $filterChain
     * @param $defaultContentType
     * @param $defaultTemplate
     * @param array $emailParameters
     */
    public function __construct(
        EngineInterface $templating,
        FilterChainInterface $filterChain,
        $defaultContentType,
        $defaultTemplate,
        array $emailParameters
    ) {
        $this->templating = $templating;
        $this->filterChain = $filterChain;
        $this->defaultContentType = $defaultContentType;
        $this->defaultTemplate = $defaultTemplate;
        $this->emailParameters = $emailParameters;
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
        $templates = $this->getViewData($mail->getTemplate());

        // Set default content type for each template, if not present
        foreach ($templates as &$template) {
            if (!isset($template['contentType'])) {
                $template['contentType'] = $this->defaultContentType;
            }
        }

        // Adds default email parameters to the view
        foreach($this->emailParameters as $name => $value) {
            $mail->addParameter($name, $value);
        }

        return $mail->transform(
            $this->templating,
            $this->filterChain,
            $templates
        );
    }

    /**
     * Get view path and content type
     *
     * @param $template
     * @return array
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
