<?php
namespace app\index\controller;
use think\Controller;
use Util\data\Sysdb;

class Goods extends Controller
{
  public function __construct(){
    parent::__construct();
    $this->db = new Sysdb;
  }
    public function goods()
    {
        $data['type_id'] = (int)input('get.type_id');
        $data['pageSize'] = 4;
    		$data['page'] = max(1,(int)input('get.page'));

    		$data['wd'] = trim(input('get.wd'));
    		$where = array();
    		$data['wd'] && $where = 'title like "%'.$data['wd'].'%"';

        if($data['type_id']){
            $where['type_id'] = $data['type_id'];
        }

    		$data['data'] = $this->db->table('goods')->where($where)->order('gid desc')->pages($data['pageSize']);
        $this->assign('data',$data);
        return $this->fetch();
    }
    public function goodsDetails()
    {
        $data['user'] = session('user');
        $data['goods_id'] = (int)input('get.goods_id');
        $data['data'] = $this->db->table('goods')->where(array('gid'=>$data['goods_id']))->item();
        $this->assign('data',$data);
        return $this->fetch();
    }
}
