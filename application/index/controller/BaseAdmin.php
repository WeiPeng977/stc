<?php
namespace app\index\controller;
use think\Controller;
use Util\data\Sysdb;

/**
*
*/
class BaseAdmin extends Controller
{
	public function __construct(){
		parent::__construct();
		$this->_user = session('user');
		// 未登录的用户不允许访问
		if(!$this->_user){
			header('Location: /index.php/index/Account/login');
			exit;
		}
		$this->assign('user',$this->_user);
		// 判断用户是否有权限
		$this->db = new Sysdb;
	}
}
