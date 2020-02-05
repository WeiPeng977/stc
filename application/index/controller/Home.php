<?php
namespace app\index\controller;
use think\Controller;

class Home extends BaseAdmin
{
    public function home()
    {
        return $this->fetch();
    }
    public function account()
    {
        return $this->fetch();
    }
    public function modifyNumber()
    {
        return $this->fetch();
    }
    public function domodifytelephone(){


       $id = trim(input('post.id'));
       $telephone = trim(input('post.telephone'));
       $n_telephone = trim(input('post.n_telephone'));
       $v_telephone = trim(input('post.v_telephone'));
      // exit(json_encode(array('code'=>1,'msg'=>'$repwd')));
      if($telephone == ''){
      exit(json_encode(array('code'=>1,'msg'=>'原手机号不能为空')));
      }
      if($n_telephone == ''){
      exit(json_encode(array('code'=>1,'msg'=>'新手机号不能为空')));
      }
      if($v_telephone == ''){
      exit(json_encode(array('code'=>1,'msg'=>'确认手机号不能为空')));
      }
      if($n_telephone != $v_telephone){
      exit(json_encode(array('code'=>1,'msg'=>'两次电话号码输入不一致')));
      }
      $data['telephone'] = $n_telephone;


      $res = $this->db->table('user')->where(array('id'=>$id))->update($data);


        //$data['add_time'] = time();
        // 保存用户


      if(!$res){
        exit(json_encode(array('code'=>1,'msg'=>'保存失败')));
      }
      exit(json_encode(array('code'=>0,'msg'=>'保存成功')));
    }
    public function modifyPass()
    {
        return $this->fetch();
    }
    public function domodifypass(){

       $username = trim(input('post.username'));
       $id = trim(input('post.id'));
       $p_pwd = trim(input('post.p_pwd'));
       $pwd = trim(input('post.pwd'));
       $n_pwd = trim(input('post.n_pwd'));
       $v_pwd = trim(input('post.v_pwd'));
      // exit(json_encode(array('code'=>1,'msg'=>'test')));
      if($pwd == ''){
      exit(json_encode(array('code'=>1,'msg'=>'原密码不能为空')));
      }
      if($n_pwd == ''){
      exit(json_encode(array('code'=>1,'msg'=>'新密码不能为空')));
      }
      if($v_pwd == ''){
      exit(json_encode(array('code'=>1,'msg'=>'确认密码不能为空')));
      }
      if($n_pwd != $v_pwd){
      exit(json_encode(array('code'=>1,'msg'=>'两次密码输入不一致')));
      }
      if(md5($username.$pwd) != $p_pwd){
  			exit(json_encode(array('code'=>1,'msg'=>'原密码错误')));
  		}
      if($n_pwd){
        // 密码处理
        $data['password'] = md5($username.$n_pwd);
      }


      $res = $this->db->table('user')->where(array('id'=>$id))->update($data);


        //$data['add_time'] = time();
        // 保存用户


      if(!$res){
        exit(json_encode(array('code'=>1,'msg'=>'保存失败')));
      }
      exit(json_encode(array('code'=>0,'msg'=>'保存成功')));
    }
    public function personal_information()
    {
        return $this->fetch();
    }
    public function domodifyinformation(){
       $id = trim(input('post.id'));
       $truename = trim(input('post.truename'));
       $sex = trim(input('post.sex'));
       $age = trim(input('post.age'));
       $date = trim(input('post.date'));
      // exit(json_encode(array('code'=>1,'msg'=>'$repwd')));
      if($truename == ''){
      exit(json_encode(array('code'=>1,'msg'=>'姓名不能为空')));
      }
      if($sex == ''){
      exit(json_encode(array('code'=>1,'msg'=>'性别不能为空')));
      }
      if($age == ''){
      exit(json_encode(array('code'=>1,'msg'=>'年龄不能为空')));
      }
      if($date == ''){
      exit(json_encode(array('code'=>1,'msg'=>'出生日期不能为空')));
      }
      $data['truename'] = $truename;
      $data['sex'] = $sex;
      $data['age'] = $age;
      $data['date'] = $date;


      $res = $this->db->table('user')->where(array('id'=>$id))->update($data);


        //$data['add_time'] = time();
        // 保存用户


      if(!$res){
        exit(json_encode(array('code'=>1,'msg'=>'保存失败')));
      }
      exit(json_encode(array('code'=>0,'msg'=>'保存成功')));
    }
}
