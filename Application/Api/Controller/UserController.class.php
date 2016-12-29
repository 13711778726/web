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
            $this->return['info'] = '验证失败';
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
        }
        if($password!=$repassword){
            $this->return['info'] = '两次输入的密码不一致';
        }
        $res = $user->where(array('username'=>$username))->find();
        if($res){
            $this->return['info'] = '该用户已经存在';
        }
        $data = ['username'=>$username,'password'=>$password,'email'=>$email,'nickname'=>$nickname,'addtime'=>time()];
        $re = $user->add($data);
        if($re){
            //保存token
            $key = $key = $this->redisName.$re;
            $token = getKeyString(32);
            $this->redis->set($key, $token, 86400 * 7);
            $data['token'] = $token;
            $this->return['status'] = 1;
            $this->return['info'] = '注册成功';
            $this->return['data'] = $data;
        }else{
            $this->return['info'] = '注册失败';
        }
        $this->ajaxReturn($this->return);
    } 
    //用户中心
    public function userinfo(){
        $user = M('user');
        $arr = [];
        $this->isLogin();
        //用户信息
        $res = $user->where(array('userid'=>$this->userid))->find();
        //用户其它信息
        
        $arr['userinfo'] = $res;
        $this->return['status'] = 1;
        $this->return['info'] = '用户信息';
        $this->return['data'] = $arr;
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