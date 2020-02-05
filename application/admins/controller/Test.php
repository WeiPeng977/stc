<?php
namespace app\admins\controller;
use think\Controller;
use Util\data\Sysdb;
/**
*
*/
class Test extends Controller
{

 public function test(){
   return $this->fetch();
 }

 // 管理员登录
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
   $admin = $this->db->table('admins')->where(array('username'=>$username))->item();
   if(!$admin){
     exit(json_encode(array('code'=>1,'msg'=>'用户不存在')));
   }
   if($pwd != $admin['password']){
     exit(json_encode(array('code'=>1,'msg'=>'密码错误')));
   }
   if($admin['status'] == 1){
     exit(json_encode(array('code'=>1,'msg'=>'用户已被禁用')));
   }
   // 设置用户session
   session('admin',$admin);
   exit(json_encode(array('code'=>0,'msg'=>'登录成功')));
 }

 public function logout(){
   session('admin',null);
   exit(json_encode(array('code'=>0,'msg'=>'退出成功')));
 }
}
