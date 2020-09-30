<?php
namespace Lzhy\Yw7\Core;

class Set
{
    /**
     * 设置全局变量
     * @param [type] $value
     * @return void
     */
    public static function setBootGlobalVal($value)
    {
        global $_W;
        $_W['yw7'] = $value;
    }

    /**
     * 默认启动参数
     * @return void
     */
    public static function defaultBootConf()
    {
        return [
            'action_name' => 'op',
            'static' => 'static/',
            'view_suffix' => 'html',
        ];
    }
}