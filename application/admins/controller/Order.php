<?php
/**
* 订单管理
*/
namespace app\admins\controller;
use app\admins\controller\BaseAdmin;

class Order extends BaseAdmin{
	// 订单列表
	public function index(){
		$data['pageSize'] = 15;
		$data['page'] = max(1,(int)input('get.page'));

		$data['wd'] = trim(input('get.wd'));
		$where = array();
		$data['wd'] && $where = 'title like "%'.$data['wd'].'%"';
		$data['data'] = $this->db->table('order')->where($where)->order('oid desc')->pages($data['pageSize']);

		$this->assign('data',$data);
		return $this->fetch();
	}

	// 编辑订单
	public function add(){

		$oid = (int)input('get.oid');

		$data['item'] = $this->db->table('order')->where(array('oid'=>$oid))->item();

		$this->assign('data',$data);
		return $this->fetch();
	}

	public function save(){
		$gid = (int)input('post.gid');
		$data['title'] = trim(input('post.title'));
		$data['type_id'] = (int)input('post.type_id');
		$data['img'] = trim(input('post.img'));
		$data['price'] = trim(input('post.price'));
		$data['stock'] = trim(input('post.stock'));
		$data['desc'] = trim(input('post.desc'));
		$data['status'] = (int)input('post.status');

		if($data['title'] == ''){
			exit(json_encode(array('code'=>1,'msg'=>'商品名称不能为空')));
		}
		if($gid){
			$this->db->table('goods')->where(array('gid'=>$gid))->update($data);
		}else{
			$data['add_time'] = time();
			$this->db->table('goods')->insert($data);
		}
		exit(json_encode(array('code'=>0,'msg'=>'保存成功')));
	}


	// 删除
	public function delete(){
		$id = (int)input('post.id');
		$this->db->table('goods')->where(array('id'=>$id))->delete();
		exit(json_encode(array('code'=>0,'msg'=>'删除成功')));
	}
}
