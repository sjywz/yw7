<h1 align="center"> yw7 </h1>

<p align="center"> 微擎模块开发脚手架 </p>

[![Build Status](https://travis-ci.org/sjywz/yw7.svg?branch=master)](https://travis-ci.org/sjywz/yw7)

## 安装

```shell
$ composer require lzhy/yw7 -vvv
```

修改`site.php`：

```php
//site.php
use Lzhy\Yw7\Boot;

defined('IN_IA') or exit('Access Denied');
require __DIR__ . '/vendor/autoload.php';

class Daba3_sassModuleSite extends WeModuleSite
{
    function __call($name,$arguments)
    {
        $boot = new Boot($name,$arguments);
        $boot->start();
    }
}
```


### 工具
##### Lzhy\Yw7\Tool\Assist;

```php
Assist::globalVal('key','default-value');//获取或设置全局变量$_W

Assist::gpcVal('key','default-valut');//获取全局$_GPC

//默认会过滤掉微擎添加变量('c','a','eid','version_id','m','do','i','menu_fold_tag:platform','state','op','message','jsMenuScroll','menu_fold_tag:platform_module_menu')和下划线开头的变量，如需过滤更多可以传入第二个参数
Assist::filterParam(['test'=>1,'_test'=>2],['_test']);//['test'=>1] 过滤参数
```

##### Lzhy\Yw7\Tool\Url;

```php
Assist::gWebUrl('index/index');//生成后台管理链接

Assist::gMobileUrl('index/index'); //生成web端访问链接
```

##### Lzhy\Yw7\Tool\Wechat;

```php
Wechat::auth2('userinfo');//微信授权

Wechat::getAccessToken();//公众号accesstoken

Wechat::componentAccessToken();//开放平台accesstoken
```

## License

MIT
