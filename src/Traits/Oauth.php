<?php
namespace Lzhy\Yw7\Traits;

use Lzhy\Yw7\Utils\Assist;

trait Oauth
{
    /**
     * code换取用户信息
     * @param [type] $oauthAccount
     * @param [type] $code
     * @param [type] $scope
     * @return void
     */
    public static function code2userinfo($oauthAccount,$code,$scope)
    {
        $authType =  $oauthAccount['type'];
        $appId = $oauthAccount['key'];
        $appSecret = $oauthAccount['secret'];

        try{
            $url = self::_buildOauth2AccessTokenUrl($authType,$appId,$appSecret,$code);
            $result = ihttp_get($url);
            if(isset($result['content'])){
                $content = json_decode($result['content'],true);
                if($content['errcode']){
                    throw new \Exception($content['errmsg']);
                }
                $userInfo = [];
                if($scope == 'base'){
                    $userInfo = ['openid'=>$content['openid']];
                }else{
                    $userInfo = self::_snsUserinfo($content['access_token'],$content['openid']);
                }
                return $userInfo;
            }
        }catch(\Exception $e){
            throw new \Exception('拉取用户信息失败'.$e->getMessage());
        }
    }

    /**
     * 构造换取token链接
     * @param [type] $authType
     * @param [type] $appId
     * @param [type] $appSecret
     * @param [type] $code
     * @return void
     */
    private static function _buildOauth2AccessTokenUrl($authType,$appId,$appSecret,$code)
    {
        if($authType == 1){
            $url = sprintf('https://api.weixin.qq.com/sns/oauth2/access_token?%s',http_build_query([
                'appid' => $appId,
                'secret' => $appSecret,
                'code'   => $code,
                'grant_type' => 'authorization_code'
            ]));
        }else if($authType == 3){
            $componentAppid = Assist::globalVal('setting.platform.appid');
            $url = sprintf('https://api.weixin.qq.com/sns/oauth2/component/access_token?%s',http_build_query([
                'appid'  => $appId,
                'code'   => $code,
                'grant_type' => 'authorization_code',
                'component_appid' => $componentAppid,
                'component_access_token' => self::componentAccessToken()
            ]));
        }else{
            throw new \Exception('暂不支持当前公众号授权');
        }

        return $url;
    }

    /**
     * 拉取用户信息
     * @param [type] $accessToken
     * @param [type] $openid
     * @return void
     */
    private static function _snsUserinfo($accessToken,$openid)
    {
        try{
            $url = sprintf('https://api.weixin.qq.com/sns/userinfo?access_token=%s&openid=%s&lang=zh_CN',$accessToken,$openid);
            $result  = ihttp_get($url);
            $content = json_decode($result['content'],true);
            if($content['errcode']){
                throw new \Exception($content['errmsg']);
            }
            return $content;
        }catch(\Exception $e){
            throw new \Exception('拉取用户信息失败'.$e->getMessage());
        }
    }

    /**
     * 微信授权跳转
     * @param [type] $backUrl
     * @param [type] $scope
     * @param [type] $oauthAccount
     * @param [type] $state
     * @return void
     */
    public static function authRedirect($backUrl,$scope,$oauthAccount,$state)
    {
        $authType =  $oauthAccount['type'];
        $appId = $oauthAccount['key'];

        if($scope == 'base'){
            $scope = 'snsapi_base';
        }else{
            $scope = 'snsapi_userinfo';
        }

        $_param = [
            'appid' => $appId,
            'redirect_uri' => $backUrl,
            'response_type' => 'code',
            'scope' => $scope,
            'state' => $state
        ];

        $authUrl = 'https://open.weixin.qq.com/connect/oauth2/authorize?%s#wechat_redirect';
        if($authType == 1){
            $jumpUrl = sprintf($authUrl,http_build_query($_param));
        }else if($authType == 3){
            $componentAppid = Assist::globalVal('setting.platform.appid');
            $jumpUrl = sprintf($authUrl,http_build_query(array_merge($_param,[
                'component_appid' => $componentAppid
            ])));
        }else{
            throw new \Exception('暂不支持当前公众号授权');
        }

        header('Location:'.$jumpUrl);
        exit();
    }
}