<?php
namespace Lzhy\Yw7\Utils;

class Assist
{
    /**
     * 获取全局变量
     * @param [type] $key
     * @param string $default
     * @return void
     */
    public static function globalVal($key,$default = '')
    {
        if($key){
            global $_W;
            $keyArr = explode('.',$key);
            if($key === '.'){
                return $_W;
            }
            $_value = $_W;
            foreach ($keyArr as $v){
                $_value = $_value[$v];
            }

            if(empty($_value)){
                $_value = $default;
            }
            return $_value;
        }
    }

    /**
     * 获取全局请求变量
     * @param [type] $key
     * @param string $default
     * @return void
     */
    public static function gpcVal($key,$default = '')
    {
        if($key){
            global $_GPC;
            if($key === '.'){
                return $_GPC;
            }
            $keyArr = explode('.',$key);
            $_value = $_GPC;
            foreach ($keyArr as $v){
                $_value = $_value[$v];
            }

            if(empty($_value)){
                $_value = $default;
            }

            return $_value;
        }
    }
}