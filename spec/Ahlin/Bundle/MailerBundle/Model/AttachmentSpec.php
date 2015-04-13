<?php

namespace spec\Ahlin\Bundle\MailerBundle\Model;

use Ahlin\Bundle\MailerBundle\Model\Attachment;
use PhpSpec\ObjectBehavior;

/**
 * Class AttachmentSpec
 * @mixin Attachment
 */
class AttachmentSpec extends ObjectBehavior
{
    const DATA = 'data';
    const FILENAME = 'test.txt';
    const CONTENT_TYPE = 'text';

    function let()
    {
        $this->beConstructedWith(self::DATA, self::FILENAME, self::CONTENT_TYPE);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Ahlin\Bundle\MailerBundle\Model\Attachment');
    }

    function it_stores_data()
    {
        $this->getData()->shouldBeLike(self::DATA);
    }

    function it_has_filetype()
    {
        $this->getFilename()->shouldBeLike(self::FILENAME);
    }

    function it_has_content_type()
    {
        $this->getContentType()->shouldBeLike(self::CONTENT_TYPE);
    }
}
