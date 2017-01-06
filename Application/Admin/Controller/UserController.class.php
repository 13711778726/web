<?php
namespace Admin\Controller;
use Think\Controller;
class UserController extends CommonController {
    //分类模板
    public function userlist() {
        $this->display();
    }
    //分类数据加载
    public function userAjax(){
        $arr = [];
        $where = ['isdel'=>0];
        $User = M('user');
        $count = $User->count();
        $page = I('request.page',1,'int');
        $nickname = I('request.nickname','','string');
        $username = I('request.username','','string');
        if(!empty($nickname)){
            $where['nickname'] = array('like',"%$nickname%");
        }
        if(!empty($username)){
            $where['username'] = $username;
        }
        $pageSize = I('request.rows',20,'int');
        $list=$User->where($where)->page($page, $pageSize)->select();
        foreach ($list as $key=>$val){
            $list[$key]['addtime'] = date('Y-m-d H:i:s',$val['addtime']);
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
        $username = I('request.username','','string');      
        $userid = I('request.userid',0,'int');
        $nickname = I('request.nickname','','string');
        $email = I('request.email','','string');
        $desc = I('request.desc','','string');
        $User = M('user');
        $data = ['nickname'=>$nickname,'username'=>$username,'email'=>$email,'desc'=>$desc];
        if($oper == 'add'){
            $mark = '<'.$this->admininfo['name'].'>添加用户<'.$data['username'].'>';
            $data['addtime'] = time();
            $res = $User->add($data);
        }else if($oper == 'edit'){
            $mark = '<'.$this->admininfo['name'].'>修改用户<'.$data['username'].'>';
            $res = $User->where(array('userid'=>$userid))->save($data);
        }else{
            $mark = '<'.$this->admininfo['name'].'>删除用户';
            $res = $User->where(array('userid'=>$userid))->save(array('isdel'=>1));
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