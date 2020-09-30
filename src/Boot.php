<?php
namespace Lzhy\Yw7;

use Lzhy\Yw7\Tool\Assist;
use Lzhy\Yw7\Core\Launch;
use Lzhy\Yw7\Core\Set;

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
        $config = array_merge(Set::defaultBootConf(),$this->config);

        $_action = Assist::globalVal('yw7.action_name','op');
        $module = Launch::parseRequestModule($this->name);
        $do = Assist::gpcVal('do','index');
        $op = Assist::gpcVal($_action,'index');
        $config['module'] = $module;
        $config['do'] = $do;
        $config['op'] = $op;

        Set::setBootGlobalVal($config);
        Launch::on($config,$this->arguments);
    }
}