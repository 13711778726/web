<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
    <html lang="en">
        <head>
            <meta name="viewport" content="width=640,target-densitydpi=320,user-scalable=no" />
		<link rel="stylesheet" href="/web/Public/static/Webwx/css/swiper.min.css">
		<link rel="stylesheet" href="/web/Public/static/Webwx/css/animate.min.css">
		<script type="text/javascript" src="/web/Public/static/Webwx/js/zeptoWithFxTouch.min.js"></script>
		<link rel="stylesheet" href="/web/Public/static/Webwx/css/new_main.css" />
		<script type="text/javascript" src="/web/Public/static/Webwx/js/swiper.min.js"></script>
		<title>关注公众号</title>
		<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
	wx.config({
		debug: false,
		appId: '<?php echo ($sign["appId"]); ?>',
		timestamp:<?php echo ($sign["timestamp"]); ?>,
		nonceStr: '<?php echo ($sign["nonceStr"]); ?>',
		signature: '<?php echo ($sign["signature"]); ?>',
		jsApiList: [
		// 所有要调用的 API 都要加到这个列表中
		'onMenuShareTimeline',     //分享到朋友圈
		'onMenuShareAppMessage',   //分享到朋友
		'onMenuShareQQ',           //分享到QQ
		'onMenuShareQZone'         //分享到QQ空间
	]
   });
   
   
wx.ready(function () {
	 wx.checkJsApi({
		    jsApiList: ['chooseImage',
		    		    'onMenuShareTimeline',
		                'onMenuShareAppMessage',
		                'onMenuShareQQ',
		                'onMenuShareWeibo',
		                'onMenuShareQZone',], // 需要检测的JS接口列表，所有JS接口列表见附录2,
		    success: function(res) {
		        // 以键值对的形式返回，可用的api值true，不可用为false
		        // 如：{"checkResult":{"chooseImage":true},"errMsg":"checkJsApi:ok"}
		    }
		});
	 //分享给朋友
	  wx.onMenuShareAppMessage({
		    title: '<?php echo ($saveinfo["pp_title"]); ?>', // 分享标题
		    desc: '<?php echo ($saveinfo["pp_desc"]); ?>', // 分享描述
		    link: '<?php echo ($saveinfo["pp_url"]); ?>', // 分享链接
		    imgUrl: '<?php echo ($saveinfo["pp_pic"]); ?>', // 分享图标
		    type: '', // 分享类型,music、video或link，不填默认为link
		    dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
		    success: function () { 
		    	if((<?php echo ($saveinfo["auth_s"]); ?> == "1")){
		    		window.location.href='<?php echo U('my_account');?>';
		    	}else{
		    		window.location.href='<?php echo U('user/gz_erweima');?>';
		    	}
		    	//saveinfo()
				//alert(1212);
		        // 用户确认分享后执行的回调函数 
		    },
		    cancel: function () { 
		        // 用户取消分享后执行的回调函数
		    	alert('取消分享给朋友'); 
		    }
		});
	
	 /* 分享到朋友圈 */
	 wx.onMenuShareTimeline({
		    title: '<?php echo ($saveinfo["pp_title"]); ?>', // 分享标题
		    link: '<?php echo ($saveinfo["pp_url"]); ?>', // 分享链接
		    imgUrl: '<?php echo ($saveinfo["pp_pic"]); ?>', // 分享图标
		    success: function () {
		    	if((<?php echo ($saveinfo["auth_s"]); ?> == "1")){
		    		window.location.href='<?php echo U('my_account');?>';
		    	}else{
		    		window.location.href='<?php echo U('user/gz_erweima');?>';
		    	}
		    	//saveinfo()
		    },
		    cancel: function () { 
		        // 用户取消分享后执行的回调函数
		        alert('您已取消分享！');
		    }
		});
		//分享到QQ
	  wx.onMenuShareQQ({
		    title: '<?php echo ($saveinfo["pp_title"]); ?>', // 分享标题
		    desc: '<?php echo ($saveinfo["pp_desc"]); ?>', // 分享描述
		    link: '<?php echo ($saveinfo["pp_url"]); ?>', // 分享链接
		    imgUrl: '<?php echo ($saveinfo["pp_pic"]); ?>', // 分享图标
		    success: function () {
		    	//saveinfo()
		    },
		    cancel: function () { 
		       // 用户取消分享后执行的回调函数
		    	alert('您已取消分享！');
		    }
		});
		//分享到QQ空间
	  wx.onMenuShareQZone({
		    title: '<?php echo ($saveinfo["pp_title"]); ?>', // 分享标题
		    desc: '<?php echo ($saveinfo["pp_desc"]); ?>', // 分享描述
		    link: '<?php echo ($saveinfo["pp_url"]); ?>', // 分享链接
		    imgUrl: '<?php echo ($saveinfo["pp_pic"]); ?>', // 分享图标
		    success: function () { 
		    	//saveinfo()
		    },
		    cancel: function () { 
		        // 用户取消分享后执行的回调函数
		    	alert('您已取消分享！');
		    }
		});
})
</script>
        </head>
        
        <body>
	<div class="xinbaiwanghongbao-tankuang">
		<div class="waiwei">
			<div class="zhedangceng"></div>
			<div class="neir">
				<div style="width:390px;height:390px;margin:0 auto;">
					<img src="/web/Public/upload/Home//<?php echo ($code_img); ?>" alt="">
				</div>
				<p color:#ffffff;"><span style="font-size:30px;color:#bababa;">一大波礼品正如潮水般向您涌来</span><br><span style="font-size:40px;color:#bababa;">长按二维码关注</span></p>
			</div>
		</div>
	</div>
		
		<div class="hongbaoguabg ongbaoguabg-a" style="display:block;">
		 	<img src="/web/Public/static/Webwx/images/redpacket/hon-bg.png" alt="" class="er">
		 	<i></i>
 	</div>
                
        </body>
    </html>