<?php
//检测手机号码格式是否正确
function chenkPhone($mobile) {
	if(preg_match('/^(((13[0-9]{1})|(14[0-9]{1})|(15[0-9]{1})|(17[0-9]{1})|(18[0-9]{1}))+\d{8})$/', $mobile) || preg_match('/^((0?1[358]\d{9})|((0(10|2[0-4]|[3-9]\d{2}))?[1-9]\d{6,7})|((400){1}\d{7}))$/', $mobile)){
			//验证通过
		 return true;
	}else{
		//手机号码格式不对
	     return false;
	}
}

/**

* 判断管理员对某一个操作是否有权限。

*

* 根据当前对应的action_code，然后再和用户session里面的action_list做匹配，以此来决定是否可以继续执行。

* @param     string    $priv_str    操作对应的priv_str

* @param     string    $msg_type       返回的类型

* @return true/false

*/
//备注（可用函数）@lizhu
function admin_priv($priv_str, $msg_type = '' , $msg_output = true,$priv='')

{
    if(empty($priv)){
        $action_list = session('acctinfo.priv_action');
    }else{
        $action_list=$priv;
    }
    if ($action_list == 'all')
    {
        return true;
    }

    if (strpos(',' . $action_list . ',', ',' . $priv_str . ',') === false)
    {

        if ( $msg_output)
        {
            //showMessage("您没有权限");
        }

        return false;

    }
    else
    {
        return true;
    }
}
/*
 * 获得商家下级商家列表
 */
function getlist_agents_child( $acct_id, $n = -1 )
{
    static $sort_array = array();
    $mode=session('acctinfo.mode');
    $acctDb = M("merchant");
    $res = $acctDb->field('id, mer_name')->where("agent_id=".$acct_id)->where(array('cancel'=>1))->select();
    ++$n;
    foreach ($res as $key=>$val) {
        $val['mer_name'] = str_repeat('&nbsp;', 4*$n) . $val['mer_name'];
        $val['decode_id'] = base64_encode($val['id']);

        $sort_array[] = $val;
        $acct_id = $val['id'];
        //如果是管理员则显示全部下级否则只显示当前下一级
        if($mode==0){
            getlist_agents_child($acct_id, $n);
        }      
    }
    return $sort_array;
}
/*
 * 检查商家是否是当前下级商家
 */
function is_childs($child_acct_id, $curr_acct_id="") {

    if (empty($curr_acct_id)) {
        $curr_acct_id = session('acctinfo.id');
    }

    if ($curr_acct_id == $child_acct_id) {
        return true;
    }

    $childids = get_agent_childids($curr_acct_id);

    return in_array($child_acct_id, $childids);
}
/*
 * 获得下级商家id列表
 */
function get_agent_childids($curr_acct_id) {
    static $childids = array();
    $acctDb  = M("merchant");

    $res = $acctDb->field('id')->where('agent_id='.$curr_acct_id)->where(array('cancel'=>1))->select();

    foreach ($res as $key=>$val){
        $childids[] = $val['id'];
        $curr_acct_id = $val['id'];

        get_agent_childids($curr_acct_id);
    }

    return $childids;
}
function get_childs_new($agent_id, $resarr = array()) {
    $acctDb  = M("merchant");
    $mode=session('acctinfo.mode');
    $res = $acctDb->field('id')->where('agent_id='.$agent_id)->where(array('cancel'=>1))->select();

    $resarr = array_merge($resarr, $res);
    //如果是管理员则显示全部下级否则只显示当前下一级
//     if($mode==0){
        foreach ($res as $key=>$value) {
            $resarr = get_childs_new($value['id'], $resarr);
        }
//     }   
    return $resarr;
}
/*只显示下级*/

function get_mer_childs($agent_id){
    $acctDb  = M("merchant");
    $arr=array();
    $res=$acctDb->field('id')->where(array('agent_id'=>$agent_id))->select();
    foreach ($res as $key=>$val) {   
        $arr[] = $val['id'];
    }
    return $arr;
}
/*
 * 获得当前账户顶级账户信息
 * 下级代理用户注册全部注册在顶级商家下面
 */
function get_top_agent_info($agent_id) {
    $acctDb = M("merchant");

    $agent_id = intval($agent_id);

    if ($agent_id == 1 || $agent_id == 0) {
        return array('agent_id'=>$agent_id);
    }
    for($i=0; $i<10; $i++){

        $res = $acctDb->field('id, agent_id, mer_name')->where('id='.$agent_id)->where(array('cancel'=>1))->find();

        if ($res['agent_id'] == 1 || empty($res['agent_id'])) {
            return $res;
        }
        else {
            $agent_id = $res['agent_id'];
        }

    }
}
/*
 * 判断商家余额
 * card_type   1话费卡   2流量卡  3打电话
 * 话费卡检测当前代理余额，流量卡根据折扣判断当前及其上级余额，打电话判断流量模式余额是否充足
 */
