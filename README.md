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

Assist::gpcVal('key','default-valut');

Assist::filterParam(['test'=>1,'_test'=>2],['_test']);//['test'=>1] 过滤参数
```

##### Lzhy\Yw7\Tool\Url;

```php
Assist::gWebUrl('index/index');

Assist::gMobileUrl('index/index');
```

##### Lzhy\Yw7\Tool\Auth;

```php
Auth::auth2('userinfo');//微信授权

Auth::getAccessToken();//公众号accesstoken

Auth::componentAccessToken();//开放平台accesstoken
```

## License

MIT
