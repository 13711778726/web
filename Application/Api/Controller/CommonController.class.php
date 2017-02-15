<?php
namespace Api\Controller;
use  Think\Controller;
use Think\Cache\Driver\Redis;
class CommonController extends Controller{
	protected $return = array("status"=>0, "info"=>"", "data"=>array());
    protected $redisName = 'web';
    protected $redis = null;
    protected $token = null;
    protected $userid = null;
	public function _initialize() {	
	        $this->redis = new Redis();
			self::authcode();	
	}
	public function authcode(){
	    $this->token = I('request.token','','string');
	    $this->userid = I('request.userid',0,'int');
	}
	/*检测用户*
	 */
	public function isLogin() {
	    //判断是否登录	    
		$key = $this->redisName.$this->userid;
		$token = $this->redis->get($key);
		if($token == $this->token&&$this->token!= ''){
		    //验证成功
		    $this->redis->set($key, $token, 86400 * 7);		    
		}else{
		    $this->return['info'] = '验证失败,请登录';
		    $this->ajaxReturn($this->return);
		}
		
	}
	//用户信息(主客态入口)
	public function getuserinfo(){
	    $userid = I('request.ruserid',0,'int');
	    if($userid == 0){$userid = $this->userid;}
	    $user = M('user');
	    $friend = M('friend');
	    $dynamics = M('dynamicsinfo');
	    //用户信息
	    $userinfo = $user->where(array('userid'=>$userid))->find();
	    if(!empty($userinfo['userimg'])){
	        $userinfo['userimg'] = SITE_URL.'/Public/upload/Admin/'.$userinfo['userimg'];
	    }else{
	        $userinfo['userimg'] = SITE_URL.'/Public/upload/Admin/error.png';
	    }
	    //我的好友数
	    $friendcount = $friend->where(array('userid'=>$userid))->count();
	    //我的动态数
	    $dycount = $dynamics->where(array('userid'=>$userid))->count();
	    //我的收藏数
	    $userinfo['mycolls'] = 0;
	    $userinfo['myfriendnum'] = $friendcount;
	    $userinfo['mydynum'] = $dycount;
	    return $userinfo;
	    
	}
	public function _empty(){
		header("HTTP/1.0 404 Not Found");
		$this->show('<b>404 Not Found</b>');
	}
	
}
