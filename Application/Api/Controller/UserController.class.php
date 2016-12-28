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
}