function judgeintegral($agent_id,$integral, $card_type){
    $acctDb  = M("merchant");
    $res=$acctDb->field('id,agent_id,integral,modle_rank,vip_rank,mer_name,mode, rate')->where(array('id'=>$agent_id,'mode'=>1))->find();
    if($res){
        //话费卡检测
        if ($card_type == 1) {
            if ($res['integral'] < $integral ) {
                return false;
            }
            else {
                return true;
            }
        }
        
        //话费卡，根据折扣判断
        elseif ($card_type == 2) {
            $expend_balance = $integral*$res['modle_rank']*0.01;
             
            if (($res['integral'] < $expend_balance) && ($res['id'] != 1)) {
                return $res['mer_name'].'余额不足扣除当前费用';
                exit;
            }
             
            judgeintegral($res['agent_id'],$integral, $card_type);
             
            return true;
             
        }
        
        else {
            if (($res['integral'] <= 0) && ($res['id'] != 1)) {
                return $res['mer_name'].'余额不足扣除当前费用';
                exit;
            }
             
            judgeintegral($res['agent_id'],$integral, $card_type);
             
            return true;
        }
    }else{
        return false;
        exit;
    }
    
    

//     if($res){
//         $rank=$res['modle_rank']*0.01;
//         if(($res['integral']<$rank*$integral)||($res['integral']==0)){
//             return $res['mer_name'].'余额不足扣除当前费用';
//             exit;
//         }        
//         judgeintegral($res['agent_id'],$integral);
//     }
//     return 1;
}
/*
 * 消费扣除商家余额
 * 1.账户充值，2.用户充值，3.用户提现(话费、流量)
 */
function merchant_expend($trade_type, $agent_id, $balance, $mark) {
    
	$acctDb  = M("merchant");
	$res=$acctDb->field('id,agent_id,integral,modle_rank,vip_rank,mer_name,mode')->where(array('id'=>$agent_id,'mode'=>1))->find();
	if($res){
		$rank=$res['modle_rank']*0.01;
		
		$expend_balance = $balance*$rank;
		
		if ($balance > 0) {
			//扣除金额
			$acctDb->where(array("id"=>$agent_id))->setDec('integral', $expend_balance);
		}
		else {
			//扣除金额
			$acctDb->where(array("id"=>$agent_id))->setInc('integral', $expend_balance);
		}
		
		merasset($trade_type,-$expend_balance,$res['integral'],$res['integral']-$expend_balance,$mark,$res['id']);
		
		
		
		merchant_expend($trade_type,$res['agent_id'], $balance, $mark);
	}

	return true;
}

/*
 * 代理商级别差价
 */
/* function agent_rank($agent_id,$integral,$trade_type,$msg=''){
    $merchant=M('merchant');
    //获取当前代理商信息
    $res=$merchant->field('id,agent_id,integral,modle_rank,vip_rank,mode,mer_name')->where(array('id'=>$agent_id,'mode'=>1))->find();
    if($res){
        $rank=$res['modle_rank']*0.01;
        $acctintegral=$res['integral']-$rank*$integral;
        $merchant->where(array('id'=>$res['id']))->setField('integral',$acctintegral);
        $mark=$msg.'扣除'.$res['mer_name'].'差价比列为'.$rank.'总金额'.$rank*$integral;
        merasset($trade_type,-$rank*$integral,$res['integral'],$res['integral']-$rank*$integral,$mark,$res['id']);
        agent_rank($res['agent_id'],$integral,$trade_type,$msg);
    }else{
        return 0;
    }
    return 1;
} */
/*操作日志记录*/
function merlog($mark,$type,$acctname="") {
    if (empty($acctname)) {
        $data['agent_id'] = session("acctinfo.id");
        $data['acctname'] = session("acctinfo.mer_name");
    }
    $data['createtime'] = time();
    $data['clientip'] = get_client_ip();
    $data['logtext'] = $mark;
    
    $content = file_get_contents("http://api.map.baidu.com/location/ip?ak=7IZ6fgGEGohCrRKUE9Rj4TSQ&ip={$data[clientip]}&coor=bd09ll");
    $json = json_decode($content);
    
    $data['area'] =  $json->{'content'}->{'address'};//按层级关系提取address数据
    
    if (empty($data['area'])) {
    	$data['area'] = "";
    }
       
    $data['mark'] = $mark;
    $data['type'] = $type;    
    $merlog = M("merlog");
    $result = $merlog->add($data);
    return $result;
}
/*账户明细记录*/
/*
 * 1.账户充值，2.用户充值，3.用户提现(话费、流量)
 */
