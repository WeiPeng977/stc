<?php
namespace app\index\controller;
use think\Controller;
use Util\data\Sysdb;

class Index extends Controller
{
  public function __construct(){
		parent::__construct();
		$this->db = new Sysdb;
	}
    public function index()
    {

      $data['type_id'] = (int)input('get.type_id');
      $data['pageSize'] = 4;
      $data['page'] = max(1,(int)input('get.page'));

      $data['wd'] = trim(input('get.wd'));
      $where = array();
      $data['wd'] && $where = 'title like "%'.$data['wd'].'%"';
      $data['data'] = $this->db->table('goods')->where($where)->order('gid desc')->pages($data['pageSize']);
      $this->assign('data',$data);

      $type_list = $this->db->table('goods_label')->where(array('flag'=>'type'))->order('ord asc')->pages(16);
      $this->assign('type_list',$type_list['lists']);
      $this->assign('data',$data);
      return $this->fetch();
    }
  
}
