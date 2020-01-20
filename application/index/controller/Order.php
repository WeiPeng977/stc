<?php
namespace app\index\controller;
use think\Controller;

class Order extends Controller
{
    public function order_all()
    {
        return $this->fetch();
    }
    public function order_payment()
    {
        return $this->fetch();
    }
    public function order_receive()
    {
        return $this->fetch();
    }
    public function order_send()
    {
        return $this->fetch();
    }
    public function order()
    {
        return $this->fetch();
    }
}
