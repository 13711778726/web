<?php
namespace Index\Controller;
use Think\Controller;
class CommonController extends Controller {
    protected $return = array("status"=>0, "info"=>"", "data"=>array());
    protected $userinfo = null;
    protected $userid = null;
    public function _initialize() {
        $userinfo = session("userinfo");
        $this->userid = isset($userinfo['userid']) ? $userinfo['userid'] : '';
        $this->userinfo = $userinfo;
    }
    public function catlist(){
        $Cat = M('cat');
        $where = ['isdel'=>0,'isshow'=>1];
        $list=$Cat->where($where)->field('catid,name')->limit(0,5)->select();
        return $list;
    }
    public function isLogin() {
        $userinfo = session("userinfo");
        if($userinfo){
            $User = M('user');
            $res = $User->where(array('userid'=>$userinfo['userid']))->find();
            if($res){
                session("userinfo",$res);                
            }else{
                session("userinfo", null);
            }
        }else{
            session("userinfo", null);
            $this->redirect('User/login');
        }
    }
}