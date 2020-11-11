<?php
namespace Lzhy\Yw7\Tool;

use Lzhy\Yw7\Exceptions\InvalidArgumentException;

class Assist
{
    /**
     * 获取全局变量
     * @param [type] $key
     * @param string $default
     * @return void
     */
    public static function globalVal($key,$default = null)
    {

        if($key){
            global $_W;
            if($key === '.'){
                return $_W;
            }
            $value = self::_loopValue($key,$_W);
            if(empty($value)){
                $value = $default;
            }
            return $value;
        }
    }

    /**
     * 获取全局请求变量
     * @param [type] $key
     * @param string $default
     * @return void
     */
    public static function gpcVal($key,$default = null)
    {
        if($key){
            global $_GPC;
            if($key === '.'){
                return $_GPC;
            }
            $value = self::_loopValue($key,$_GPC);
            if(empty($value)){
                $value = $default;
            }
            return $value;
        }
    }

    /**
     * 循环取值
     * @param [type] $key
     * @param [type] $data
     * @return void
     */
    private static function _loopValue($key,$data)
    {
        $_value = $data;
        $keyArr = explode('.',$key);
        foreach ($keyArr as $v){
            $_value = isset($_value[$v])?$_value[$v]:'';
        }
        return $_value?$_value:'';
    }

    /**
     * 过滤参数
     * @param [type] $param
     * @param array $filteKeys
     * @return void
     */
    public static function filterParam($param,$filteKeys = [])
    {
        if(!is_array($param)){
            throw new InvalidArgumentException('Invalid type param');
        }
        if($filteKeys && !is_array($filteKeys)){
            throw new InvalidArgumentException('Invalid type filteKeys');
        }

        $filteKeys = array_merge([
            'c','a','eid','version_id','m','do','i','menu_fold_tag:platform',
            'state','op','message','jsMenuScroll','menu_fold_tag:platform_module_menu'
        ],$filteKeys);

        foreach ($param as $k => $v) {
            if(in_array($k,$filteKeys) || strpos($k,'module_status') === 0 || strpos($k,'__') === 0 || strpos($k,'_') === 0){
                unset($param[$k]);
            }
        }
        return $param;
    }
}