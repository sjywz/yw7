<?php
namespace Lzhy\Tests;

use Lzhy\Yw7\Exceptions\InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Lzhy\Yw7\Tool\Url;

class UrlTest extends TestCase
{
    public function testGMobileUrlInvlidParam()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('param do is must bu string');
        Url::gMobileUrl('');
        $this->fail('Failed to assert');
    }

    public function testGWebUrlInvlidParam()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('param do is must bu string');
        Url::gMobileUrl('');
        $this->fail('Failed to assert');
    }
}