function merasset($trade_type,$trade_balance,$trade_before,$trade_after,$mark,$agent_id) {
    if($agent_id){
        $data['agent_id'] = $agent_id;
    }else{
        $data['agent_id'] = session("acctinfo.id");  
    }      
    $data['trade_time'] = time();
    $data['trade_type'] = $trade_type;
    $data['trade_balance'] = $trade_balance;
    $data['trade_before'] = $trade_before;
    $data['trade_after'] = $trade_after;
    $data['mark'] = $mark;
    $merasset = M("merasset");
    $result = $merasset->add($data);
    return $result;
}
/*用户账单记录*/
/*
 * 1.话费 2.流量3.余额
 */
function usercheck($trade_type,$trade_balance,$trade_before,$trade_after,$hander,$mark,$agent_id,$username){
    if($agent_id){
        $data['agent_id'] = $agent_id;
    }else{
        $data['agent_id'] = session("acctinfo.id");  
    }     
    $data['trade_time'] = time();
    $data['trade_type'] = $trade_type;
    $data['trade_balance'] = $trade_balance;
    $data['trade_before'] = $trade_before;
    $data['trade_after'] = $trade_after;
    $data['mark'] = $mark;
    $data['hander'] = $hander;
    $data['username'] = $username;
    $usercheck = M("usercheck");
    $result = $usercheck->add($data);
    return $result;
}
/*用户提现记录*/
function userdraw($username,$balance,$draw_area,$draw_type,$status,$agent_id,$hander='',$id_num=0){
    if($agent_id){
        $data['agent_id'] = $agent_id;
    }else{
        $data['agent_id'] = session("acctinfo.id");
    }
    if($hander==''){
        $data['hander']=$username;
    }else{
        $data['hander']=$hander;
    }
    $data['draw_time'] = time();
    $data['username'] = $username;
    $data['balance'] = $balance;
    $data['draw_area'] = $draw_area;
    $data['draw_type'] = $draw_type;
    $data['status'] = $status;
    $data['s_id'] = $id_num;
    $userdraw = M("userdraw");
    $result = $userdraw->add($data);
    return $result;
}
/*
 * 销售记录
 * */
function record($agent_id,$username,$goodname,$good_id,$marketprice,$good_type,$mark,$status,$balance,$record_id,$cz_phone){
    $merchant=M('merchant');
    $res=$merchant->field('id,agent_id,integral,modle_rank,vip_rank,mode,mer_name')->where(array('id'=>$agent_id,'mode'=>1))->find();
    if($res){
        $rank=$res['modle_rank']*0.01;
        $data['sale_time']=time();
        $data['agent_id']=$agent_id;
        $data['username']=$username;
        $data['goodname']=$goodname;
        $data['marketprice']=$marketprice;
        $data['goodsprice']=$rank*$marketprice;
        $data['good_type']=$good_type;
        $data['good_id']=$good_id;
        $data['mark']=$mark;
        $data['status']=$status;
        $data['balance']=$balance;
        $data['record_id']=$record_id;
        $data['cz_phone']=$cz_phone;
        $salerecord = M("salerecord");
        
        $result = $salerecord->add($data);
        //保存订单号
        $order_no = $good_type . date("Y-m-d") . $record_id;
        
        $salerecord->where(array('id'=>$result))->save(array("order_no"=>$order_no));
        record($res['agent_id'],$username,$goodname,$good_id,$marketprice,$good_type,$mark,$status,$balance,$record_id,$cz_phone);
    }else{
        return 0;
    } 
    return $order_no;
    
    //保存订单号
    /* $order_no = $good_type . date("Y-m-d") . $result;
    
    $salerecord->where(array('id'=>$result))->save(array("order_no"=>$order_no));
    
    return $order_no; */
}
/*
 * 生成密码
 */
function create_pwd() {
    $str = "1234567890";
    $len = strlen( $str ) - 1;

    for ($j = 0; $j < 6; ++$j)
    {
        $num = mt_rand( 0, $len );
        $randString .= $str[$num];
    }

    return $randString;
}
/**
 * TODO 上传文件方法
 * @param $fileid form表单file的name值
 * @param $dir 上传到uploads目录的$dir文件夹里
 * @param int $maxsize 最大上传限制，默认1024000 byte
 * @param array $exts 允许上传文件类型 默认array('gif','jpg','jpeg','bmp','png')
 * @return array 返回array,失败status=0 成功status=1,filepath=newspost/2014-9-9/a.jpg
 */
