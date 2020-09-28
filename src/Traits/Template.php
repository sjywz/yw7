<?php
namespace Lzhy\Yw7\Traits;

use Lzhy\Yw7\Utils\Assist;

trait Template
{
    protected static $data = [];

    /**
     * 发送变量
     * @param $key
     * @param string $value
     */
    public function assign($key,$value='')
    {
        if(is_string($key)){
            self::$data[$key] = $value;
        }else{
            if($key && is_array($key)){
                foreach ($key as $k => $v){
                    self::$data[$k] = $v;
                }
            }
        }
    }

    /**
     * 渲染视图
     * @param string $view
     * @param array $data
     * @param string $dir
     */
    public function display($view = '',$data = [],$dir = '')
    {
        if(empty($view)){
            $do = Assist::globalVal('yw7.do');
            $op = Assist::globalVal('yw7.op');
            $view = $do.'/'.$op;
        }
        exit($this->fetch($view,$data,$dir));
    }

    /**
     * 获取页面数据
     * @param $view
     * @param array $data
     * @param string $dir
     * @return mixed
     */
    public function fetch($view,$data = [],$dir = '')
    {
        global $_W,$_GPC;
        extract($this->_extractData($data));
        if(empty($dir)){
            $module = Assist::globalVal('yw7.module');
            $dir = MODULE_ROOT.'/'.$module.'/view/';
        }

        ob_start();
        include $this->_template($view,$dir);
        $content = ob_get_contents();
        ob_clean();

        return $content;
    }

    /**
     * 分拆发送变量
     * @param [type] $data
     * @return array
     */
    private function _extractData($data)
    {
        if(self::$data || $data){
            $data = array_merge(self::$data,$data);
        }
        $static = MODULE_URL.Assist::globalVal('yw7.static');
        $data['__static__'] = $static;
        return $data;
    }

    /**
     * 编译模板
     * @param $filename
     * @param $dir
     * @return mixed
     */
    private function _template($filename,$dir)
    {
        list($compile,$source) = self::_findTempFile($filename,$dir);
        if(!is_file($source)) {
            throw new \Exception("视图: {$dir}{$filename} 不存在");
        }
        if (DEVELOPMENT || !file_exists($compile) || filemtime($source) > filemtime($compile)){
            template_compile($source,$compile,true);
        }

        return $compile;
    }

    /**
     * 搜寻模板
     * @param $filename
     * @param $dir
     * @return array
     */
    private static function _findTempFile($filename,$dir)
    {
        $template = Assist::globalVal('template');
        $module   = Assist::globalVal('yw7.module');
        $name     = Assist::globalVal('current_module.name');
        $tplFile  = "{$template}/{$name}/{$module}/{$filename}.tpl.php";
        $compile  = IA_ROOT."/data/tpl/app/{$tplFile}";
        if(defined('IN_SYS')){
            $compile = IA_ROOT."/data/tpl/web/{$tplFile}";
        }

        $source = $dir.$filename;
        if(empty($dir)){
            $defineDir = IA_ROOT.'/addons/'.$name;
            $source = $defineDir."/template/{$filename}";
        }
        $htmlSuffix = Assist::globalVal('yw7.view_suffix');
        $source = $source.'.'.$htmlSuffix;

        return [$compile,$source];
    }

    /**
     * 加载公共模块
     * @param [type] $name
     * @return void
     */
    public static function template($name)
    {
        return template($name,TEMPLATE_INCLUDEPATH);
    }
}