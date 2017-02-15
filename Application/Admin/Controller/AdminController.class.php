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
            $mark = '<'.$this->admininfo['name'].'>添加管理员'.'<'.$data['name'].'>';
            $res = $AdminUser->add($data);
        }else if($oper == 'edit'){
            $mark = '<'.$this->admininfo['name'].'>修改管理员'.'<'.$data['name'].'>信息';
            $res = $AdminUser->where(array('id'=>$id))->save($data);
        }else{
            $mark = '<'.$this->admininfo['name'].'>删除管理员';
            $res = $AdminUser->where(array('id'=>$id))->delete();
        }
        if($res){
            logData($this->admininfo['id'], $mark);
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
    //菜单数据
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
    //操作菜单数据
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
            $mark = '<'.$this->admininfo['name'].'>添加菜单';
            $res = $Menu->add($data);
        }else if($oper == 'edit'){
            $mark = '<'.$this->admininfo['name'].'>修改菜单';
            $res = $Menu->where(array('id'=>$id))->save($data);
        }else{
            $mark = '<'.$this->admininfo['name'].'>删除菜单';
            $res = $Menu->where(array('id'=>$id))->save(array('isdel'=>1));
        }
        if($res){
            logData($this->admininfo['id'], $mark);
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
        $privarr = $admin_user->where(array('id'=>$agentid,'isdel'=>0))->getField('priv_action');
        if(!empty($privarr)){$privarr = explode(',',$privarr);}
        $menu = M('menu');
        $parents = $menu->where(array('parentid'=>0,'isdel'=>0))->select();
        $childs = $menu->where('parentid!=0 and isdel=0')->select();
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
        $acctinfo = $admin_user->where(array('id'=>$agentid))->getField('name');
        $res = $admin_user->where(array('id'=>$agentid))->setField('priv_action',$privids);
        if($res){
            logData($this->admininfo['id'], '<'.$this->admininfo['name'].'>给<'.$acctinfo.'>分配权限');
            $this->return['status'] = 1;
            $this->return['info'] = '分配成功';
            $this->ajaxReturn($this->return);
        }else{
            $this->return['info'] = '分配失败';
            $this->ajaxReturn($this->return);
        }
    }
    public function log(){
        $acctlist = getlist_agents_child($this->session_id);
        $this->assign('acctlist',$acctlist);
        $this->display();
    }
    //操作日志
    public function logAjax(){
        $arr = [];
        $where = [];
        $Log = M('log');
        $count = $Log->count();
        $page = I('request.page',1,'int');
        $agentid = I('request.agentid',-1,'int');
        if($agentid!=-1){
            $where['cdb_log.agentid'] = $agentid;
        }
        $pageSize = I('request.rows',20,'int');
        $list=$Log->where($where)->field('cdb_log.*,a.name')
        ->join('LEFT JOIN cdb_admin_user a ON a.id=cdb_log.agentid')
        ->page($page, $pageSize)->order('addtime DESC')->select();
        foreach ($list as $key=>$val){
            $list[$key]['addtime'] = date('Y-m-d H:i:s',$val['addtime']);
        }
        $arr['total'] = $count;
        $arr['pageCount'] = ceil($arr['total'] / $pageSize);
        $arr['rows'] = $list;
        return $this->ajaxReturn($arr);
    }
    //系统通知
    public function notice(){
        $this->display();
    }
    //加载数据
    public function noticeAjax(){
        $arr = [];
        $where = ['cdb_notice.isdel'=>0];
        $Notice = M('notice');
        $count = $Notice->count();
        $page = I('request.page',1,'int');

        $pageSize = I('request.rows',20,'int');
        $list=$Notice->where($where)->field('cdb_notice.*,a.name')
        ->join('LEFT JOIN cdb_admin_user a ON a.id=cdb_notice.agentid')
        ->page($page, $pageSize)->select();
        foreach ($list as $key=>$val){
            $list[$key]['addtime'] = date('Y-m-d H:i:s',$val['addtime']);
        }
        $arr['total'] = $count;
        $arr['pageCount'] = ceil($arr['total'] / $pageSize);
        $arr['rows'] = $list;
        return $this->ajaxReturn($arr);
    }
    //操作通知数据
    public function noticeedit() {
        $return = ['status'=>0,'info'=>'','data'=>array()];
        $oper = I('request.oper','','string');
        $id = I('request.id',0,'int');
        $content = I('request.content','','string');
        $Notice = M('notice');
        $data = ['content'=>$content];
        if($oper == 'add'){
            $mark = '<'.$this->admininfo['name'].'>发布通知';
            $data['addtime'] = time();
            $data['agentid'] = $this->admininfo['id'];
            $res = $Notice->add($data);
        }else if($oper == 'edit'){
            $mark = '<'.$this->admininfo['name'].'>修改通知';
            $res = $Notice->where(array('id'=>$id))->save($data);
        }else{
            $mark = '<'.$this->admininfo['name'].'>删除通知';
            $res = $Notice->where(array('id'=>$id))->save(array('isdel'=>1));
        }
        if($res){
            logData($this->admininfo['id'], $mark);
            $return['status'] = 1;
            $return['info'] = '操作成功';
        }else{
            $return['info'] = '操作失败';
        }
        return $this->ajaxReturn($return);
    }
}