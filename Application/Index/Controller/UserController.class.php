<?php
namespace Index\Controller;
class UserController extends CommonController {
    public function login(){
        if(IS_POST){
            $User = M('user');
            $username = I('request.username','','string');
            $password = I('request.password','','string');
            $res = $User->where(array('username'=>$username,'password'=>$password))->find();
            if($res){
                session("userinfo",$res);
                $this->return['status'] = 1;
                $this->return['info'] = '登录成功';
                $this->ajaxReturn($this->return);
            }else{
                $this->return['info'] = '账号或密码错误';
                $this->ajaxReturn($this->return);
            }
        }else{
            $this->display();
        }
    }
    public function register() {
        if(IS_POST){
            $User = M('user');
            $username = I('request.username','','string');
            $nickname = I('request.nickname','','string');
            $email = I('request.email','','string');
            $password = I('request.password','','string');
            $repassword = I('request.repassword','','string');
            if(empty($username)){
                $this->return['info'] = '手机号码不能为空';
                $this->ajaxReturn($this->return);
            }
            if(empty($password)){
                $this->return['info'] = '密码不能为空';
                $this->ajaxReturn($this->return);
            }
            if($password!=$repassword){
                $this->return['info'] = '两次密码不一致';
                $this->ajaxReturn($this->return);
            }
            if(!chenkPhone($username)){
                $this->return['info'] = '手机号码格式错误';
                $this->ajaxReturn($this->return);
            }
            $data = ['username'=>$username,'password'=>$password,'email'=>$email,'nickname'=>$nickname];
            $res = $User->add($data);
            if($res){
                $userinfo = $User->where(array('userid'=>$res))->find();
                session("userinfo",$userinfo);
                $this->return['status'] = 1;
                $this->return['info'] = '注册成功';
                $this->ajaxReturn($this->return);
            }else{
                $this->return['info'] = '注册失败';
                $this->ajaxReturn($this->return);
            }
        }else{
            $this->display();
        }
    }
}