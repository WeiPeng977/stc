<?php
namespace app\index\controller;
use think\Controller;

class Order extends BaseAdmin
{
    public function order_all()
    {
        return $this->fetch();
    }
    public function order_payment()
    {
        return $this->fetch();
    }
    public function order_receive()
    {
        return $this->fetch();
    }
    public function order_send()
    {
        return $this->fetch();
    }
    public function order()
    {
        return $this->fetch();
    }
    public function add()
    {
        $gid = (String)input('get.gid');
        $gids = explode(",",$gid);
        $length = count($gids);
        $price = 0;
        for($i=0;$i<$length;$i++){
            $goods[$i] = $this->db->table('goods')->where(array('gid'=>$gids[$i]))->item();
            $price = $price + $goods[$i]['price'];
        }
        $data['gid'] = $gid;
        $data['goods'] = $goods;
        $data['price'] = $price;
        $this->assign('data',$data);
        $this->view->engine->layout(false);
        return $this->fetch();
    }
    public function save(){
      $data['user_id'] = (int)input('post.uid');
      $data['goods_ids'] = trim(input('post.gid'));
      $data['receiver'] = trim(input('post.receiver'));
      $data['phone'] = trim(input('post.phone'));
      $data['price'] = trim(input('post.price'));
      $data['address'] = trim(input('post.address'));

      if($data['user_id'] == ''){
        exit(json_encode(array('code'=>1,'msg'=>'用户id不能为空')));
      }
      if($data['goods_ids'] == ''){
        exit(json_encode(array('code'=>1,'msg'=>'商品id不能为空')));
      }
      if($data['receiver'] == ''){
        exit(json_encode(array('code'=>1,'msg'=>'收货人不能为空')));
      }
      if($data['phone'] == ''){
        exit(json_encode(array('code'=>1,'msg'=>'收货人电话不能为空')));
      }
      if($data['price'] == ''){
        exit(json_encode(array('code'=>1,'msg'=>'订单总价不能为空')));
      }
      if($data['address'] == ''){
        exit(json_encode(array('code'=>1,'msg'=>'收货地址不能为空')));
      }

      $data['add_time'] = time();
      $this->db->table('order')->insert($data);

      exit(json_encode(array('code'=>0,'msg'=>'订单创建成功')));
    }
}
