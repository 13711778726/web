<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
		<meta charset="UTF-8">
		<title>开红包</title>
		<meta name="viewport" content="width=640,target-densitydpi=320,user-scalable=no" />
		<!-- <link rel="stylesheet" href="/web/Public/static/Webwx/css/swiper.min.css"> -->
		<!-- <link rel="stylesheet" href="/web/Public/static/Webwx/css/animate.min.css"> -->
		<!-- <script type="text/javascript" src="/web/Public/static/Webwx/js/zeptoWithFxTouch.min.js"></script> -->
		<!-- <script type="text/javascript" src="/web/Public/static/Webwx/js/swiper.min.js"></script> -->
		<!-- <script type="text/javascript" src="/web/Public/static/Webwx/js/jquery-1.11.2.min.js"></script> -->
		<script type="text/javascript" src="/web/Public/static/Webwx/js/TouchSlide.1.1.js"></script>
		<link rel="stylesheet" href="/web/Public/static/Webwx/css/new_main.css" />
		<link rel="stylesheet" href="/web/Public/static/Webwx/css/animations.css" />
		<link rel="stylesheet" type="text/css" href="/web/Public/static/Webwx/css/newcss/global.css" />
    	<link rel="stylesheet" type="text/css" href="/web/Public/static/Webwx/css/newcss/my_shopper.css" />
		<style type="text/css">
			
			html,body{
				width:100%;
				height:100%;
			}
			html{
				overflow: hidden;
			}
			.page{
				position:relative;
				height:100%;
			}
			.page-1{
				background:#fff;
				height:100%;
				overflow:hidden;
				z-index:1;
				position:fixed;
				/* padding-bottom: 170px; */
			}
			.page-2{
				position:fixed;
				z-index:1;
				/* height:100%; */
				/* overflow: hidden; */
				/* border: 2px solid green; */
				/* min-height:1020px;*/
				overflow: scroll;
			}
		</style>
    </head>  