function uploadfile($fileid,$dir,$maxsize=5242880,$exts=array('gif','jpg','jpeg','bmp','png'),$maxwidth=430){
    $upload = new \Think\Upload();// 实例化上传类
    $upload->maxSize   =     $maxsize;// 设置附件上传大小，单位字节(微信图片限制1M
    $upload->exts      =     $exts;// 设置附件上传类型
    $upload->rootPath  =     UPLOAD_PATH .'/Excel/'; // 设置附件上传根目录
    $upload->savePath  =     UPLOAD_PATH.'Excel/'; // 设置附件上传根目录
    // 上传文件
    $info   =   $upload->upload();

    if(!$info) {// 上传错误提示错误信息
        return array(status=>0,msg=>$upload->getError());
    }else{// 上传成功
        return array(status=>1,msg=>'上传成功',filepath=>$info[$fileid][0]['savename']);
    }
}
//上传单张图片
function  upload($file, $width="480px", $height="800px") {
    $upload = new \Think\Upload();// 实例化上传类;
    $upload->maxSize = 2097152; //2M

    $upload->autoSub  = true;
    $upload->saveRule = uniqid;
    $upload->subType  = date;
    $upload->thumbMaxWidth = $width;
    $upload->thumbMaxHeight = $height;
    $upload->thumbPath = UPLOAD_PATH .'/Admin/';
    $upload->thumbRemoveOrigin = true;

    //缩略图处理
    $upload->thumb = true;
    $upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');
    $upload->savePath =  UPLOAD_PATH .'/Admin/';
    //$res = $upload->uploadOne($file);
    //print_r($_FILES);echo "<br />";
    $res = $upload->upload();
    //var_dump($res);exit;
    if ($res === false) {
    } else {
        return $res;
    }
}
/*
 * 中文字符串截取
 */

function mb_zw_string($string, $len='60', $encode='utf-8'){
    if (mb_strlen($string, 'utf-8') > $len) {
        $string = mb_substr($string, 0, $len, 'utf-8');

        $string = $string  . '...';
    }

    return $string;
}
/*
 * 硬回拨web键值保持
 */
function callback_key($key, $username, $callee, $agent_id, $type, $user_id) {
	$tableName = 'record' . date('Ym');
	
	$data['key'] = $key;
	$data['username'] = $username;
	$data['callee'] = $callee;
	$data['agent_id'] = $agent_id;
	$data['callid'] = time();
	$data['type'] = $type;
	$data['user_id'] = $user_id;
	
	$callrecordDb = M($tableName);
	$return = $callrecordDb->add($data);
	
	
	return $return;
}

//呼叫失败，记录话单
function callback_fail($agent_id, $username, $callee, $msg, $user_id) {
	$tableName = 'record' . date('Ym');
	
	$data['username'] = $username;
	$data['callee'] = $callee;
	$data['agent_id'] = $agent_id;
	
	$time = time();
	
	$data['callid'] = $time;
	$data['starttime'] = $time;
	$data['endtime'] = $time;
	$data['second'] = 0;
	$data['endReason'] = $msg;
	$data['type'] = 1;
	$data['user_id'] = $user_id;
	
	$callrecordDb = M($tableName);
	$return = $callrecordDb->add($data);
}

//生成二维码
function getcode($url, $info = array())
{
	// 纠错级别：L、M、Q、H
	$errorCorrectionLevel = 'Q';
	// 点的大小：1到10
	$matrixPointSize = 5;
	// 生成的文件名
	$tmp = UPLOAD_PATH .'qrcode/';
	if(!is_dir($tmp)){
		@mkdir($tmp);
	}

	$filename = $tmp . $errorCorrectionLevel . $matrixPointSize . $info['id'].'.png';

    if (!file_exists($filename)) {
		vendor("phpqrcode");
		\QRcode::png($url, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
    }
    
    $filename = SITE_URL . $filename;

	return $filename;
}

// $string： 明文 或 密文
// $operation：DECODE表示解密,其它表示加密
// $key： 密匙
// $expiry：密文有效期
function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
	// 动态密匙长度，相同的明文会生成不同密文就是依靠动态密匙
	$ckey_length = 4;

	// 密匙
	$key = md5($key ? $key : C('AU_KEY'));

	// 密匙a会参与加解密
	$keya = md5(substr($key, 0, 16));
	// 密匙b会用来做数据完整性验证
	$keyb = md5(substr($key, 16, 16));
	// 密匙c用于变化生成的密文
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
	// 参与运算的密匙
	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);
	// 明文，前10位用来保存时间戳，解密时验证数据有效性，10到26位用来保存$keyb(密匙b)，解密时会通过这个密匙验证数据完整性
	// 如果是解码的话，会从第$ckey_length位开始，因为密文前$ckey_length位保存 动态密匙，以保证解密正确
	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);
	$result = '';
	$box = range(0, 255);
	$rndkey = array();
	// 产生密匙簿
	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}
	// 用固定的算法，打乱密匙簿，增加随机性，好像很复杂，实际上对并不会增加密文的强度
	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}
	// 核心加解密部分
	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		// 从密匙簿得出密匙进行异或，再转成字符
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}

	if($operation == 'DECODE') {
		// substr($result, 0, 10) == 0 验证数据有效性
		// substr($result, 0, 10) - time() > 0 验证数据有效性
		// substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16) 验证数据完整性
		// 验证数据有效性，请看未加密明文的格式
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
			return substr($result, 26);
		} else {
			return '';
		}
	} else {
		// 把动态密匙保存在密文里，这也是为什么同样的明文，生产不同密文后能解密的原因
		// 因为加密后的密文可能是一些特殊字符，复制过程可能会丢失，所以用base64编码
		return $keyc.str_replace('=', '', base64_encode($result));
	}
}



