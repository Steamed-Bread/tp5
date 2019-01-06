<?php
/**
 * 
 * 微信API异常类
 * @author xuxing
 *
 */
namespace app\admin\tools;
class MyException extends Exception {
	public function errorMessage()
	{
		return $this->getMessage();
	}
}
