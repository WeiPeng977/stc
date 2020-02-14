<?php
namespace app\admins\controller;
use think\Controller;
use Util\data\Sysdb;
/**
*
*/
class Test extends Controller
{
  public function __construct(){
    parent::__construct();
    $this->db = new Sysdb;
  }
  public function goods(){
      $data['type_id'] = (int)input('get.type_id');
      $data['pageSize'] = 10;
      $data['page'] = max(1,(int)input('get.page'));

      $data['wd'] = trim(input('get.wd'));
      $where = array();
      $data['wd'] && $where = 'title like "%'.$data['wd'].'%"';

      if($data['type_id']){
          $where['type_id'] = $data['type_id'];
      }

      $data['data'] = $this->db->table('goods')->where($where)->order('gid desc')->pages($data['pageSize']);
      $this->assign('data',$data);
      return $this->fetch();
  }
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
