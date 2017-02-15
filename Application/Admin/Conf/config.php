<?php
defined('THINK_PATH') or exit();

return array(
	//'配置项'=>'配置值'
		/* 模板相关配置 */
		'TMPL_PARSE_STRING' => array(
				'__IMG__'    => SCRIPT_DIR . '/Public/static/' . MODULE_NAME . '/img', //图片目录
				'__CSS__'    => SCRIPT_DIR . '/Public/static/' . MODULE_NAME . '/css', //CSS目录
				'__JS__'     => SCRIPT_DIR . '/Public/static/' . MODULE_NAME . '/js', //JS目录
				'__UPLOAD__' => SCRIPT_DIR . '/Public/upload/Admin/', //上传文件地址
				'__PIC__' => SCRIPT_DIR . '/Public/static/' . MODULE_NAME . '/pic' //上传文件地址
		),
        //密钥
        'AU_KEY' => 'dxun6286',
        'AGENT_ID'=>"83",
        'APPID' => 'wx742eced95f324b3d',
        'MCHID' => '1327960001',
        'KEY'   => 'ggDkkkSSHLLKJJJL45454IIIILLLLLLJ',
        'APPSECRET' => 'e6a6b00fe688c3ed29370e5193995657',

);