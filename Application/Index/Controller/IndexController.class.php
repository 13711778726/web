<?php
namespace Index\Controller;
class IndexController extends CommonController {
    public function index(){
        //获取导航菜单
        $catlist = $this->catlist();
        $this->display();
    }
}