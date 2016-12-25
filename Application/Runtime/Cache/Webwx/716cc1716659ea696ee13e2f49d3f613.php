<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
		<meta charset="UTF-8">
		<title>红包详情</title>
		<meta name="viewport" content="width=640,target-densitydpi=320,user-scalable=no" />
		<link rel="stylesheet" href="/web/Public/static/Webwx/css/swiper.min.css">
		<link rel="stylesheet" href="/web/Public/static/Webwx/css/animate.min.css">
		<script type="text/javascript" src="/web/Public/static/Webwx/js/zeptoWithFxTouch.min.js"></script>
		<script type="text/javascript" src="/web/Public/static/Webwx/js/swiper.min.js"></script>
		<link rel="stylesheet" href="/web/Public/static/Webwx/css/new_main.css" />	
    </head>
<body style="background-color:#fff; ">
	<div class="hongBaoList hongBaoList1">
		<!-- <h3><?php echo ($acct_hot_pack["title"]); ?></h3> -->
		<div class="hongBao_info clearfix">
			<div class="hongBaoImg">
				<img src="/web/Public/upload/Home//<?php echo ($acct_hot_pack["pack_img"]); ?>">
			</div>
			<div class="tuiGuangArea">
				<p><?php echo ($acct_hot_pack["title"]); ?><br><?php echo ($acct_hot_pack["desc"]); ?></p>
			</div>
		</div>
	</div>
	<!-- 红包模式 -->
	<div class="hongBo_p">
		<p>内含模式&nbsp;&nbsp;&nbsp;<?php echo ($m_type); ?>种</p>
	</div>
	<div class="hongBao_moShi">
		
		<?php if($acct_hot_pack["pack_type_bt"] != 0): ?><div class="moShi_ways moShi_ways1">
			<span>猜奖有礼:</span>
			<span>猜奖有礼，猜中奖励翻倍哦！</span>
		</div>	
		<?php else: ?>
		<?php if($acct_hot_pack["pack_type_bz"] != 0): ?><div class="moShi_ways moShi_ways1">
			<span>分享奖励:</span>
			<span>别人抢到什么，您返得秘钥<i class="red"><?php echo ($acct_hot_pack["lq_send"]); ?></i></span>
		</div><?php endif; ?>
		<?php if($acct_hot_pack["pack_type_bx"] != 0): ?><div class="moShi_ways">
			<span>终极宝箱:</span>
			<span>别人领取秘钥<i class="red">+<?php echo ($acct_hot_pack["lq_send"]); ?></i>，关注<i class="red">+<?php echo ($acct_hot_pack["gz_send"]); ?></i>&nbsp;&nbsp;&nbsp;购买<i class="red">+<?php echo ($acct_hot_pack["gm_send"]); ?></i><br>集满<?php echo ($boxinfo["ys_limit"]); ?>枚,可领取<?php echo ($boxinfo["gifename"]); echo ($boxinfo["box_balance"]); echo ($boxinfo["gife_unit"]); ?></span>
		</div><?php endif; ?>
		<?php if($acct_hot_pack["pack_type_fx"] != 0): ?><div class="moShi_ways moShi_ways3">
			<span>锁定下级:</span>
			<span> 引入的用户，它每次消费您可获得<i class="red"><?php echo ($acct_hot_pack["user_sale"]); ?>%</i>提成
			</span>
		</div><?php endif; endif; ?>
	</div>
	<!-- 礼品区域 -->
	<div class="hongBo_p hongBo_p1">
		<p><span>内含礼品</span>&nbsp;&nbsp;&nbsp;<?php echo ($gife_num); ?>种<span>&nbsp;&nbsp;&nbsp;&nbsp;分享红包，让更多的人帮您抢礼品</span></p>
	</div>
	<div class="liPinArea">
		<div class="liPinList">
			<ul class="clearfix">
			<!-- <?php if(is_array($gifelist)): foreach($gifelist as $key=>$res): ?><li><img src="/web/Public/upload/Home//<?php echo ($res["gife_img"]); ?>"></li><?php endforeach; endif; ?> -->
			<?php if(is_array($gifelist)): foreach($gifelist as $key=>$res): ?><li onclick="gifeinfo('<?php echo ($res["id"]); ?>','<?php echo ($acct_hot_pack["id"]); ?>')">				
					<div class="liPinList_img">
						<img src="/web/Public/upload/Home//<?php echo ($res["gife_img"]); ?>">
					</div>
					<div class="liPin_wenZi">
						<p><?php echo ($res["gifename"]); ?></p>
						<p>共<?php echo ($res["num"]); echo ($res["gife_unit"]); ?></p>
						<p>剩余<i class="red"><?php echo ($res["surplus_num"]); echo ($res["gife_unit"]); ?></i></p>
					</div>
				</li><?php endforeach; endif; ?>	
				<!-- <li>
					<div class="liPinList_img">
						<img src="/web/Public/static/Webwx/images/new_img/">
					</div>
					<div class="liPin_wenZi">
						<p>鞋子</p>
						<p>共10双</p>
					</div>
				</li>
				<li>
					<div class="liPinList_img">
						<img src="/web/Public/static/Webwx/images/new_img/">
					</div>
					<div class="liPin_wenZi">
						<p>鞋子</p>
						<p>共10双</p>
					</div>
				</li>
				<li>
					<div class="liPinList_img">
						<img src="/web/Public/static/Webwx/images/new_img/">
					</div>
					<div class="liPin_wenZi">
						<p>鞋子</p>
						<p>共10双</p>
					</div>
				</li> -->
			</ul>
		</div>
	</div>
	<!-- 发红包底部 -->
	<div class="hongBao_footer hongBao_footer1">
		<a href="javascript:;"onclick="set_pack('<?php echo ($acct_hot_pack["id"]); ?>')">发红包</a>
	</div>
    <script>
    	function set_pack(id){
    		$.post('/web/Webwx/Account/acct_pack_info',{pack_id:id},function(res){
    			if(res.status){
    				if(res.data.pack_mode==-1){
        				window.location.href='<?php echo U('pack_m_get');?>?pack_id='+res.data.pack_id+'&seter=1';
        			}else{
        				window.location.href='<?php echo U('get_acct_pack_new');?>?pack_id='+res.data.pack_id+'&seter=1';
        				//$('.zhedangcheng-red').css('display','block');
        			}
    			}else{
    				alert(res.info);
    			}	
    		});
    	}
		function gifeinfo(id,pack_id){
		    window.location.href='/web/Webwx/Account/gifeinfo?gife_id='+id+'&pack_id='+pack_id;
		}
    </script>
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
</body>
</html>