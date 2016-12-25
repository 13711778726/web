<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>主题设置</title>
    <link rel="stylesheet" type="text/css" href="/web/Public/static/Home3/css/base.css" />
    <link rel="stylesheet" type="text/css" href="/web/Public/static/Home3/css/gudinghongbao.css" />
    <link rel="stylesheet" type="text/css" href="/web/Public/static/Home3/css/topic.css" />
    <script type="text/javascript" src="/web/Public/static/Home3/js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="/web/Public/static/Home3/js/gudinghongbao.js"></script>
    <!--统一上传js@preview('img1','imgccc')img1:file表单id，imgccc：保存图片div的id-->
    <script type="text/javascript" src="/web/Public/static/Home3/js/upload.js"></script> 
</head>
<body>
    <div class="wrap">   
    	   
        <!-- navv -->
        <div class="navv">       	
            <div class="logoo">
                logo
            </div>
            <div class="liucheng">
                <ul>
                    <li>
                        <p class="topic_z">主题设置</p>
                        <div class="yuanjiao">1</div>
                        <div class="xian"></div>
                    </li>
<!--                    <li onclick="javascript:location.href='<?php echo U("Pack/pack_com");?>?pack_id=<?php echo ($packinfo["id"]); ?>&set_type=2'">
                        <p class="topic_z bbloak">红包雨</p>
                        <div class="yuanjiao ccolor">2</div>
                        <div class="xian ccolor"></div>
                    </li>-->
                    <li onclick="javascript:location.href='<?php echo U("Pack/pack_com");?>?pack_id=<?php echo ($packinfo["id"]); ?>&set_type=0'">
                        <p class="topic_z bbloak">礼品设置</p>
                        <div class="yuanjiao ccolor">2</div>
                        <div class="xian ccolor"></div>
                    </li>
                    <li onclick="javascript:location.href='<?php echo U("Pack/pack_draw");?>?pack_id=<?php echo ($packinfo["id"]); ?>'">
                        <p class="topic_z bbloak">兑换设置</p>
                        <div class="yuanjiao ccolor">3</div>
                        <div class="xian ccolor"></div>
                        <div class="xian ccolor"></div>
                    </li>
                </ul>
            </div>
        </div>
        <!-- 上传预览 -->
        <form action="<?php echo U('Pack/updatepack');?>" method="post" id="formsubmit" enctype="multipart/form-data">       
        <div class="piclogin_box">
             <div class="pic_login">请填写主题资料</div>
             <div class="login_boo">
                <div class="lolo_l">
                     <div class="upload clearfix"> 
                            <div class="up_btn clearfix">
                                <input type="file" name="img1" id="img1"  onchange="preview('img1','imgccc')"/>
                                <div class="btn_bg ">上传预览图</div>
                            </div>                            
                            <i class="imgccc myimg" id="imgccc"><?php if($packinfo["pack_img"] != '' ): ?><img src="/web/Public/upload/Home//<?php echo ($packinfo["pack_img"]); ?>" /><?php else: ?>尺寸为200*200<?php endif; ?></i> 
                      </div> 
                </div>
                <div class="lolo_r">
                    <div class="xianz">
                        <input type="text" name="title" placeholder="请输入主题标题(26字符以内为佳，超出部分将不会显示)"  maxlength="26" class="iptt" value="<?php echo ($packinfo["title"]); ?>"/>
                        <span>主题标题(<em class="erliu">26</em>字符以内)<!-- :已输入<em class="iptt_num">0</em>字 --></span>
                    </div>
                    <div class="xianz">
                        <textarea name="desc" id="" maxlength="38" placeholder="请输入主题的简单介绍(38字符以内为佳，超出部分将不会显示)" class="teea" ><?php echo ($packinfo["desc"]); ?></textarea>
                        <span class="span1">主题介绍(<em class="erliu">38</em>字符以内)<!-- (已输入<em class="teea_num">0</em>字) --></span>
                    </div>
                </div>
             </div>
        </div>
        <div class="piclogin_box">
             <div class="pic_login">请填写轮播资料</div>
             <div class="login_boo">
                <div class="lolo_l">
                     <div class="upload clearfix"> 
                            <div class="up_btn clearfix">
                                <input type="file" name="img2" id="img2"  onchange="preview('img2','imgccc2')"/>
                                <div class="btn_bg ">上传预览图</div>
                            </div>
                            <i class="imgccc2 myimg" id="imgccc2"><?php if($packinfo["imgname1"] != '' ): ?><img src="/web/Public/upload/Home//<?php echo ($packinfo["imgname1"]); ?>" /><?php else: ?>尺寸为640*720<?php endif; ?></i> 
                      </div> 
                </div>
                <div class="lolo_r">
                    <div class="xianz">
                        <input type="text" name="pack_name" placeholder="请输入主题标题(26字符以内为佳，超出部分将不会显示)"  maxlength="26" class="iptt" value="<?php echo ($packinfo["pack_name"]); ?>"/>
                        <span>轮播标题(<em class="erliu">26</em>字符以内)<!-- (已输入<em class="iptt_num">0</em>字) --></span>
                    </div>
                    <div class="xianz">
                        <textarea name="share_wz" id="" maxlength="38" placeholder="请输入主题的简单介绍(38字符以内为佳，超出部分将不会显示)" class="teea"><?php echo ($packinfo["share_wz"]); ?></textarea>
                        <span class="span1">轮播介绍(<em class="erliu">38</em>字符以内)<!-- (已输入<em class="teea_num">0</em>字) --></span>
                    </div>
                    <div class="xianz">
                        <input type="text" placeholder="请输入图片要调往的链接地址" name="url" value="<?php echo ($packinfo["url1"]); ?>"/>
                    </div>
                </div>
             </div>
        </div>
        <!-- anniu -->
        <div class="anniu">
        	<input type="hidden" name="pack_type_bz" value="<?php echo ($pack_mode["pack_type_bz"]); ?>">
        	<input type="hidden" name="pack_type_fx" value="<?php echo ($pack_mode["pack_type_fx"]); ?>">
            <div class="line_one">
            	
                <span class="qieh <?php if($pack_mode["pack_type_bz"] != 1): ?>huann<?php endif; ?>" id="sare"></span>
                <span class="yuanw">分享奖励</span>
                
            </div>
            <div class="line_one">
                <span class="yuanw">点击送</span>
                <input type="text" class="qieh2" name="lq_send" value="<?php echo ($packinfo["lq_send"]); ?>"/>
                <span class="yuanw">秘钥</span>
            </div>
            <!-- <div class="line_one">
                <span class="yuanw">关注送</span>
                <input type="text" class="qieh2" />
                <span class="yuanw">秘钥</span>
            </div> -->
             <div class="line_one">
                
                <span class="qieh <?php if($pack_mode["pack_type_fx"] != 3): ?>huann<?php endif; ?>" id="sare_bd"></span>
                <span class="yuanw">下级绑定</span>               
            </div>
        </div>
        <input type="hidden" name="pack_id" value="<?php echo ($packinfo["id"]); ?>">
        <input type="hidden" name="set_type">
        <!-- .nextb -->
        <div class="nextb" style="width:290px;background:0 none;">
            <span style="height:100%;width:140px;margin-right:10px;display:inline-block;float:left;background:#5a9cca;" onclick="save()">保存</span>
            <span style="height:100%;width:140px;background:#5a9cca;display:inline-block;float:left;" onclick="save_s()">下一步</span>
        </div>
        
        <!-- <div class="" onclick="javascript:location.href='<?php echo U("Pack/pack_com");?>?pack_id=<?php echo ($packinfo["id"]); ?>&set_type=2'">下一步</div> -->
       </form> 
    </div>
<script>
$('#sare').click(function(event) {
	var pack_type_bz=$('input[name="pack_type_bz"]').val();
	if(pack_type_bz==0){
		$('input[name="pack_type_bz"]').val(1);
	}else{
		$('input[name="pack_type_bz"]').val(0);
	}	
	$(this).toggleClass('huann');
})
$('#sare_bd').click(function(event) {
	var pack_type_fx=$('input[name="pack_type_fx"]').val();
	if(pack_type_fx==0){
		$('input[name="pack_type_fx"]').val(3);
	}else{
		$('input[name="pack_type_fx"]').val(0);
	}	
	$(this).toggleClass('huann');
})
function save(){
	$('#formsubmit').submit();
}
function save_s(id){
	$('input[name="set_type"]').val('0')
	$('#formsubmit').submit();
}
/* $('.nextb').click(function(){
	$('#formsubmit').submit();
}); */
</script>    
</body>
</html>