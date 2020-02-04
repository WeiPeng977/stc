<?php
/**
* 标签管理
*/
namespace app\admins\controller;
use app\admins\controller\BaseAdmin;

class Labels extends BaseAdmin{

	// 频道管理
	public function type(){
		$type = $this->db->table('goods_label')->where(array('flag'=>'type'))->lists();
		$this->assign('data',$type);
		return $this->fetch();
	}

	public function save(){
		$flag = trim(input('post.flag'));
		$ords = input('post.ords/a');
		$titles = input('post.titles/a');
		$status = input('post.status/a');

		foreach ($ords as $key => $value) {
			// 新增
			$data['flag'] = $flag;
			$data['ord'] = $value;
			$data['title'] = $titles[$key];
			$data['status'] = isset($status[$key]) ? 1 : 0;

			if($key==0 && $data['title']){
				$this->db->table('goods_label')->insert($data);
			}
			if($key > 0){
				if($data['title']==''){
					// 删除
					$this->db->table('goods_label')->where(array('id'=>$key))->delete();
				}else{
					// 修改
					$this->db->table('goods_label')->where(array('id'=>$key))->update($data);
				}
			}
		}
		exit(json_encode(array('code'=>0,'msg'=>'保存成功')));
	}
}
