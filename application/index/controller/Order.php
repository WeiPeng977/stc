<?php
namespace app\index\controller;
use think\Controller;

class Order extends BaseAdmin
{
    public function order()
    {
        $uid = session('user.uid');
        $data['pageSize'] = 3;
    		$data['page'] = max(1,(int)input('get.page'));

    		$data['wd'] = trim(input('get.wd'));
    		$where = array();
    		$data['wd'] && $where = 'title like "%'.$data['wd'].'%"';
        $where['user_id'] = $uid;
    		$data['data'] = $this->db->table('order')->where($where)->order('oid desc')->pages($data['pageSize']);

        for($i=0;$i<count($data['data']['lists']);$i++){
          $data['data']['lists'][$i]['goods_ids'] = explode(",",$data['data']['lists'][$i]['goods_ids']);
          for($j=0;$j<count($data['data']['lists'][$i]['goods_ids']);$j++){
            $data['data']['lists'][$i]['goods_ids'][$j] = $this->db->table('goods')->where(array('gid'=>$data['data']['lists'][$i]['goods_ids'][$j]))->item();
          }
        }
        $this->assign('data',$data);
        return $this->fetch();
    }
    public function add()
    {
        $num = (String)input('get.num');

        $nums = explode(",",$num);
        $gid = (String)input('get.gid');
        $gids = explode(",",$gid);
        $length = count($gids);

        $price = 0;
        if($gid){
          for($i=0;$i<$length;$i++){
              $goods[$i] = $this->db->table('goods')->where(array('gid'=>$gids[$i]))->item();
              $goods[$i]['num'] = $nums[$i];
              $goods[$i]['total'] = $nums[$i]*$goods[$i]['price'];
              $price = $price + $goods[$i]['total'];

          }
          $data['num'] = $num;
          $data['gid'] = $gid;
          $data['goods'] = $goods;
          $data['price'] = $price;

          $this->assign('data',$data);
          return $this->fetch();
        }else{
          return "请选择商品";
        }

         // var_dump($goods);
    }
    public function save(){
      $data['goods_nums'] = trim(input('post.num'));
      $data['user_id'] = (int)input('post.uid');
      $data['goods_ids'] = trim(input('post.gid'));
      $data['receiver'] = trim(input('post.receiver'));
      $data['phone'] = trim(input('post.phone'));
      $data['price'] = trim(input('post.price'));
      $data['address'] = trim(input('post.address'));
      // exit(json_encode(array('code'=>1,'msg'=>$data['goods_nums'])));
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
      $data['status'] = "0";
      $this->db->table('order')->insert($data);

      exit(json_encode(array('code'=>0,'msg'=>'订单创建成功')));
    }
    //确定确认收货
    public function confirm(){
      $oid = (int)input('post.oid');
      $data['status'] = 3;
      $this->db->table('order')->where(array('oid'=>$oid))->update($data);
      exit(json_encode(array('code'=>0,'msg'=>'确认收货成功')));
    }

    //确定付款
    public function pay(){
      $oid = (int)input('post.oid');
      $data['status'] = 1;
      $this->db->table('order')->where(array('oid'=>$oid))->update($data);
      exit(json_encode(array('code'=>0,'msg'=>'付款成功')));
    }

    //订单详情
    public function details(){
      $oid = (int)input('get.oid');
      $data['item'] =$this->db->table('order')->where(array('oid'=>$oid))->item();
      $this->assign('data',$data);
      return $this->fetch();
    }
}
