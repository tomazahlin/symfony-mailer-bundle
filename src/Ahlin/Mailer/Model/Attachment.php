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
     * @var bool
     */
    private $isFilePath;

    /**
     * @param $data (data, or path to the file, but use $isFilePath parameter as true)
     * @param string $filename (if path to the file is provided, it's filename is used, and this is ignored)
     * @param string $contentType
     * @param bool $isFilePath
     */
    public function __construct($data, $filename, $contentType, $isFilePath = false)
    {
        $this->data = $data;
        $this->filename = $filename;
        $this->contentType = $contentType;
        $this->isFilePath = $isFilePath;
    }

    /**
     * Is set as file path
     *
     * @return bool
     */
    public function isFilePath()
    {
        return $this->isFilePath;
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
