<?php
namespace Admin\Controller;
use Think\Controller;
/*
 * 后台公共调用控制器
 * @agent_info:账户登录状态信息保存
 * @session_id:账户登录id
 */
class CommonController extends Controller {
	public $admininfo = array();
	public $session_id=0;
	public $return = array("status"=>"0", "info"=>"", "data"=>array());	
	
	public function _initialize() {
		self::check_user();
	}		
	/*
	 * 检测登录状态
	 */
	public function check_user() {
		$admininfo = session("admininfo");
		if ($admininfo) {
			$data = array();
			$data['name'] = $admininfo['name'];
			$password = $admininfo['password'];
			
			$res = M("admin_user")->where($data)->find();

			if ($admininfo && $password == $res['password']) {
				session('admininfo', $res);
				
				$this->admininfo = $res;
				$this->session_id = $res['id'];
				
			}
			else {
				session("admininfo", null);
				$this->redirect('Tool/login');	
			}
		}
		else {
			session("admininfo", null);
			$this->redirect('Tool/login');	
		}
		
	}	
	public function _empty(){
		header("HTTP/1.0 404 Not Found");
		$this->show('<b>404 Not Found</b>');
	}
}
?>