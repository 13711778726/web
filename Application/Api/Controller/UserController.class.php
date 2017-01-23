<?php
namespace Api\Controller;
class UserController extends CommonController {
    //用户登录
    public function login(){
        $user = M('user');
        $username = I('request.username','','string');
        $password = I('request.password','','string');
        $res = $user->where(array('username'=>$username))->find();
        if($res){
            //保存token
            $key = $key = $this->redisName.$res['userid'];
            $token = getKeyString(32);
            $this->redis->set($key, $token, 86400 * 7);
            $res['token'] = $token;
            $this->return['status'] = 1;
            $this->return['data'] = $res;
        }else{
            $this->return['info'] = '用户名或密码错误';
        }
        $this->ajaxReturn($this->return);
    }
    //用户注册
    public function register(){
        $user = M('user');
        $username = I('request.username','','string');
        $nickname = I('request.nickname','','string');
        $email = I('request.email','','string');
        $password = I('request.password','','string');
        $repassword = I('request.repassword','string');
        if(empty($username)){
            $this->return['info'] = '手机号码不能为空';
            $this->ajaxReturn($this->return);
        }
        if(!chenkPhone($username)){
            $this->return['info'] = '您输入的手机号码有误！';
            $this->ajaxReturn($this->return);
        }
        if($password!=$repassword){
            $this->return['info'] = '两次输入的密码不一致';
            $this->ajaxReturn($this->return);
        }
        $res = $user->where(array('username'=>$username))->find();
        if($res){
            $this->return['info'] = '该用户已经存在';
            $this->ajaxReturn($this->return);
        }
        $data = ['username'=>$username,'password'=>$password,'email'=>$email,'nickname'=>$nickname,'addtime'=>time()];
        $re = $user->add($data);
        if($re){
            //保存token
            $key = $key = $this->redisName.$re;
            $token = getKeyString(32);
            $this->redis->set($key, $token, 86400 * 7);
            $data['userid'] = $re;
            $data['token'] = $token;
            $this->return['status'] = 1;
            $this->return['info'] = '注册成功';
            $this->return['data'] = $data;
        }else{
            $this->return['info'] = '注册失败';
        }
        $this->ajaxReturn($this->return);
    } 
    //用户中心(主客态)
    public function userinfo(){
        $arr = [];
        $isself = 0;
        //用户信息               
        $userinfo = $this->getuserinfo();
        if($userinfo['userid'] == $this->userid){$isself = 1;}
        $arr['isself'] = $isself;
        $arr['userinfo'] = $userinfo;
        $this->return['status'] = 1;
        $this->return['info'] = '用户信息';
        $this->return['data'] = $arr;
        $this->ajaxReturn($this->return);
    }
    //我的好友列表
    public function myfriend(){
        $page = I('request.page',1,'int');
        $rows = I('request.rows',10,'int');
        $arr = [];
        $this->isLogin();
        $friend = M('friend');
        $where = array('cdb_friend.userid'=>$this->userid,'cdb_friend.isdel'=>0);
        $res = $friend->field('cdb_friend.ruserid,u.username,u.nickname,u.userimg,u.addtime')
        ->join('LEFT JOIN cdb_user u ON u.userid = cdb_friend.ruserid')
        ->where($where)->page($page, $rows)->select();
        if(empty($res)){
            $this->return['info'] = '列表为空';
            $this->ajaxReturn($this->return);
        }
        foreach ($res as $key=>$val){
            if(!empty($val['userimg'])){
                $res[$key]['userimg'] = SITE_URL.'/Public/upload/Admin/'.$val['userimg'];
            }else{
                $res[$key]['userimg'] = SITE_URL.'/Public/upload/Admin/error.png';
            }
            $res[$key]['addtime'] = timeGange($val['addtime']);
        }
        $this->return['status'] = 1;
        $this->return['info'] = '好友列表';
        $this->return['data'] = $res;
        $this->ajaxReturn($this->return);
        
    }
    //添加好友
    public function addfriend(){
        
        $this->isLogin();
        $friend = M('friend');
        $ruserid = I('request.ruserid',0,'int');
        if($ruserid == 0){
            $this->return['info'] = '请选择要添加的好友';
            $this->ajaxReturn($this->return);
        }
        $re = $friend->where(array('userid'=>$this->userid,'ruserid'=>$ruserid))->find();
        if($re){
            $this->return['info'] = '您已经添加该好友';
            $this->ajaxReturn($this->return);
        }
        $data = ['userid'=>$this->userid,'ruserid'=>$ruserid,'addtime'=>time()];
        $res = $friend->add($data);
        if($res){
            $this->return['status'] = 1;
            $this->return['info'] = '添加成功';
            $this->ajaxReturn($this->return);
        }else{
            $this->return['info'] = '添加失败';
            $this->ajaxReturn($this->return);
        }
    }
    //删除好友
    public function delfriend(){
        $this->isLogin();
        $friend = M('friend');
        $ruserid = I('request.ruserid',0,'int');
        if($ruserid == 0){
            $this->return['info'] = '请选择要删除的好友';
            $this->ajaxReturn($this->return);
        }
        $res = $friend->where(array('userid'=>$this->userid,'ruserid'=>$ruserid))->setField('isdel',1);
        if($res){
            $this->return['status'] = 1;
            $this->return['info'] = '删除成功';
            $this->ajaxReturn($this->return);
        }else{
            $this->return['info'] = '删除失败';
            $this->ajaxReturn($this->return);
        }
    }
    //社区用户
    public function usergroup(){
        $page = I('request.page',1,'int');
        $rows = I('request.rows',10,'int');
        $user = M('user');
        $type = I('request.type',-1,'int');
        $selectinfo = I('request.selectinfo','');
        $where['isdel'] = 0;
        if($type == 0){
            $where['userid'] = $selectinfo; 
        }elseif($type == 1){
            $where['username'] = $selectinfo;
        }elseif($type == 2){
            $where['nickname'] = array('like',"%$selectinfo%");
        }
        
        $info = $user->field('userid,username,userimg,nickname')->where($where)->page($page,$rows)->select();
        if(empty($info)){
            $this->return['status'] = 1;
            $this->return['info'] = '列表为空';
            $this->ajaxReturn($this->return);
        }
        foreach ($info as $key=>$val){
            if(!empty($val['userimg'])){
    	        $info[$key]['userimg'] = SITE_URL.'/Public/upload/Admin/'.$info[$key]['userimg'];
    	    }else{
    	        $info[$key]['userimg'] = SITE_URL.'/Public/upload/Admin/error.png';
    	    } 
        }
        $this->return['status'] = 1;
        $this->return['info'] = '搜索列表';
        $this->return['data'] = $info;
        $this->ajaxReturn($this->return);
    }
    //修改密码
    public function editpass(){
        $user = M('user');
        $this->isLogin();
        $username = I('request.username','','string');
        $oldpassword = I('request.oldpassword','','string');
        $newpassword = I('request.newpassword','','string');
        $userinfo = $user->where(array('userid'=>$this->userid))->find();
        if($username != $userinfo['username']){
            $this->return['info'] = '账号错误';
            $this->ajaxReturn($this->return);
        }
        if($oldpassword != $userinfo['password']){
            $this->return['info'] = '您输入的旧密码不一致';
            $this->ajaxReturn($this->return);
        }
        $data = ['password'=>$newpassword];
        $res = $user->where(array('userid'=>$this->userid))->save($data);
        if($res){
            $this->return['status'] = 1;
            $this->return['info'] = '修改密码成功';
        }else{
            $this->return['info'] = '修改失败，请重试';
        }
        $this->ajaxReturn($this->return);
    }
    //修改个人信息
    public function edituserinfo() {
        $user = M('user');
        $this->isLogin();
        $email = I('request.email','','string');
        $sex = I('request.sex',-1,'int');
        $nickname = I('request.nickname','','string');
        $desc = I('request.desc','','string');
        if(!empty($email)){
            $data['email'] = $email;
        }
        if(!empty($nickname)){
            $data['nickname'] = $nickname;
        }
        if(!empty($desc)){
            $data['desc'] = $desc;
        }
        if($sex != -1){
            $data['sex'] = $sex;
        }
        $imgs = upload($_FILES['userimg'],200,200);
        if($imgs){
            $data['userimg'] = $imgs['img'][0]['savethumbname'][0];
        }
        if(empty($data)){
            $this->return['info'] = '不做任何修改';
            $this->ajaxReturn($this->return);
        }
        $res = $user->where(array('userid'=>$this->userid))->save($data);
        if($res){
            $this->return['status'] = 1;
            $this->return['info'] = '修改个人信息成功';
        }else {
            $this->return['info'] = '修改个人信息失败';
        }
        $this->ajaxReturn($this->return);
    }
}