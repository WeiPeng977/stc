<?php
namespace app\index\controller;
use think\Controller;
use Util\data\Sysdb;

class Test extends Controller
{
  public function __construct(){
		parent::__construct();
		$this->db = new Sysdb;
	}
    public function index()
    {
      
      return $this->fetch();
    }

}
