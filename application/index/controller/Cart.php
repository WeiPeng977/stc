<?php
namespace app\index\controller;
use think\Controller;
use Util\data\Sysdb;

class Cart extends BaseAdmin
{
    public function cart()
    {
        $data['pageSize'] = 4;
        $data['page'] = max(1,(int)input('get.page'));
        $user_id = session('user.id');
        $goods_id = $this->db->table('cart')->where(array('user_id'=>$user_id))->lists();
        $length = count($goods_id);
        for ($i=0; $i<$length; $i++){
            $goods[$i] =  $this->db->table('goods')->where(array('id'=>$goods_id[$i]['goods_id']))->item();
        }
        $data['goods'] = $goods;
        $this->assign('data',$data);
        return $this->fetch();
    }
    public function doput(){
       // exit(json_encode(array('code'=>1,'msg'=>'test')));
       $data['user_id'] = trim(input('id'));
       $data['goods_id'] = trim(input('goods_id'));
      // exit(json_encode(array('code'=>1,'msg'=>'$repwd')));
      $res = true;
        // 检查用户是否已存在
        $this->db = new Sysdb;
        $res = $this->db->table('cart')->insert($data);

        //$data['add_time'] = time();
        // 保存用户


      if(!$res){
        exit(json_encode(array('code'=>1,'msg'=>'添加失败')));
      }
      exit(json_encode(array('code'=>0,'msg'=>'添加成功')));
    }
}
