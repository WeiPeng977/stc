<?php
namespace app\index\controller;
use think\Controller;

class Order extends BaseAdmin
{
    public function order()
    {
        $uid = session('user.uid');
        $data['pageSize'] = 2;
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
        $allstr = (String)input('get.allstr');
        $numstr = (String)input('get.numstr');
        $gid = (String)input('get.gid');
        $allstrs = explode(",",$allstr);
        $numstrs = explode(",",$numstr);
        $gids = explode(",",$gid);
        $length = count($gids);
        $sequence = []; //商品所在当前页面中的次序
        $num = [];

        for($j=0;$j<$length;$j++){
          for($i=0;$i<4;$i++){
            if($allstrs[$i] == $gids[$j]){
              $sequence[] = $i + 1;
            }
          }
        }

        for($i=0;$i<count($gids);$i++){
          $num[] = $numstrs[$sequence[$i]];
        }

       $data['num'] = $num;
       var_dump($num);



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
