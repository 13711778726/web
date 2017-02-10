<?php
namespace Index\Controller;
use Think\Controller;
class CommonController extends Controller {
    protected $return = array("status"=>0, "info"=>"", "data"=>array());
    public function _initialize() {
        //self::com_head();
    }
    public function catlist(){
        $Cat = M('cat');
        $where = ['isdel'=>0,'isshow'=>1];
        $list=$Cat->where($where)->field('catid,name')->limit(0,5)->select();
        return $list;
    }
}