//打电话
function callback($agentInfo,  $userInfo) {
	$time = time();

	$res = callback_vx($agentInfo, $userInfo);


	return $res;
}

//vx接口呼叫
function callback_vx($agentInfo, $userInfo) {
	$return = array("status"=>0, "info"=>"");

	//检查呼叫是否超过限制
	$tableName = 'record' . date('Ym');

	$sql = "SHOW TABLES LIKE '" . $tableName . "'";
	$createDb = M();
	$res = $createDb->query($sql);

	if (empty($res)) {
		$sql = "CREATE TABLE `".$tableName."`(
				`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
				`agent_id` INT UNSIGNED NOT NULL DEFAULT 0,
				`user_id` INT UNSIGNED NOT NULL DEFAULT 0,
				`username` BIGINT UNSIGNED NOT NULL DEFAULT 0,
				`callee`  BIGINT UNSIGNED NOT NULL DEFAULT 0,
				`starttime` INT UNSIGNED NOT NULL DEFAULT 0,
				`endtime`  INT UNSIGNED NOT NULL DEFAULT 0,
				`second`  INT  NOT NULL DEFAULT 0,
				`key` 	VARCHAR(64) NOT NULL DEFAULT 0,
				`callid` INT UNSIGNED NOT NULL DEFAULT 0,
				`type` TINYINT UNSIGNED NOT NULL DEFAULT 0,
				 `endReason` VARCHAR(32) NOT NULL DEFAULT '',
				PRIMARY KEY(`id`),
				KEY(`agent_id`),
				KEY(`username`),
				KEY(`callee`),
				KEY(`starttime`),
				KEY(`key`),
				KEY(`callid`),
				KEY(`type`)
				)ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
		$res = $createDb->execute($sql);
	}

	$recordDb = M($tableName);

	$server = A('Server/Vxcall');
	//如果用户有效期过期则限制
	if($userInfo['expiredate']<=time()){
	    $return['info']='话费有效期已过期';
	    return $return;
	}
	$res = $server->webcall($userInfo['username'], $userInfo['callee'], 60, $userInfo['agent_id']);

	if ($res['status'] == 1) {
		$key = $res['data']['callid'];
		callback_key($key, $userInfo['username'], $userInfo['callee'], $userInfo['agent_id'],1, $userInfo['id']);

		$return['status'] = 1;
		$return['info'] = "呼叫成功";

		return $return;

	}
	else {
		if (empty($res['info'])) {
			$res['info'] = "接口Error";
		}
		
		callback_fail($userInfo['agent_id'], $userInfo['username'], $userInfo['callee'], $res['info'], $userInfo['id']);
		$return['info'] = $res['info'];
		return $return;

	}
}

//发送手机验证码
function send_sms($data) {
	$return = array("status"=>0, "info"=>"");
	
	$codeinfo=M('code');
	$resul=$codeinfo->where(array('username'=>$data['username'],'agent_id'=>$data['agent_id']))->find();
	
	//发送验证码时间不能小于60秒
	$time = time();
	$send_time = $time-60;
	//检查验证码是否发送
	$count = $codeinfo->where($data)->where(array('send_time'=>array('gt', $send_time)))->count();
	
	if ($count) {
		$return['info'] = "验证码已发送";
	
		return $return;
	}
	
	$send_time = $time - 24*3600;
	
	$count = $codeinfo->where($data)->where(array('send_time'=>array('gt', $send_time)))->count();
	
	//验证码24小时内最多发送十条
	if ($count >= 10) {
		$return['info'] = "今日验证码发送次数过多";
	
		return $return;
	}
	
	//发送时间
	$data['send_time'] = $time;
	
	//验证码
	$code=rand(100000,999999);
	$data['code']=$code;
	list($s1, $s2) = explode('SSS', microtime());
	$time=date("YmdHis",time()).intval(floatval($s1) + floatval($s2) * 1000);
	$sid='7a2268b1f0ab3f07ec7f7ca97428d659';
	//$appId='269c102c9a3a4af6bca8556e0e0747d0';
	$sign=md5('7a2268b1f0ab3f07ec7f7ca97428d659'.$time.'a1b02501c0175e9a9116663cbd722692');
	
	//获取短信配置信息
	$app_relate_db  = M("app_relate");
		
	$app_relate_info = $app_relate_db->where(array("agent_id"=>$data['agent_id']))->find();
		
	if (empty($app_relate_info['smsappid']) || empty($app_relate_info['smstemplateid'])) {
		$return['info'] = "短信未配置";
		return $return;
	}
		
	$appId = $app_relate_info['smsappid'];
	$templateId = $app_relate_info['smstemplateid'];
		
	$url="http://www.ucpaas.com/maap/sms/code?sid=".$sid."&appId=".$appId."&time=".$time."&sign=".$sign."&to=".$data['username']."&templateId=" .$templateId . "&param=".$code.",30";
	$data1=array();
	$res=curl_post($url,$data1);
	if($res['resp']['respCode']=='000000'){
		$return['status']=1;
		$return['info'] = "验证码成功发送到您的手机，请注意查收！";
			
		$codeinfo->add($data);
			
		return $return;
	}else{
		$return['info'] = "发送失败，请稍后再试";
		return $return;
	}
}
//post请求
function curl_post($uri, $data) {
	$ch = curl_init ();
	curl_setopt ( $ch, CURLOPT_URL, $uri );
	//curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER,FALSE);
	curl_setopt ( $ch, CURLOPT_POST, 1 );
	curl_setopt ( $ch, CURLOPT_HEADER, 0 );
	curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
	$responseData = curl_exec ( $ch );
	curl_close ( $ch );
	return json_decode($responseData,true);
	//return $responseData;
}

//用户注册
function user_reg($data) {
	$return = array("status"=>0, "info"=>"","data"=>array());
	
	$userDb = M("users");

	$data['enable'] = 1;
	$data['createtime'] = time();
	
	//获得手机所属区号
	$mobileDb = M("mobilecode");
	
	$partcode = substr($data['username'], 0, 7);
	
	$code_info = $mobileDb->field('cityname, telname')->where(array('partcode'=>$partcode))->find();
	
	if ($code_info) {
		$data['attribution'] = $code_info['cityname'] . $code_info['telname'];
	}
		
	$res = $userDb->add($data);
		
	if ($res) {	
		//判断是否开过红包
		$encode_info = session('encode_info');
	
		if (empty($encode_info)) {
			$encode_info = 	cookie($data['agent_id'] . 'encode_info');
		}
	
		if ($encode_info) {
			$encode_info = authcode($encode_info, 'DECODE');
				
			$encode_info = unserialize($encode_info);
				
			//存在中奖纪录
			if ($encode_info) {
				$redpackDb = M( "redpack");
	
				$count = $redpackDb->where(array("id"=>$encode_info['id'], 'type'=>$encode_info['type'], 'balance'=>$encode_info['balance']))->count();
	
				//确认中奖纪录
				if ($count) {
					//赠送的是话费
					if ($encode_info['type'] == 1) {
						$res = $userDb->where(array('agent_id'=>$data['agent_id'], 'username'=>$data['username']))->setInc('minute', $encode_info['balance']);
							
						if ($res) {
								
							$curr_user_info = $userDb->field('minute')->where(array('agent_id'=>$data['agent_id'], 'username'=>$data['username']))->find();
								
							//记录赠送记录
							$recordDb = M("usercheck");
								
							$save_date = array();
								
							$save_date['agent_id'] = $data['agent_id'];
							$save_date['username'] = $data['username'];
							$save_date['trade_type'] = 1;
							$save_date['trade_balance'] = $encode_info['balance'];
							$save_date['trade_time'] = $encode_info['time'];
							$save_date['hander'] = $data['username'];
							$save_date['trade_before'] = 0;
							$save_date['trade_after'] = $curr_user_info['minute'];
							$save_date['mark'] = "领取红包";
	
							$recordDb->add($save_date);
	
						}
					}
					//赠送的是流量
					elseif ($encode_info['type'] == 2) {
						$res = $userDb->where(array('agent_id'=>$data['agent_id'], 'username'=>$data['username']))->setInc('flow', $encode_info['balance']);
							
						if ($res) {
	
							$curr_user_info = $userDb->field('flow')->where(array('agent_id'=>$data['agent_id'], 'username'=>$data['username']))->find();
	
							//记录赠送记录
							$recordDb = M("usercheck");
	
							$save_date = array();
	
							$save_date['agent_id'] = $data['agent_id'];
							$save_date['username'] = $data['username'];
							$save_date['trade_type'] = 2;
							$save_date['trade_balance'] = $encode_info['balance'];
							$save_date['trade_time'] = $encode_info['time'];
							$save_date['hander'] = $data['username'];
							$save_date['trade_before'] = 0;
							$save_date['trade_after'] = $curr_user_info['flow'];
							$save_date['mark'] = "领取红包";
	
							$recordDb->add($save_date);
						}
					}
						
					cookie($data['agent_id'] . 'encode_info', null);
					session('encode_info', null);
				}
			}
		}
	
		$return['status'] = 1;
		$return['info'] = "注册成功";
		$return['data'] = $userDb->where(array('agent_id'=>$data['agent_id'], 'username'=>$data['username']))->find();
		
		return $return;
	
	}
	else {
		$return['info'] = "注册失败，请稍后再试";
		
		return $return;
	}
}


/**
 * 分页的信息加入条件的数组
 *
 * @access  public
 * @return  array
 */
function page_and_size($filter)
{
	if (isset($_REQUEST['rows']) && intval($_REQUEST['rows']) > 0)
	{
		$filter['rows'] = intval($_REQUEST['rows']);
		cookie('POO[rows]', $filter['rows']);
	}
	elseif (isset($_COOKIE['POO']['rows']) && intval($_COOKIE['POO']['rows']) > 0)
	{
		$filter['rows'] = intval($_COOKIE['POO']['rows']);
	}
	else
	{
		$filter['rows'] = 15;
	}
	
	/* 当前页 */
	$filter['page'] = (empty($_REQUEST['page']) || intval($_REQUEST['page']) <= 0) ? 1 : intval($_REQUEST['page']);

	/* page 总数 */
	$filter['count'] = (!empty($filter['record_count']) && $filter['record_count'] > 0) ? ceil($filter['record_count'] / $filter['rows']) : 1;

	/* 边界处理 */
	if ($filter['page'] > $filter['count'])
	{
		$filter['page'] = $filter['count'];
	}
	
	//上一页
	$filter['prev'] = $filter['page'] -1;
	
	//下一页
	$filter['next'] = $filter['page'] +1;
	
	$filter['prev'] = ($filter['prev'] > 0) ? $filter['prev'] : 1;
	$filter['prev'] = ($filter['prev'] > $filter['count']) ? $filter['count'] : $filter['prev'];
	
	//便捷翻页数量
	
	if (empty($filter['esay_num'])) {
		$filter['quick_num'] = 5;
	}
	
	//总页数小于快捷分页数量或当前页在开始页
	if (($filter['quick_num'] >= $filter['count']) ||($filter['page'] <= ceil($filter['quick_num']/2))) {
		$filter['quick_start'] = 1;
		$filter['quick_end'] = $filter['quick_num'];		
	}
	//当前页在末尾页
	elseif ($filter['page'] >= $filter['count']-floor($filter['quick_num']/2)) {
		$filter['quick_start'] = $filter['count']-$filter['quick_num'] +1;
		$filter['quick_end'] = $filter['count'];
	}
	//当前页在中间
	else {
		$filter['quick_start'] = $filter['page']-(ceil($filter['quick_num']/2) -1);
		$filter['quick_end'] = $filter['page']+(floor($filter['quick_num']/2));	
	}
	
	//边界处理
	$filter['quick_start'] = ($filter['quick_start'] <= 0) ? 1 : $filter['quick_start'];
	$filter['quick_end'] = ($filter['quick_end'] >= $filter['count']) ? $filter['count'] : $filter['quick_end'];
	
	//存为数组
	$filter['quick_arr'] = array();
	for ($i = $filter['quick_start']; $i <=$filter['quick_end']; $i++ ) {
		$filter['quick_arr'][$i]['num'] = $i;
		
		//标记当前页
		if ($i == $filter['page']) {
			$filter['quick_arr'][$i]['sel'] = 1;
		}
		else {
			$filter['quick_arr'][$i]['sel'] = 0;
		}
	}
	

	return $filter;
}
/**
 * 拼手气红包实现
 * 生成num个随机数，每个随机数占随机数总和的比例*money_total的值即为每个红包的钱额
 * 考虑到精度问题，最后重置最大的那个红包的钱额为money_total-其他红包的总额
 * 浮点数比较大小,使用number_format,精确到2位小数
 *
 * @param double $money_total  总钱额， 每人最少0.01,精确到2位小数
 * @param int $num 发送给几个人
 * @return array num个元素的一维数组，值是随机钱额
 */
function sendHB($money_total, $num) {
	
	//每个用户至少令一分钱
    if($money_total < $num*0.01) {
        return 0;
    }

    $rand_arr = array();
    for($i=0; $i<$num; $i++) {
        $rand = rand(1, 100);
        $rand_arr[] = $rand;
    }

    $rand_sum = array_sum($rand_arr);
    $rand_money_arr = array();
    $rand_money_arr = array_pad($rand_money_arr, $num, 0.01);  //保证每个红包至少0.01

    foreach ($rand_arr as $key => $r) {
        $rand_money = round($money_total*$r/$rand_sum, 2);

        if($rand_money <= 0.01 || round(array_sum($rand_money_arr), 2) >= round($money_total, 2)) {
            $rand_money_arr[$key] = 0.01;
        } else {
            $rand_money_arr[$key] = $rand_money;
        }

    }

    $max_index = $max_rand = 0;
    foreach ($rand_money_arr as $key => $rm) {
        if($rm > $max_rand) {
            $max_rand = $rm;
            $max_index = $key;
        }
    }

    unset($rand_money_arr[$max_index]);
    //这里的array_sum($rand_money_arr)一定是小于$money_total的
    $rand_money_arr[$max_index] = round($money_total - array_sum($rand_money_arr), 2);

    ksort($rand_money_arr);
    return $rand_money_arr;
}

/*
 * 用户账户变动
 * type 0礼品  1话费   2流量
 * gift_type 礼品类型
 */
function user_account_change($agent_id, $user_id,  $balance, $gift_type, $handle, $mark) {
    $my_giftDb = M("my_gife_amount");
    $userDb=M('users');
    $start_balance = $my_giftDb->where(array("agent_id"=>$agent_id, "user_id"=>$user_id, "gife_id"=>$gift_type))->getField('balance');
    if($gift_type==0){
        //weixinhuafei
        $user_account=$userDb->where(array('agent_id'=>$agent_id,'id'=>$user_id))->getField('wx_balance');
        if($user_account==0){
            $start_balance = 0;
            $curr_balance = $balance;
            $userDb->where(array('agent_id'=>$agent_id,'id'=>$user_id))->setField("wx_balance", $curr_balance);
        }else{
            $start_balance= $user_account;
            $curr_balance = $user_account+$balance;
            $userDb->where(array('agent_id'=>$agent_id,'id'=>$user_id))->setField("wx_balance", $curr_balance);
        }
    }else{
        if (empty($start_balance)) {
            $start_balance = 0;
            $curr_balance = $balance;
            $order = date('Ymd',time());
            $order_sn = date('Ymd',time()) . rand(1,10000);
            $my_giftDb->add(array("agent_id"=>$agent_id, "user_id"=>$user_id, "gife_id"=>$gift_type, "balance"=>$curr_balance, "order_sn"=>$order_sn));
        
        }
        else {
            $curr_balance = $start_balance+$balance;
             
            $my_giftDb->where(array("agent_id"=>$agent_id, "user_id"=>$user_id, "gife_id"=>$gift_type))->setField("balance", $curr_balance);
        
        }
    } 	
	//记录赠送记录
	$recordDb = M("usercheck");
		
	$save_date = array();
	$time = time();
	$save_date['agent_id'] = $agent_id;
	$save_date['username'] = $user_id;
	$save_date['trade_type'] = $gift_type;
	$save_date['trade_balance'] = $balance;
	$save_date['trade_time'] = $time;
	$save_date['hander'] = $handle;
	$save_date['trade_before'] = $start_balance;
	$save_date['trade_after'] = $curr_balance;
	$save_date['mark'] = $mark;
	
	$recordDb->add($save_date);
	
	return true;
}
//获取用户礼品函数
function get_user_gift($user_id,$agent_id){
    $arr=array();
    $gifeDb=M('gife');
    $my_gife_amountDb=M('my_gife_amount');
    $list=$my_gife_amountDb
    ->field('my_gife_amount.balance,g.if_delete,g.gifename,g.gife_unit,g.id')
    ->join('LEFT JOIN gife g ON g.id=my_gife_amount.gife_id')
    ->where(array('my_gife_amount.agent_id'=>$agent_id,'my_gife_amount.user_id'=>$user_id,'is_out'=>1))->select();
    foreach ($list as $key=>$val){
        if($val['gifename']){
            if(($val['if_delete']!=1)&&$val['if_delete']!=2){
                $list[$key]['balance']=intval($val['balance']);
            }
        }else{
            //礼品已经下架
            unset($list[$key]);
        }
    }
    return $list;
}
//获取用户信息
function get_userinfo($user_id){
    $userDb=M('users');
    $userinfo=$userDb->field('id,username,attribution,openid,nick')->where(array('id'=>$user_id))->find();
    if (file_exists('./Public/upload/Home/user_pic/' . $userinfo['openid'] . ".png")) {
        $userinfo['user_pic'] = '/Public/upload/Home/user_pic/' . $userinfo['openid'] . ".png";
    }
    else {
        $userinfo['user_pic'] = SCRIPT_DIR."/Public/upload/Home/user_pic.jpg";
    }
    return $userinfo;
}
?>