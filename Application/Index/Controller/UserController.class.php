<?php
namespace Index\Controller;
class UserController extends CommonController {
    //登录
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
    //注册
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
    //个人中心
    public function userinfo() {
        $User = M('user');
        $arr = [];
        $userinfo = $User->where(array('userid'=>$this->userid))->find();
        //收藏
        $Collection = M('collection');
        $CollCount = $Collection->where(array('userid'=>$this->userid))->count();
        $collist = $Collection
        ->field('cdb_collection.id,cdb_collection.articleid,a.title,a.img,a.desc,a.clicknum,a.collectnum')
        ->join('LEFT JOIN cdb_article a ON a.articleid=cdb_collection.articleid')
        ->where(array('userid'=>$this->userid))->select();
        //动态
        $Dynamicsinfo = M('dynamicsinfo');
        $DynCount = $Dynamicsinfo->where(array('userid'=>$this->userid))->count();
        $dynlist = $Dynamicsinfo->field('t.name,cdb_dynamicsinfo.title,cdb_dynamicsinfo.dyid')
        ->join('LEFT JOIN cdb_tag t ON t.tid=cdb_dynamicsinfo.tagid')
        ->where(array('userid'=>$this->userid))->select();
        //好友
        $Friend = M('friend');
        $Fcount = $Friend->where(array('userid'=>$this->userid))->count();
        $flist = $Friend->field('u.username,u.nickname,u.userimg,cdb_friend.userid')
        ->join('LEFT JOIN cdb_user u ON u.userid=cdb_friend.ruserid')
        ->where(array('userid'=>$this->userid))->select(); 
        $arr['userinfo'] = $userinfo;
        $arr['collcount'] = $CollCount;
        $arr['dyncount'] = $DynCount;
        $arr['fcount'] = $Fcount;
        $arr['collist'] = $collist;
        $arr['dynlist'] = $dynlist;
        $arr['flist'] = $flist;
        $this->assign('arr',$arr);
        $this->display();
    }
    //验证邮箱
    public function verify() {
        //发送邮件
        $email = '515124226@qq.com';
        $userid = 1;
        $tokenTime = time() + 3600 * 0.5;     //过期为半个小时
        $token = md5($userid . $email . $tokenTime);  //根据token验证
        $str['tokenTime'] = $tokenTime;
        $str['email'] = $email;
        $str = serialize($str);
        $this->redis->set($token, $str, 600);
        //邮件标题
        $title = '用户验证邮箱';
        //发送的邮件内容
        $content = "请点击链接验证您的帐号。<br/>" .
            "<a href='http://web.linlizhu.website/index/user/emailsuccesse?verify=" . $token . "&pid=" . $userid . "' target='_blank'>" .
            "http://web.linlizhu.website/index/user/emailsuccesse?verify=" . $token . "&pid=" . $userid . "</a>" .
            "<br/>如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问，该链接30分钟内有效。" .
            "<br/>如果此次验证请求非你本人所发，请忽略本邮件。<br/><p style='text-align:right'>-------- linlizhu@.com 敬上</p>";
        vendor('phpmailer.EmailService');
        $EmailService = new \EmailService();
        $status = $EmailService->mailerSend($email, $title, $content);
        if($status){
            $this->return['status'] = 1;
            $this->return['info'] = '邮件发送成功';
        }else{
            $this->return['info'] = '邮件发送失败';
        }
        $this->ajaxReturn($this->return);
    }
    public function emailsuccesse() {
        $User = M('user');
        $verify = I('request.verify','','string');    //token加密返回验证
        $pid = I('request.pid',0,'int');      //用户id
        $nowtime = time();
        $token = $this->redis->get($verify);
        $token = unserialize($token);
        
        $res = $User->where(array('userid'=>$pid,'email'=>$token['email']))->find();
        if($res){
            $this->return['status'] = 1;
            $this->return['info'] = '您的邮箱' . $token['email'] . '已经验证通过';
            $this->ajaxReturn($this->return);
        }else{
            if ($nowtime < $token['tokenTime']) {
                //验证通过处理
                $User->where(array('userid'=>$pid))->setField('email',$token['email']);
                $this->return['status'] = 1;
                $this->return['info'] = '您的邮箱' . $token['email'] . '验证通过';
                $this->ajaxReturn($this->return);
            } else {
                $this->return['info'] = '您的邮箱' . $token['email'] . '验证失败！链接已过期，请重新验证';
                $this->ajaxReturn($this->return);
            }
        }
    }
}