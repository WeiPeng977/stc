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
  		if(md5($user['username'].$pwd) != $user['password']){
  			exit(json_encode(array('code'=>1,'msg'=>'密码错误')));
  		}
  		// 设置用户session
  		session('user',$user);
  		exit(json_encode(array('code'=>0,'msg'=>'登录成功')));
  	}

  	public function logout(){
  		session('user',null);
      session('cart',null);
  		exit(json_encode(array('code'=>0,'msg'=>'退出成功')));
  	}

    public function doregister(){
  		 $data['username'] = trim(input('post.username'));
  		 $password = trim(input('post.pwd'));
       $repwd = trim(input('post.repwd'));
       $data['telephone'] = trim(input('post.telephone'));
  		if($data['username'] == ''){
  		exit(json_encode(array('code'=>1,'msg'=>'用户名不能为空')));
  		}
  		if($password == ''){
  	  exit(json_encode(array('code'=>1,'msg'=>'密码不能为空')));
  		}
      if($repwd == ''){
      exit(json_encode(array('code'=>1,'msg'=>'确认密码不能为空')));
      }
      if($data['telephone'] == ''){
      exit(json_encode(array('code'=>1,'msg'=>'电话号码不能为空')));
      }
      if($password != $repwd){
      exit(json_encode(array('code'=>1,'msg'=>'两次密码输入不一致')));
      }
      if($password){
  			// 密码处理
  			$data['password'] = md5($data['username'].$password);
  		}
      $res = true;
  			// 检查用户是否已存在
        $this->db = new Sysdb;
  			$item = $this->db->table('user')->where(array('username'=>$data['username']))->item();
  			if($item){
  				exit(json_encode(array('code'=>1,'msg'=>'该用户已存在')));
  			}
        $res = $this->db->table('user')->insert($data);

  		if(!$res){
  			exit(json_encode(array('code'=>1,'msg'=>'注册失败')));
  		}
  		exit(json_encode(array('code'=>0,'msg'=>'注册成功')));
  	}
    public function register()
    {
        return $this->fetch();
    }
}
