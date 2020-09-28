<?php
namespace Lzhy\Yw7\Utils;

use Lzhy\Yw7\Traits\Oauth;

class Wechat
{
    use Oauth;

    public static $wxApiBaseUrl = 'https://api.weixin.qq.com';

    /**
     * 微信网页授权
     * @param string $scope
     * @return void
     */
    public static function auth2($scope = 'base')
    {
        $code  = Assist::gpcVal('code');
        $state = Assist::gpcVal('state');
        $oauthAccount = Assist::globalVal('oauth_account');

        $lastAuthState = Assist::gpcVal('auth2_redirect_state');
        if(empty($code) || ($state && $lastAuthState && $state !== $lastAuthState)){
            $state = random(6);
            $backUrl = Assist::globalVal('siteurl');
            isetcookie('yw7_auth2_redirect_state',$state,60);
            self::authRedirect($backUrl,$scope,$oauthAccount,$state);
        }

        $userinfo = self::code2userinfo($oauthAccount,$code,$scope);
        return $userinfo;
    }

    /**
     * 获取公众号accesstoken
     * @return void
     */
    public static function getAccessToken()
    {
        $key = 'yw7_wechat_assesstoken';
        $accessToken = cache_load($key);
        if($accessToken){
            return $accessToken;
        }

        $account_api = \WeAccount::create();
        if(empty($accessToken)){
            $accessToken = $account_api->getAccessToken();
            if(is_string($accessToken)){
                cache_write($key,$accessToken,600);
                return $accessToken;
            }
        }

        throw new \Exception('获取accesstoken失败');
    }

    /**
     * 获取开放平台componentAssessToken
     * @return void
     */
    public static function componentAccessToken()
    {
        $key = 'yw7_account_component_assesstoken';
        $componentAssessToken = cache_load($key);
        if($componentAssessToken){
            return $componentAssessToken;
        }

        load()->classs('weixin.platform');
        if(empty($componentAssessToken)){
            $account_platform = new \WeixinPlatform();
            $componentAssessToken = $account_platform->getComponentAccesstoken();
            if(is_string($componentAssessToken)){
                cache_write($key,$componentAssessToken,600);
                return $componentAssessToken;
            }
        }

        throw new \Exception('获取componentaccesstoken失败');
    }
}