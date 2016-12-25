<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>易企发     小应用 、大智慧，低价格、真实用！</title>
    <link rel="stylesheet" type="text/css" href="/web/Public/static/Home3/css/anonymous.css" />
    <link rel="stylesheet" type="text/css" href="/web/Public/static/Home3/css/login.css" />
</head>
<body>
    <div class="yenei"> 
            <div class="main">
                <img src="/web/Public/static/Home3/img/login.png" alt="" style="display:block;margin:0 auto;"/>
                <p style="color:#fff;font-size:18px;text-align:center;">用互联网工具撬动你的商业模式!</p>
                <div class="row">
                    <span class="span1"></span>
                    <input type="text" name="user" placeholder="请输入用户名" style="background:#fff;"/>
                </div>
                <div class="row">
                    <span class="span2"></span>
                    <input type="password" name="pwd" placeholder="请输入密码" />
                </div>
                <div class="row">
                    <span class="span3"></span>
                    <input type="text" name="yzm" placeholder="请输入验证码"/ class="short">
                    
                    <img title="点击刷新" class="short ss" src="<?php echo U('Tool/validateCode');?>" width="153"  alt="" id="safecode" onClick="this.src='<?php echo U('Tool/validateCode');?>'+'?t='+Date()" style="height:50px;border-radius:0;border-top-left-radius: 3px;border-bottom-left-radius: 3px;background:#fff;" />
                </div>
                <div class="row">
                    <span class="deng" onclick="login();">登陆</span>
                </div>
            </div>    
         <div id="particles-js"><canvas class="particles-js-canvas-el" width="1741" height="629"></canvas></div>            
    </div>
    <script type="text/javascript" src="/web/Public/static/Home3/js/particles.min.js"></script>
    <script type="text/javascript" src="/web/Public/static/Home3/js/anonymous.js"></script>
    <script src="/web/Public/static/Home3/js/jquery-1.11.1.min.js"></script>
    <script>
    function login(){
		var loginUser = $('input[name = "user"]').val();
		var loginPwd = $('input[name = "pwd"]').val();
		var loginYzm = $('input[name = "yzm"]').val();
		$.post("<?php echo U('Tool/login');?>",{username:loginUser,password:loginPwd,chknum:loginYzm},function(res) {
				if(res.status==1){
					window.location.href="<?php echo U('Index/index');?>";
				}else{
					alert(res.info);
				}
		});
	}</script>
</body>
</html>