<?php
namespace Lzhy\Tests;

use Lzhy\Yw7\Exceptions\InvalidArgumentException;
use Lzhy\Yw7\Tool\Assist;
use PHPUnit\Framework\TestCase;

class AssistTest extends TestCase
{
    public function testFilterParamInvalidParam()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid type param');
        Assist::filterParam('string');
        $this->fail('Failed to assert');
    }

    public function testFilterParam()
    {
        $filterParam = Assist::filterParam(['testid'=>1,'_openid'=>'openid','const'=>'this is const'],['const']);
        $this->assertEquals(['testid'=>1], $filterParam);
    }

    public function testGlobalVal()
    {
        global $_W;
        $_W = [
            'site' => ['url'=>'test.com','name'=>'test site','conf'=>['close'=>1,'date'=>date('Y-m-d')]],
            'conf' => ['shard'=>1],
        ];
        $value = Assist::globalVal('site.url');
        $this->assertEquals('test.com',$value);
        $value = Assist::globalVal('conf');
        $this->assertEquals(['shard'=>1],$value);
        $value = Assist::globalVal('site.conf.close');
        $this->assertEquals(1,$value);
        $value = Assist::globalVal('site.icon','bj.icon');
        $this->assertEquals('bj.icon',$value);
    }

    public function testGpcVal()
    {
        global $_GPC;
        $_GPC = ['test'=>1,'name'=>'test','phone'=>'','age'=>'30'];
        $value = Assist::gpcVal('name');
        $this->assertEquals('test', $value);
        $value = Assist::gpcVal('age');
        $this->assertEquals(30, $value);
        $value = Assist::gpcVal('phone','18999880090');
        $this->assertEquals('18999880090', $value);
    }
}