<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>礼品资料</title>
    <link rel="stylesheet" type="text/css" href="/web/Public/static/Home3/css/base.css" />
    <link rel="stylesheet" type="text/css" href="/web/Public/static/Home3/css/gudinghongbao.css" />
    <link rel="stylesheet" type="text/css" href="/web/Public/static/Home3/css/topic.css" />
    <link rel="stylesheet" type="text/css" href="/web/Public/static/Home3/css/lipinziliao.css" />
    <script type="text/javascript" src="/web/Public/static/Home3/js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="/web/Public/static/Home3/js/gudinghongbao.js"></script>
    <script type="text/javascript" src="/web/Public/static/Home3/js/ueditor/ueditor.config.js"></script>
	<script type="text/javascript" src="/web/Public/static/Home3/js/ueditor/ueditor.all.js"></script>
    <!--引入公共弹框-->
    <link rel="stylesheet" type="text/css" href="/web/Public/static/Home3/css/icons.css"/>
<script type="text/javascript" src="/web/Public/static/Home3/js/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="/web/Public/static/Home3/js/easyui/locale/easyui-lang-zh_CN.js"></script>
<script type="text/javascript" src="/web/Public/static/Home3/js/formvalidator/formValidator.js"></script>
<script type="text/javascript" src="/web/Public/static/Home3/js/formvalidator/formValidatorRegex.js"></script>
<link rel="stylesheet" type="text/css" href="/web/Public/static/Home3/js/easyui/themes/bootstrap/easyui.css" title="gray" />
    <!--统一上传js@preview('img1','imgccc')img1:file表单id，imgccc：保存图片div的id-->
    <script type="text/javascript" src="/web/Public/static/Home3/js/upload.js"></script>   
</head>
<body>
<form action="<?php echo U('Present/updatepresent');?>" method="post" id="formsubmit" enctype="multipart/form-data">
    <div class="wrap">
        <!-- 上传预览 -->
        <div class="piclogin_box">
             <div class="pic_login">请填写礼品资料</div>
             <div class="login_boo">
                <div class="lolo_l">
                     <div class="upload clearfix"> 
                            <div class="up_btn clearfix">
                                <input type="file" name="gife_img" id="gife_img"  onchange="preview('gife_img','img')"/>
                                <div class="btn_bg ">上传预览图</div>
                            </div>
                            <i class="imgccc myimg" id="img"><?php if($gifeinfo["gife_img"] != ''): ?><img src="/web/Public/upload/Home//<?php echo ($gifeinfo["gife_img"]); ?>"><?php else: ?>尺寸为400*400<?php endif; ?></i> 
                      </div> 
                </div>
                <div class="lolo_r">
                    <div class="xianz">
                        <input type="text" placeholder="请输入产品标题(12字符为佳)"  maxlength="12" name="title" class="iptt" value="<?php echo ($gifeinfo["title"]); ?>"/>
                        <span>礼品标题(<em class="erliu">12</em>字符以内)<!-- (已输入<em class="iptt_num">0</em>字) --></span>
                    </div>
                    <div class="xianz">
                        <input type="text" placeholder="请输入产品简称(4字符为佳)"  maxlength="4" name="gifename" class="iptt" value="<?php echo ($gifeinfo["gifename"]); ?>"/>
                        <span>礼品简介(<em class="erliu">4</em>字符以内)<!-- (已输入<em class="iptt_num">0</em>字) --></span>
                    </div>
                    <div class="xianz">
                        <span class="xkc">
                            <em>库存</em><input type="text" class="iptt" name="gife_store" value="<?php echo ($gifeinfo["gife_store"]); ?>"/>
                        </span>
                       <input type="text" placeholder="请输常用单位" name="gife_unit" style="height:30px;width:196px;border:1px solid #dfe1e3;margin:0 20px" class="iptt" value="<?php echo ($gifeinfo["gife_unit"]); ?>"/>
                        <span class="xkc">
                            <em>库存通知</em><input type="text" class="iptt" name="gife_store_lm" value="<?php echo ($gifeinfo["gife_store_lm"]); ?>"/><em style="margin-left:8px">%</em>
                        </span>
                    </div>
                </div>
             </div>
        </div>
       <!-- 领取方式 -->
       <div class="way_box">
           <div class="way_row">
               <div class="way_l">领取方式:</div>
               <div class="way_r">
                   <span class="two_way">
                       <input type="radio" name="is_shipping" <?php if($gifeinfo["is_shipping"] == 1): ?>checked<?php endif; ?> value='1'/>
                       <em>物流发货</em>
                   </span>
                   <span class="two_way">
                       <input type="radio" name="is_shipping" <?php if($gifeinfo["is_shipping"] == 2): ?>checked<?php endif; ?> value='2'/>
                       <em>门店服务</em>
                   </span>
                   <span class="two_way">
                       <input type="radio" name="is_shipping" <?php if($gifeinfo["is_shipping"] == 0): ?>checked<?php endif; ?> value='0'/>
                       <em>直接到账</em>
                   </span>
               </div>
           </div>
           <div class="way_row">
               <div class="way_l">提供商信息:</div>
               <div class="way_r">
                  <span class="two_way">
                       <select name="cooper_type">
                       		<?php if(is_array($cooper)): foreach($cooper as $key=>$re): ?><option value="<?php echo ($re["id"]); ?>" <?php if(($re["id"]) == $gifeinfo["cooper_type"]): ?>selected="selected"<?php endif; ?>><?php echo ($re["title"]); ?></option><?php endforeach; endif; ?>
                       </select>
                   </span>
                   <div class="kuc">
                   </div>
               </div>
           </div>
       </div>
       <!-- 导入文本框 -->
       <textarea name="desc" id="editor" cols="30" rows="10" class="ttar" placeholder="导入文本框"><?php echo ($gifeinfo["desc"]); ?></textarea>
       <input type="hidden" name="id" value="<?php echo ($gifeinfo["id"]); ?>">
        <!-- .nextb -->
        <div class="nextb" >保存</div>
    </div>
</form>
<script>
function check_gifename(){
	var m =  $("input[name='gifename']").val().match(/^.{1,4}$/i);
	if(m){
		return true;
	}else{
		$.messager.alert('提示信息', '请输入4个字符以内的礼品简称','error'); 	   				
		return false;   			
	}
}
function check_gife_unit(){
	var m =  $("input[name='gife_unit']").val().match(/^.{1,4}$/i);
	if(m){
		$('.desc').html('');
		return true;
	}else{
		$.messager.alert('提示信息', '请输入4个字符以内的礼品单位','error');    				
		return false;   			
	}
}
$('.nextb').click(function(){
	if(check_gifename()&&check_gife_unit()){
		$('#formsubmit').submit();
	}	
});
UE.getEditor('editor',{initialFrameHeight:350,autoHeightEnabled:false});
</script>
</body>
</html>