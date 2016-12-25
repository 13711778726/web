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
    <title>礼品详情</title>
    <link rel="stylesheet" type="text/css" href="/web/Public/static/Webwx/css/newcss/global.css" />
    <link rel="stylesheet" type="text/css" href="/web/Public/static/Webwx/css/newcss/my_detail.css" />
    <script type="text/javascript" src="/web/Public/static/Webwx/js/zepto.min.js"></script>
    <script type="text/javascript" src="/web/Public/static/Webwx/js/index.js"></script>
    
</head>
<body>
    <div class="wrap">
        <div class="big_box">
            <img src="/web/Public/upload/Home//<?php echo ($gifeinfo["gife_img"]); ?>"  alt="" />
            <div class="right_main">
                <p class="jim" style="color:#333;"><?php if($set_type == 1): ?>集满<?php echo ($gifeinfo["need_ys"]); ?>秘钥<span>可领取</span><?php else: echo ($gifeinfo["gifename"]); endif; ?></p>
                <p class="chang"><?php echo ($gifeinfo["gife_title"]); ?></p>
                <p class="bbth"><?php if($set_type == 1): ?><span>共<?php echo ($gifeinfo["num"]); ?>份</span><span class="rred">还剩<?php echo ($gifeinfo["surplus_num"]); ?>份</span><?php endif; ?><span><?php if($gifeinfo["is_shipping"] == 0): ?>直接到账<?php elseif($gifeinfo["is_shipping"] == 1): ?>物流发货<?php elseif($gifeinfo["is_shipping"] == 2): ?>门店服务<?php endif; ?></span></p>
            </div>
        </div>
        <div class="litter_box">
            <span class="wenz" style="font-size:16px;color:#272727;"><?php echo ($gifeinfo["shopname"]); ?></span>
            <span class="tubiao tubiao1"></span>
        </div>
        <div class="hide_jso">
            <p class="pff"><?php echo ($gifeinfo["title"]); ?></p>
            <p class="phopp"><?php echo ($gifeinfo["phone"]); ?></p>
            <div class="los">
                <div class="ls_l">
                    <div class="ewwm"><img src="/web/Public/upload/Home//<?php echo ($gifeinfo["img_url"]); ?>" width="108"></div>
                </div>
                <div class="ls_l">
                    <div class="ewwm"><img src="/web/Public/upload/Home//<?php echo ($gifeinfo["code_img"]); ?>" width="108"></div>
                </div>
            </div>
            <p class="jianjj">简介</p>
            <p class="sopp"><?php echo ($gifeinfo["desc"]); ?></p>
        </div>
         <!-- <div class="litter_box">
            <span class="wenz"><?php echo ($gifeinfo["phone"]); ?></span>
            <span class="tubiao tubiao2"></span>
        </div>
 -->    <div class="litter_box">
                <span class="wenz"><?php echo ($gifeinfo["gz_desc"]); ?></span>
                <span class="tubiao tubiao3"></span>
        </div>
        <div class="hide_jso" style="margin:5 auto;width:96%;box-sizing: border-box;display:block;margin-bottom:20px;padding:5px;"><?php echo ($gifeinfo["detail"]); ?></div>
        <?php if($set_type == 1): ?><p style="text-align: center;height:3rem;line-height: 3rem;position:fixed;width:100%;background:#fa5b5b;bottom:0;left:0;color:#fff;font-size:1rem;" onclick="change()">确认兑换</p>
        <?php else: ?><p style="text-align: center;height:3rem;line-height: 3rem;position:fixed;width:100%;background:#fa5b5b;bottom:0;left:0;color:#fff;font-size:1rem;" onclick="get('<?php echo ($gifeinfo["id"]); ?>','<?php echo ($gifeinfo["is_shipping"]); ?>')">确认领取</p><?php endif; ?>
       
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
    <script>
        function change(){
            id=<?php echo ($gifeinfo["id"]); ?>;
            r = confirm("确定兑换？");
            if(r){
                $.post('/web/Webwx/Account/change',{gife_id:id},function(res){
                        if(res.status){
                                alert(res.info);
                                window.location.href="<?php echo U('Account/draw');?>";
                        }else{
                                alert(res.info);
                        }	
                });
            }
        }
        function get(id,status){
            if(status == 1){
                window.location.href='/web/Webwx/Account/draw_give?gife_id='+id+'&balance=1';
            }else{
                $.post("<?php echo U('draw');?>",{type:id},function(res){
            				if(res.status){
                                                alert(res.info);
            					//$('#draw_msg').html(res.info);
            					//$('.tixianwangzhan-tankuan').show();                              
            				}else{
            					//$('.tixianwangzhans-tankuan').show();
            					//$('.msg').html(res.info);
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

</body>
</html>