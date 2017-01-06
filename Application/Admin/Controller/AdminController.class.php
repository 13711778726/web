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
            $data['priv_action'] = '4,8,9,10,11,14';
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
    //权限列表
    public function privlist(){
        $agentid = I('request.agentid',0,'int');
        $admin_user = M('admin_user');
        $privarr = $admin_user->where(array('id'=>$agentid))->getField('priv_action');
        if(!empty($privarr)){$privarr = explode(',',$privarr);}
        $menu = M('menu');
        $parents = $menu->where(array('parentid'=>0))->select();
        $childs = $menu->where('parentid!=0')->select();
        foreach ($parents as $key=>$val){
            foreach ($childs as $k=>$v){
                if(in_array($v['id'],$privarr)){
                    $childs[$k]['ischeck'] ='checked';
                }else{
                    $childs[$k]['ischeck'] ='';
                }                
                if($val['id'] == $v['parentid']){
                    $parents[$key]['child'][] = $childs[$k];
                }
            }           
        }
        $this->return['status'] = 1;
        $this->return['data'] = $parents;
        $this->ajaxReturn($this->return);
    }
    //权限管理
    public function priv() {
        $admin_user = M('admin_user');
        $agentid = I('request.agentid',0,'int');
        $privids = I('request.privids','','string');
        if(empty($privids)){
            $this->return['info'] = '提交的选择为空';
            $this->ajaxReturn($this->return);
        }
        $res = $admin_user->where(array('id'=>$agentid))->setField('priv_action',$privids);
        if($res){
            $this->return['status'] = 1;
            $this->return['info'] = '分配成功';
            $this->ajaxReturn($this->return);
        }else{
            $this->return['info'] = '分配失败';
            $this->ajaxReturn($this->return);
        }
    }
}