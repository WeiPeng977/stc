<?php
namespace app\index\controller;
use think\Controller;
use Util\data\Sysdb;

class Account extends Controller
{
    public function account()
    {
        return $this->fetch();
    }
    public function login()
    {
      return $this->fetch();
    }
    public function dologin(){
  		 $username = trim(input('post.username'));
  		 $pwd = trim(input('post.pwd'));
      // exit(json_encode(array('code'=>1,'msg'=>'test')));
  		if($username == ''){
  		exit(json_encode(array('code'=>1,'msg'=>'用户名不能为空')));
  		}
  		if($pwd == ''){
  	  exit(json_encode(array('code'=>1,'msg'=>'密码不能为空')));
  		}
  		// 验证用户
  		$this->db = new Sysdb;
  		$user = $this->db->table('user')->where(array('username'=>$username))->item();
  		if(!$user){
  			exit(json_encode(array('code'=>1,'msg'=>'用户不存在')));
  		}
  		if($pwd != $user['password']){
  			exit(json_encode(array('code'=>1,'msg'=>'密码错误')));
  		}
      //exit(json_encode(array('code'=>1,'msg'=>'test')));
  		// 设置用户session
  		session('user',$user);
  		exit(json_encode(array('code'=>0,'msg'=>'登录成功')));
  	}

  	public function logout(){
  		session('admin',null);
  		exit(json_encode(array('code'=>0,'msg'=>'退出成功')));
  	}
    public function register()
    {
        return $this->fetch();
    }
    public function home()
    {
        return $this->fetch();
    }
    public function modifyNumber()
    {
        return $this->fetch();
    }
    public function modifyPass()
    {
        return $this->fetch();
    }
    public function personal_information()
    {
        return $this->fetch();
    }
}