<body style="background-color:#F5F5F5; z-index:0;position: relative;">
		<!-- 开红包首页 -->
		<!-- music -->	
		<!-- banner图 -->		
	<div id="page-content" class="page-content" >
		<div class="page page-1 page-current" style="z-index: 2;">
			<?php if(!empty($hot_pack_info["bg_music"])): ?><div id="music">
				    <div id="audio-btn" class="on" onclick="music.changeClass(this,'media')">
				        <audio  src="<?php echo ($hot_pack_info["bg_music"]); ?>" id="media" autoPlay="false"></audio>
				    </div>
				</div><?php endif; ?>
			<div class="arrow-upImg pt-page-moveIconUp">
				<a href="#page-2" class="lianJie12">
					<img src="/web/Public/static/Webwx/images/new_img/icon_up.png" alt="" class="arrow-up ">
				</a>
			</div>		
			<div id="focus" class="focus clearfix" >
					<div class="bd">
						<ul class="bannerList">
						<?php if($hot_pack_info["imgname1"] != ''): ?><li>
								<a style="width:100%;display:block;" <?php if($hot_pack_info["url1"] != ''): ?>href="<?php echo ($hot_pack_info["url1"]); ?>"<?php endif; ?>><img src="/web/Public/upload/Home//<?php echo ($hot_pack_info["imgname1"]); ?>"></a>
							</li><?php endif; ?>	
						<?php if($hot_pack_info["imgname2"] != '' ): ?><li>
								<a <?php if($hot_pack_info["url2"] != ''): ?>href="<?php echo ($hot_pack_info["url2"]); ?>"<?php endif; ?>><img src="/web/Public/upload/Home//<?php echo ($hot_pack_info["imgname2"]); ?>"></a>
							</li><?php endif; ?>	
						<?php if($hot_pack_info["imgname3"] != ''): ?><li>
								<a <?php if($hot_pack_info["url3"] != ''): ?>href="<?php echo ($hot_pack_info["url3"]); ?>"<?php endif; ?>><img src="/web/Public/upload/Home//<?php echo ($hot_pack_info["imgname3"]); ?>"></a>
							</li><?php endif; ?>	
						</ul>
					</div>
					<div class="hd">
						<ul>
							<li class="on"></li>
							<li></li>
							<li style="margin-right:0px;"></li>
						</ul>
					</div>
			</div>
			<div class="zhuanFa">
				<h3><?php echo ($hot_pack_info["pack_name"]); ?></h3>
				<p><?php echo ($hot_pack_info["share_wz"]); ?></p>				
			</div>			
		</div>
		<div class="page page-2 hide" id="page-2">
		<div class="wrap">
        <div class="box_main">
            <ul>
            <?php if(is_array($gifelist)): foreach($gifelist as $key=>$res): ?><li onclick="gifeinfo('<?php echo ($res["id"]); ?>','<?php echo ($hot_pack_info["id"]); ?>')">
                    <img src="/web/Public/upload/Home//<?php echo ($res["gife_img"]); ?>" alt="" />
                    <div class="right_box">
                        <p class="pp1"><em class="big_em"><?php echo ($res["need_ys"]); ?></em>秘钥<?php if($res["is_get_now"] == 1): ?><span style="color:red;margin-left:8px;">可领取</span><?php else: ?><span style="color:#C5C5C5;margin-left:8px;">可领取</span><?php endif; ?></p>
                        <p class="pp2"><?php echo ($res["title"]); ?></p>
                        <div class="address">
                            <span class="huan1"><?php echo ($res["shopname"]); ?></span>
                            <span class="huan2"><?php echo ($res["area"]); ?></span>
                        </div>
                    </div>
                </li><?php endforeach; endif; ?>    
            </ul>
        </div>
        <div class="hongBao_footer  " style="display:none;">
                    <a href="javascript:;" onclick="set_pack('<?php echo ($hot_pack_info["id"]); ?>')"><div class="fix_bg">已有<span><?php echo ($ys_gife); ?></span>秘钥 去分享集秘钥</div></a>
        </div>
    </div>
				<!-- <div class="hongBao_main" style="position: relative;">
						洋河宝箱
						<div class="yangHe">
							<a href="javascript:; class="yangHe1" "><img src="/web/Public/upload/Home//<?php echo ($boxinfo["imgname1"]); ?>"></a>
							<a href="/web/Webwx/Account/pack_box" class="yangHe2">
								<img src="/web/Public/static/Webwx/images/new_img/bbb.png">
								<p><?php echo ($boxinfo["gifename"]); echo ($boxinfo["box_balance"]); echo ($boxinfo["gife_unit"]); ?></p>
								<span>海量礼品&nbsp;随机送出</span>
							</a>
						</div>		
						<div class="liPinArea liPinArea1">
							<div class="liPinList liPinList1">
								<ul>
								<?php if(is_array($gifelist)): foreach($gifelist as $key=>$res): ?><li onclick="gifeinfo('<?php echo ($res["id"]); ?>','<?php echo ($hot_pack_info["id"]); ?>')">						    
										<div class="liPinList_img">
											<img src="/web/Public/upload/Home//<?php echo ($res["gife_img"]); ?>">
										</div>
										<div class="liPin_wenZi">
											<p><?php echo ($res["gifename"]); ?></p>
											<p>共<?php echo ($res["num"]); echo ($res["gife_unit"]); ?></p>
											<p>剩余<i class="red"><?php echo ($res["surplus_num"]); echo ($res["gife_unit"]); ?></i></p>
										</div>									
									</li><?php endforeach; endif; ?>								
								</ul>
							</div>
						</div>
				</div> -->
				<div class="muTai">
				<div class="muTaiImg">
								<!-- <img src="/web/Public/static/Webwx/images/new_img/pijiu.png" width="400"> -->
                                <img src="<?php if($gife_img != ''): ?>/web/Public/upload/Home//<?php echo ($gife_img); else: endif; ?>" alt="" style="width:400px;height:400px;"/>								
								<i class="clickHide"></i>
								   <!--  <?php echo ($msg); ?> -->
									<!-- <span>恭喜获得</span>
									<p>话费14.67分钟</p> -->
								<a href="javascript:;" class="lingQu" onclick="get_gife();"><?php if($gife_img != ''): ?>点击领取<?php else: ?>查看账户<?php endif; ?></a>
				</div>
				</div>
				<!-- 定位窗口 -->			   
			</div>			
		
	</div>	
   <div class="zhedangcheng-red" <?php if($seter == 1): ?>style="display:block;"<?php else: ?>style="display:none;"<?php endif; ?>></div>
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
	<script type="text/javascript" src="/web/Public/static/Webwx/js/zepto.min.js"></script>
	<script type="text/javascript" src="/web/Public/static/Webwx/js/touch.js"></script>
	<script type="text/javascript" src="/web/Public/static/Webwx/js/index.js"></script>
<script type="text/javascript">
		
		TouchSlide({ 
			slideCell:"#focus",
			titCell:".hd ul", //开启自动分页 autoPage:true 
			mainCell:".bd ul", 
			effect:"leftLoop", 
			autoPlay:true,//自动播放
			autoPage:true //自动分页
			
		});
		$(document).ready(function() {
			var timer;
			timer=setInterval(nextFn, 5000);
		});
		$(document).ready(
        function() {
            var nowpage = 0;
            //给最大的盒子增加事件监听
            $(".container").swipe(
                {
                    swipe:function(event, direction, distance, duration, fingerCount) { 
                         if(direction == "up"){
                            nowpage = nowpage + 1;
                         }else if(direction == "down"){
                            nowpage = nowpage - 1;
                         }

                         if(nowpage > 4){
                            nowpage = 4;
                         }

                         if(nowpage < 0){
                            nowpage = 0;
                         }
                        $(".full_container").animate({"top":nowpage * -100 + "%"},400);

                        $(".page").eq(nowpage).addClass("cur").siblings().removeClass("cur");
                    }
                }
            );
        }
    );
	</script>
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
    	$(document).ready(function() {
    		
    		$('.clickHide').click(function(event) {
    			$('.muTai').hide();
    		});
    	});

		function get_gife(){
			var auth_s='<?php echo ($auth_s); ?>';
			if(auth_s==1){
				window.location.href='/web/Webwx/Account/my_account';
			}else{
				window.location.href='/web/Webwx/User/gz_erweima';
			}
		}
		function gifeinfo(id,pack_id){
		    window.location.href='/web/Webwx/Account/gifeinfo?gife_id='+id+'&pack_id='+pack_id;
		}
    </script>			
</body>
</html>