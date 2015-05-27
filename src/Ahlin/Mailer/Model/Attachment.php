<?php

namespace Ahlin\Mailer\Model;

/**
 * Class Attachment represents an attachment sent together with email message
 */
class Attachment
{
    /**
     * @var mixed
     */
    private $data;

    /**
     * @var string
     */
    private $filename;

    /**
     * @var string
     */
    private $contentType;

    /**
     * @param $data
     * @param string $filename
     * @param string $contentType
     */
    public function __construct($data, $filename, $contentType)
    {
        $this->data = $data;
        $this->filename = $filename;
        $this->contentType = $contentType;
    }

    /**
     * Get content type
     * @return string
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * Get data
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Get filename
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }
}
