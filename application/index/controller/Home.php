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
}
