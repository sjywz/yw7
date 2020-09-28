<?php
namespace Lzhy\Yw7;

use Lzhy\Yw7\Traits\Template;
use Lzhy\Yw7\Utils\Assist;

class Controller
{
    use Template;

    protected $uniacid;
    protected $uid;
    protected $controller;
    protected $action;

    function __construct()
    {
        $this->uniacid = Assist::globalVal('uniacid');
        $this->uid = Assist::globalVal('uid');
        $this->controller = Assist::globalVal('yw7.do');
        $this->action = Assist::globalVal('yw7.op');
    }
}