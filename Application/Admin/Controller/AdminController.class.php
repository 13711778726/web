<?php
namespace Admin\Controller;
use Think\Controller;
class AdminController extends Controller {
    //引入模版
    function adminlist(){
        $this->display();
    }
    //数据加载
    function adminlistAjax(){
        $arr = [];
        $where = [];
        $AdminUser = M('admin_user');
        $count = $AdminUser->count();
        $page = I('request.page',1,'int');
        $name = I('request.name','','string');
        $tel = I('request.tel','','string');
        if(!empty($name)){
            $where['name'] = array('like',"%$name%");
        }
        if(!empty($tel)){
            $where['tel'] = $tel;
        }
        $pageSize = I('request.rows',20,'int');
        $list=$AdminUser->where($where)->page($page, $pageSize)->select();
        $arr['total'] = $count;
        $arr['pageCount'] = ceil($arr['total'] / $pageSize);
        $arr['rows'] = $list;
        return $this->ajaxReturn($arr);
    }
    //操作数据
    function edit(){
        $return = ['status'=>0,'info'=>'','data'=>array()];
        $oper = I('request.oper','','string');
        $name = I('request.name','','string');
        $password = I('request.password','','string');
        $tel = I('request.tel','','string');
        $email = I('request.email','','string');
        $id = I('request.id',0,'int');
        $AdminUser = M('admin_user');
        $data = ['name'=>$name,'password'=>$password,'tel'=>$tel,'email'=>$email];
        if($oper == 'add'){
            $res = $AdminUser->add($data);
        }else if($oper == 'edit'){
            $res = $AdminUser->where(array('id'=>$id))->save($data);
        }else{
            $res = $AdminUser->where(array('id'=>$id))->delete();
        }
        if($res){
            $return['status'] = 1;
            $return['info'] = '操作成功';           
        }else{
            $return['info'] = '操作失败';
        }
        return $this->ajaxReturn($return);
    }
}