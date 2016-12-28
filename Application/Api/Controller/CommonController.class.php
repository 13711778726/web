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
	    $this->redis = new Redis();
		$key = $this->redisName.$this->userid;
		$token = $this->redis->get($key);	
		if($token == $this->token){
		    //验证成功
		    $this->redis->set($key, $token, 86400 * 7);
		    $this->return['status'] = 1;			    
		}else{
		    $this->return['info'] = '验证失败';
		}
		$this->ajaxReturn($this->return);
	}
	
	public function _empty(){
		header("HTTP/1.0 404 Not Found");
		$this->show('<b>404 Not Found</b>');
	}
	
}
