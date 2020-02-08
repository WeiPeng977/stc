<?php
namespace app\index\controller;
use think\Controller;
use Util\data\Sysdb;
use think\Db;

class Cart extends BaseAdmin
{
    public function cart()
    {

        $user_id = session('user.id');
        $goods_id = $this->db->table('cart')->where(array('user_id'=>$user_id))->lists();
        $total = count($goods_id);
        $data['pageSize'] = 4;
        $data = Db::table('cart')
        ->alias('c')
        ->join('goods g','c.goods_id = g.id')
        ->where('user_id','5')
        ->paginate($data['pageSize'],$total);

        $goods['total'] = $total;
        $goods['lists'] = $data->items();
        $goods['pages'] = $data->render();
        $data['pageSize'] = 4;
        $data['page'] = max(1,(int)input('get.page'));
        $data['data'] = $goods;
        // $data['data']['total'] = $length;
        $this->assign('data',$data);
        $cart['num'] = $total;
        session('cart',$cart);
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

    public function delete(){
  		$id = (int)input('post.id');
  		$this->db->table('cart')->where(array('id'=>$id))->delete();
  		exit(json_encode(array('code'=>0,'msg'=>'删除成功')));
  	}
}
