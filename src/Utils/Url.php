<?php
namespace Lzhy\Yw7\Utils;

class Url
{
    /**
     * 生成app-url
     * @param $do
     * @param array $query
     * @return string
     */
    public static function gMobileUrl($do,$query = [])
    {
        if(strpos($do,'http') === 0){
            return $do;
        }
        if(strpos($do,'/') === false){
            $do = Assist::globalVal('yw7.do').'/'.$do;
        }

        $query = self::_buildQuery($do,$query);
        return str_replace('/./','/','/app/'.murl('entry',$query));
    }

    /**
     * 生成web-url
     * @param $do
     * @param array $query
     * @return string
     */
    public static function gWebUrl($do,$query = [])
    {
        if(strpos($do,'http') === 0){
            return $do;
        }

        $segment = 'site/entry';
        if(strpos($do,'/') === 0){
            $segment = ltrim($do,'/');
            $do = '';
        }
        if(strpos($do,'/') === false){
            $do = Assist::globalVal('yw7.do').'/'.$do;
        }

        $query = self::_buildQuery($do,$query);
        return str_replace('/./','/','/web/'.wurl($segment, $query));
    }

    /**
     * 构建url参数
     * @param $do
     * @param array $query
     * @return array
     */
    private static function _buildQuery($do,$query = [])
    {
        if($do){
            $_action = Assist::globalVal('yw7.action_name');
            if(strpos($do,'/')){
                $_dArr = explode('/',$do);
                $do = $_dArr[0];
                $query[$_action] = $_dArr[1];
            }
            $query['do'] = $do;
        }
        $query['m']  = Assist::gpcVal('m');

        return $query;
    }
}