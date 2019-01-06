<?php
/**
* 	配置账号信息
*/
namespace app\admin\tools;
class WSCConfig
{
	//=======【基本信息设置】=====================================
	//
	/**
	 * 微信公众号信息配置
	 * APPID：绑定支付的APPID（必须配置，开户邮件中可查看）
	 * APPSECRET：公众帐号secert（仅JSAPI支付的时候需要配置， 登录公众平台，进入开发者中心可设置），
	 * 获取地址：https://mp.weixin.qq.com/advanced/advanced?action=dev&t=advanced/dev&token=2005451881&lang=zh_CN
	 * @var string
	 */
	const APPID = 'wx0070d881ac6ed8d4';
	const APPSECRET = 'b789b9d746576ca71ba676ae13e6431f';
	
	//=======【数据库配置】=====================================
	/**
	 * TODO：数据库连接参数
	 * USERNAME：用户名
	 * PASSWD：密码
	 * DBHOST：主机地址
	 * DBDATABASE：数据库名
	 * @var sting
	 */
	const USERNAME = 'zhangerzhen';
	const PASSWD = 'zhangerzhen823';
	const DBHOST = '139.196.72.117:3306';
	const DBDATABASE = 'wsc';
	const DBDATABASE_NB='nbinfo';
	
	//=======【token,ticket获取地址】===================================
	/**
	 * TODO：向数据服务请求TOKEN和TICKET
	 * TOKEN_URL：微信TOKEN
	 * TICKET_URL：JSSDK
	 * @var string
	 */
	const TOKEN_URL = "http://139.196.72.117:8080/welllidServer/token/getLatest.json";
	const TICKET_URL = "http://139.196.72.117:8080/welllidServer/ticket/getLatest.json";
	const START_URL = "http://localhost:8080/Wechat/check/mcode";

    //=======【用户信息提交地址】===================================
	/**
	 * @var string
	 */
    const USERINFO_ADD = "http://localhost:8080/Wechat/add/user";
    const USERINFO_DELETE = "http://localhost:8080/Wechat/delete/user";
    const DEVICE_ADD = "http://localhost:8080/Wechat/add/bindInfo";
    const DEVICE_DELETE = "http://localhost:8080/Wechat/update/bindInfo";

    //=======【欢迎页】===================================
	/**
	 * TODO：向数据服务请求TOKEN和TICKET
	 * TOKEN_URL：微信TOKEN
	 * TICKET_URL：JSSDK
	 * @var string
	 */
    const DESCRIPTION = 'your choice？';
    const PIC_URL = 'http://pioteks.com/WSC/Lib/Images/index.png';
    const URL = 'http://pioteks.com/WSC/NO_Access/NO_Access.php';
	

}
