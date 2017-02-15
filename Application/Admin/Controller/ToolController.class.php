<?php
namespace Admin\Controller;
use Org\Util\ValidateCode;
use  Think\Controller;
class ToolController extends Controller {
	/*
	 * 登录(账户登陆)
	 */
	public function login($info = array()) {
	            if(IS_POST){
	                    $return=array('status'=>0,'info'=>'','data'=>array());
	                    $AdminUser = M('admin_user');
	                    $data['name'] = I('post.username');
	                    $password = I('post.password');
	                    if (empty($data['name']) || empty($password)) {
	                        $return['status'] = 0;
	                        $return['info']='用户名或密码错误';
	                        $this->ajaxReturn($return);
	                    }
	                    $admininfo = $AdminUser->where($data)->find();
	                    $data['password'] = authcode($admininfo['password'], "DECODE");
	                    if ($admininfo && ($password == $data['password'])) {
	                        session('admininfo', $admininfo);
	                        $return['status']=1;
	                        $return['info']='用户登陆成功';
	                        logData($admininfo['id'], '<'.$admininfo['name'].'>登录');
	                        $this->ajaxReturn($return);	                       
	                    }
	                    else {
	                        $return['status']=0;
	                        $return['info']='账户或密码错误';
	                        $this->ajaxReturn($return);	              
	                    }
	            }else{
	                $this->display();
	            }	              
	}	
	/*
	 * 登出
	 */
	public  function logout() {
		session('user_info', null);
		$this->redirect('Tool/login');			
	}	
	/*
	 * 图片验证码
	 */
	public	function validateCode(){
		$_vc = new ValidateCode();  //实例化一个对象        
		$_vc->doimg(); 
		session("validate", $_vc->getCode());	
	}
}

?>