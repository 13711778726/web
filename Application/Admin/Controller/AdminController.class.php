<?php
namespace Admin\Controller;
class AdminController extends CommonController{
    //引入模版
    function adminlist(){  
        $acctlist = getlist_agents_child($this->session_id);
        $this->assign('acctlist',$acctlist);
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
        foreach ($list as $key=>$val){
            $list[$key]['password'] = '******';
        }
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
        $data = ['name'=>$name,'password'=>authcode($password,'ENCODE'),'tel'=>$tel,'email'=>$email];
        if(empty($password)){
            unset($data['password']);
        }
        $acctid = $AdminUser->where(array('mode'=>0))->getField('id');
        if($oper == 'add'){
            $data['mode'] = 1;
            $data['agent_id'] = $acctid;
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
    public function menu(){
        $this->display();
    }
    public function menuAjax(){
        $arr = [];
        $where['isdel'] = 0;
        $list = M('menu')->field('id,name,parentid as _parentId,parentid as pid,url,status')->where($where)->page(1, 100)->select();  
        foreach ($list as $key=>$val){
            if($val['_parentId'] == 0){
                unset($list[$key]['_parentId']);
            }
        }
        $arr['rows'] = $list;
        return $this->ajaxReturn($arr);
    }
    //操作数据
    function menuedit(){
        $return = ['status'=>0,'info'=>'','data'=>array()];
        $oper = I('request.oper','','string');
        $name = I('request.name','','string');
        $id = I('request.id',0,'int');
        $url = I('request.url','','string');
        $parentid = I('request._parentId',0,'int');
        $Menu = M('menu');
        $data = ['name'=>$name,'url'=>$url,'parentid'=>$parentid];
        if($oper == 'add'){
            $res = $Menu->add($data);
        }else if($oper == 'edit'){
            $res = $Menu->where(array('id'=>$id))->save($data);
        }else{
            $res = $Menu->where(array('id'=>$id))->save(array('isdel'=>1));
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