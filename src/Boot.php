<?php
namespace Lzhy\Yw7;

use Lzhy\Yw7\Utils\Assist;
use Lzhy\Yw7\Utils\Launch;
use Lzhy\Yw7\Utils\Set;

require __DIR__.'/autoload.php';

class Boot
{
    protected $name = '';
    protected $arguments = [];
    protected $config = [];

    function __construct($name,$arguments)
    {
        $this->name = $name;
        $this->arguments = $arguments;
    }

    public function setConfig($config = [])
    {
        if($config && is_array($config)){
            $this->config = $config;
        }
        return $this;
    }

    public function start()
    {
        $this->config = array_merge(Set::defaultBootConf(),$this->config);
        $module = Launch::parseRequestModule($this->name);
        $_action = Assist::globalVal('yw7.action_name','op');
        $do = Assist::gpcVal('do','index');
        $op = Assist::gpcVal($_action,'index');
        $this->config['module'] = $module;
        $this->config['do'] = $do;
        $this->config['op'] = $op;

        Set::setBootGlobalVal($this->config);
        Launch::on($this->config,$this->arguments);
    }
}