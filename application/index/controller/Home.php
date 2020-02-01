<?php
namespace app\index\controller;
use think\Controller;

class Home extends BaseAdmin
{
    public function home()
    {
        return $this->fetch();
    }
    public function account()
    {
        return $this->fetch();
    }
}
