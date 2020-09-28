<?php
namespace Lzhy\Yw7\Utils;

class Launch
{
    /**
     * 解析请求模块
     * @param [type] $name
     * @return string
     */
    public static function parseRequestModule($name)
    {
        $name = strtolower($name);
        if(strpos($name,'doweb') === 0){
            return 'admin';
        }elseif(strpos($name,'domobile') === 0){
            return 'mobile';
        }elseif(strpos($name,'dopage')){
            return 'web';
        }
    }

    /**
     * 载入处理
     * @param [type] $config
     * @param [type] $arguments
     * @return void
     */
    public static function on($config,$arguments)
    {
        $op = $config['op'];
        $class = '\\'.$config['module'].'\\controller\\'.$config['do'];

        if(class_exists($class)){
            $classObj = new $class();
            if(method_exists($classObj,$op)){
                $classObj->$op($arguments);
            }else{
                throw new \Exception("控制器${class}方法${op}不存在");
            }
        }else{
            throw new \Exception("控制器${class}不存在");
        }
    }
}