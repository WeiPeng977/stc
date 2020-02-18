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
		$oid = (int)input('post.oid');
		$data['receiver'] = trim(input('post.receiver'));
		$data['phone'] = trim(input('post.phone'));
		$data['address'] = trim(input('post.address'));
		$data['price'] = trim(input('post.price'));
		if($data['receiver'] == ''){
			exit(json_encode(array('code'=>1,'msg'=>'收货人不能为空')));
		}
		if($data['phone'] == ''){
			exit(json_encode(array('code'=>1,'msg'=>'电话号码不能为空')));
		}
		if($data['address'] == ''){
			exit(json_encode(array('code'=>1,'msg'=>'收货地址不能为空')));
		}
		if($data['price'] == ''){
			exit(json_encode(array('code'=>1,'msg'=>'价格不能为空')));
		}
			$this->db->table('order')->where(array('oid'=>$oid))->update($data);

				exit(json_encode(array('code'=>0,'msg'=>'保存成功')));
	}
	// 发货
	public function express(){

		$oid = (int)input('get.oid');

		$data['item'] = $this->db->table('order')->where(array('oid'=>$oid))->item();

		$this->assign('data',$data);
		return $this->fetch();
	}
	public function express_save(){
		// exit(json_encode(array('code'=>0,'msg'=>"test")));
		$oid = trim(input('post.oid'));
		$data['express'] = trim(input('post.express'));
		$data['status'] = 2;

		if($data['express'] == ''){
			exit(json_encode(array('code'=>1,'msg'=>'快递单号不能为空')));
		}

	  $this->db->table('order')->where(array('oid'=>$oid))->update($data);

		exit(json_encode(array('code'=>0,'msg'=>'提交成功')));
	}


	// 删除
	public function delete(){
		$id = (int)input('post.id');
		$this->db->table('goods')->where(array('id'=>$id))->delete();
		exit(json_encode(array('code'=>0,'msg'=>'删除成功')));
	}
}
