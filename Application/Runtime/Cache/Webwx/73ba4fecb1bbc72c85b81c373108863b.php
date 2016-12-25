<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" /><!-- 删除苹果默认的工具栏和菜单栏 -->
    <meta name="apple-mobile-web-app-status-bar-style" content="black" /><!-- 设置苹果工具栏颜色 -->
    <meta name="format-detection" content="telephone=no, email=no" /><!-- 忽略页面中的数字识别为电话，忽略email识别 -->
    <!-- 启用360浏览器的极速模式(webkit) -->
    <meta name="renderer" content="webkit">
    <!-- 避免IE使用兼容模式 -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- 针对手持设备优化，主要是针对一些老的不识别viewport的浏览器，比如黑莓 -->
    <meta name="HandheldFriendly" content="true">
    <!-- 微软的老式浏览器 -->
    <meta name="MobileOptimized" content="320">
    <!-- uc强制竖屏 -->
    <meta name="screen-orientation" content="portrait">
    <!-- QQ强制竖屏 -->
    <meta name="x5-orientation" content="portrait">
    <!-- UC强制全屏 -->
    <meta name="full-screen" content="yes">
    <!-- QQ强制全屏 -->
    <meta name="x5-fullscreen" content="true">
    <!-- UC应用模式 -->
    <meta name="browsermode" content="application">
    <!-- QQ应用模式 -->
    <meta name="x5-page-mode" content="app">
    <!-- windows phone 点击无高光 -->
    <meta name="msapplication-tap-highlight" content="no">
    <!-- 适应移动端end -->   
    <title>我的礼品</title>
    <link rel="stylesheet" type="text/css" href="/web/Public/static/Webwx/css/newcss/global.css" />
    <link rel="stylesheet" type="text/css" href="/web/Public/static/Webwx/css/newcss/my_shopper.css" />
    <script type="text/javascript" src="/web/Public/static/Webwx/js/zeptoWithFxTouch.min.js"></script>
    <link rel="stylesheet" href="/web/Public/static/Webwx/css/new_main.css" />	
    <!--<link rel="stylesheet" href="/web/Public/static/Webwx/css/main.css" />-->
</head>
<body>
    <div class="wrap">
        <div class="box_main">
            <ul>
            <?php if(is_array($drawlist)): foreach($drawlist as $key=>$re): ?><li onclick="gifeinfo('<?php echo ($re["id"]); ?>')">
                    <img src="/web/Public/upload/Home//<?php echo ($re["gife_img"]); ?>" alt="" />
                    <div class="right_box" style="width:11rem">
                        <p class="pp1">
                            <span><?php echo ($re["order_sn"]); ?></span>
                            <span style="margin-left:5px;float:right"><?php echo ($re["balance"]); echo ($re["gife_unit"]); ?></span>
                        </p>
                        <p class="pp2"><?php echo ($re["title"]); ?></p>
                        <div class="address">
                            <span class="huan1"><?php echo ($re["shopname"]); ?></span>
                            <span class="huan2"><?php echo ($re["area"]); ?></span>
                        </div>
                    </div>
                </li><?php endforeach; endif; ?>                
            </ul>
        </div>
        </div>
        <div class="tixianwangzhan-tankuan" style="display:none;">
			<div class="waiwei">
				<div class="zhedangceng"></div>
				<div class="main">
					<div class="content">
						<div class="chongzhi">
							<div class="chong">
								<span><img src="/web/Public/static/Webwx/images/tixian/ti.png" alt="">领取成功！</span>
								<a href="javascript:;" id="draw_msg">我们已经充值到你的账号，请注意查收！</a>
								<i onclick="que()">确定</i>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="tixianwangzhans-tankuan" style="display:none;">
			<div class="waiwei">
				<div class="zhedangceng"></div>
				<div class="main">
					<div class="content">
						<div class="chongzhi">
							<div class="chong">
								<span><img src="/web/Public/static/Webwx/images/tixian/false.png" alt="">领取失败！</span>
								<a href="javascript:;" class="msg"></a>
								<i onclick="qux()">确定</i>
							</div>
							<input type="hidden" name="url_type" />	
						</div>
					</div>
				</div>
			</div>
		</div>
    
</body>
<script>
function gifeinfo(id,pack_id){
    window.location.href='/web/Webwx/Account/gifeinfo?gife_id='+id;
}
function get(id,status){
    if(status == 1){
        window.location.href='/web/Webwx/Account/draw_give?gife_id='+id+'&balance=1';
    }else{
        $.post("<?php echo U('draw');?>",{type:id},function(res){
    				if(res.status){
                                        alert(res.info);
//    					$('#draw_msg').html(res.info);
//    					$('.tixianwangzhan-tankuan').show();
                                        window.location.href='/web/Webwx/Account/draw';
    				}else{
//    					$('.tixianwangzhans-tankuan').show();
//    					$('.msg').html(res.info);
                                        alert(res.info);
    				}
    				 
    	});
    }
}
function que(){
    $('.tixianwangzhan-tankuan').hide();
    //var url_type=$('input[name="url_type"]').val();
    window.location.href="<?php echo U('draw');?>";	
}	
function qux(){
    $('.tixianwangzhans-tankuan').hide();
}
</script>
</html>