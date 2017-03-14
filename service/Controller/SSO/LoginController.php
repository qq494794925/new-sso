<?php

/**
 * @author ryan
 * @desc sso登陆控制器
 */
namespace Controller\SSO;

use OneFox\Config;
use OneFox\Request;
use OneFox\Response;
use SSO\Ticket;
use SSO\Session;
use SSO\Code;

use OneFox\ApiController;

class LoginController extends ApiController {

    /**
     * 统一登陆跳转地址[GET]
     */
    public function indexAction() {
        $appId = $this->get('app_id', 0, 'string');
        if (!$appId) {
            echo 'appid not found';
            return;
        }
        $appId = (string)$appId;
        $jumpto = $this->get('jumpto');

        //安全检测
        $apps = Config::get('sso.apps');
        if (!isset($apps[$appId])) {
            echo 'not found app';
            return;
        }
        $cookieName = md5(Config::get('sso.cookie_name'));

        //认证端cookie不存在
        $cookie = Request::cookie($cookieName);
        if (!$cookie) {
            $this->_redirectLDAP($appId, $jumpto);
            return;
        }

        $ticketObj = new Ticket();
        $sessionId = $ticketObj->originData($cookie);


        //session过期或不存在
        $sessObj = new Session();
        if (!$sessObj->isExists($sessionId)) {
            $this->_redirectLDAP($appId, $jumpto);
            return;
        }
        //延长session有效期
        $sessObj->extendedTime($sessionId);

        //生成客户端code
        $codeObj = new Code();
        $code = $codeObj->generateCode($sessionId);

        //携带code重定向至子系统callback页面
        $appInfo = $apps[$appId];
        $callback = rtrim($appInfo['callback_url'], '?') . '?jumpto=' . urlencode($jumpto) . '&code=' . $code;

        Response::redirect($callback);
    }

    /**
     * 重定向至登陆页面(即LDAP)
     * @param int $appId
     * @param string $jumpto
     */
    private function _redirectLDAP($appId, $jumpto) {
        $paramArr = array(
            'jumpto' => $jumpto ? urlencode($jumpto) : 'index',
            'app_id' => $appId
        );
        $param = http_build_query($paramArr);
        $loginUrl = Config::get('sso.login_url');
        $loginUrl .= '?' . $param;
        Response::redirect($loginUrl);
    }

    /**
     * 校验登陆提交[POST]
     */
    public function check_loginAction() {
        if (Request::method() == 'post') {
            //完善你的登陆逻辑
        } else {
            $this->json(self::CODE_FAIL, 'url error');
        }
    }
}
