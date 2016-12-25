<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>商城页面</title>      
        <link rel="stylesheet" type="text/css" href="/web/Public/static/Home3/css/base.css" />
<link rel="stylesheet" type="text/css" href="/web/Public/static/Home3/css/add_com.css" />
<link rel="stylesheet" type="text/css" href="/web/Public/static/Home3/css/index.css" />
<link rel="stylesheet" type="text/css" href="/web/Public/static/Home3/css/my_index.css" />
<link rel="stylesheet" type="text/css" href="/web/Public/static/Home3/css/gudinghongbao.css" />
<link rel="stylesheet" type="text/css" href="/web/Public/static/Home3/css/lipinziliao.css" />

<script type="text/javascript" src="/web/Public/static/Home3/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/web/Public/static/Home3/js/index.js"></script>
<script type="text/javascript" src="/web/Public/static/Home3/js/gudinghongbao.js"></script>



        <link rel="stylesheet" type="text/css" href="/web/Public/static/Home3/css/icons.css"/>
<script type="text/javascript" src="/web/Public/static/Home3/js/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="/web/Public/static/Home3/js/easyui/locale/easyui-lang-zh_CN.js"></script>
<script type="text/javascript" src="/web/Public/static/Home3/js/formvalidator/formValidator.js"></script>
<script type="text/javascript" src="/web/Public/static/Home3/js/formvalidator/formValidatorRegex.js"></script>
<link rel="stylesheet" type="text/css" href="/web/Public/static/Home3/js/easyui/themes/bootstrap/easyui.css" title="gray" />
        <link rel="stylesheet" type="text/css" href="/web/Public/static/Home3/css/tongxiangqing.css" />
        <link rel="stylesheet" type="text/css" href="/web/Public/static/Home3/css/topic.css" />
        <link rel="stylesheet" type="text/css" href="/web/Public/static/Home3/css/addku.css" />
        <script type="text/javascript" src="/web/Public/static/Home3/js/upload.js"></script>
        <script type="text/javascript" src="/web/Public/static/Home3/js/qiandao.js"></script>
        <script type="text/javascript" src="/web/Public/static/Home3/js/tongxiangqing.js"></script>
        <script type="text/javascript" src="/web/Public/static/Home3/js/My97DatePicker/WdatePicker.js"></script> 
        <script type="text/javascript" src="/web/Public/static/Home3/js/ueditor/ueditor.config.js"></script>
		<script type="text/javascript" src="/web/Public/static/Home3/js/ueditor/ueditor.all.js"></script>
    </head>
    <body>
        <div class="wrap">
            <div class="litter_nav">
                <span class="on xxxq">商品详情</span>
                <span class="tttq">通用详情</span>
                <span class="tkc">商品库存</span>
            </div>
            <!-- 商品详情 -->
            <form action="<?php echo U('Shop/updategood');?>" method="post" id="formsubmit" enctype="multipart/form-data">
            <div class="xiangh">
                <!-- 上传 -->
                <div class="login_boo" style="margin-left:220px;">
                    <div class="lolo_l">
                         <div class="upload clearfix"> 
                                <div class="up_btn clearfix">
                                    <input type="file" name="img_url" id="gife_img"  onchange="preview('gife_img','img')"/>
                                    <div class="btn_bg ">上传预览图</div>
                                </div>
                                <i class="imgccc myimg" id="img"><?php if($list["img_url"] != ''): ?><img src="/web/Public/upload/Home//<?php echo ($list["img_url"]); ?>"><?php else: ?>尺寸为200*200<?php endif; ?></i> 
                         </div>  
                    </div>
                    <div class="lolo_r">
                        <div class="xianz">
                            <input type="text" placeholder="请输入产品标题(12字符为佳)"  maxlength="12" class="iptt" name="goodsname" value="<?php echo ($list["goodsname"]); ?>"/>
                            <span>(已输入<em class="iptt_num">0</em>字)</span>
                        </div>
                        <div class="xianz">
                            <input type="text" class="litter_ipt" placeholder="请输入价格" name="price" value="<?php echo ($list["price"]); ?>"/>
                            <input type="text" class="litter_ipt" placeholder="请输入常用单位" name="goods_unit" value="<?php echo ($list["goods_unit"]); ?>"/>
                        </div>
                        <div class="xianz">
                            <input type="text" class="litter_ipt" placeholder="请输入库存" name="goods_num" value="<?php echo ($list["goods_num"]); ?>"/>
                            <span class="lowyu">库存低于</span>
                            <input type="text"  class="lop_ipt" name="store_lm" value="<?php echo ($list["store_lm"]); ?>"/>
                            <span class="tellme">%</span>
                            <span class="ttell_me">时通知我</span>
                        </div>
                    </div>
                </div>
                <!-- 选择 -->
                <div class="dtxqq">
                    <div class="dtt_row">
                        <div class="one_row">
                            <input type="checkbox" class="cck" name="is_sales" <?php if($list["is_sales"] == 1): ?>checked<?php endif; ?> value="1"/>
                            <span class="row_word">促销价</span>
                            <input type="text" class="iipt" name="sale_price" value="<?php echo ($list["sale_price"]); ?>"/>
                            <span class="cow_word">元</span>
                        </div>
                        <div class="one_row">
                            <span class="row_word">促销时间从</span>
                            <input type="text" class="iipt" name="starttime" value="<?php echo ($list["starttime"]); ?>" onfocus="WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'2008-03-08 11:30:00'})"/>
                            <span class="cow_word">—</span>
                            <input type="text" class="iipt" name="endtime" value="<?php echo ($list["endtime"]); ?>" onfocus="WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'2008-03-08 11:30:00'})"/>
                        </div>
                    </div>
                    <div class="dtt_row">
                        <div class="one_row">
                            <input type="checkbox" class="cck" name="is_need_ys" <?php if($list["is_need_ys"] == 1): ?>checked<?php endif; ?> value="1"/>
                            <span class="row_word">开启密钥兑换</span>
                            <span class="needx">所需</span>
                            <input type="text" class="iipt" name="need_ys" value="<?php echo ($list["need_ys"]); ?>"/>
                            <span class="cow_word">枚</span>
                        </div>
                        <div class="one_row">
                            <input type="checkbox" class="cck" name="is_child_sale" <?php if($list["is_child_sale"] == 1): ?>checked<?php endif; ?> value="1"/>
                            <span class="row_word">开启下级提成</span>
                            <span class="needx">提成比例</span>
                            <input type="text" class="iipt" name="user_sale" value="<?php echo ($list["user_sale"]); ?>"/>
                            <span class="cow_word">%</span>
                        </div>
                    </div>
                    <div class="dtt_row">
                        <div class="one_row">
                            <span class="row_word mrr">商品保证:</span>
                            <input type="checkbox" class="cck" name="is_zp" <?php if($list["is_zp"] == 1): ?>checked<?php endif; ?> value="1"/>
                            <span class="cow_word mll">正品保证</span>
                            <input type="checkbox" class="cck" name="is_qw" <?php if($list["is_qw"] == 1): ?>checked<?php endif; ?> value="1"/>
                            <span class="cow_word mll">权威认证</span>
                            <input type="checkbox" class="cck" name="is_qt" <?php if($list["is_qt"] == 1): ?>checked<?php endif; ?> value="1"/>
                            <span class="cow_word" >7天退换</span>
                        </div>
                    </div>
                    <div class="dtt_row">
                        <div class="one_row">
                            <span class="row_word mrr">商品运输:</span>
                            <input type="checkbox" class="cck" name="is_delivery" <?php if($list["is_delivery"] == 1): ?>checked<?php endif; ?> value="1"/>
                            <span class="cow_word mll">货到付款</span>
                            <input type="checkbox" class="cck" name="pinkage" <?php if($list["pinkage"] == 1): ?>checked<?php endif; ?> value="1"/>
                            <span class="cow_word mll" >免运费</span>
                        </div>
                    </div>
                </div>
                <!-- 添加轮播图 -->
                <div class="add_banner">
                    <div class="zu_banner">
                    <!-- <?php if(is_array($shop_gallery)): foreach($shop_gallery as $key=>$re): ?><div class="upload clearfix"> 
                                <div class="up_btn clearfix">
                                    <input type="file" name="img[]" id="gife_img1"  onchange="preview('gife_img1','img1')"/>
                                    <div class="btn_bg ">修改轮播图</div>
                                </div>
                                <i class="imgccc myimg" id="img1"><?php if($re["img_url"] != ''): ?><img src="/web/Public/upload/Home//<?php echo ($re["img_url"]); ?>"><?php else: ?>尺寸为640*670<?php endif; ?></i> 
                                <div class="bg_he"></div>
                        </div><?php endforeach; endif; ?> -->
                        <div class="upload clearfix"> 
                                <div class="up_btn clearfix">
                                    <input type="file" name="img<?php echo ($imgone["id"]); ?>[]" id="gife_img1"  onchange="preview('gife_img1','img1')" style="left: 0px;width:100px;"/>
                                    <div class="btn_bg "><?php if($imgone["img_url"] != ''): ?>编辑轮播图<?php else: ?>添加轮播图<?php endif; ?></div>
                                </div>
                                <i class="imgccc myimg" id="img1"><?php if($imgone["img_url"] != ''): ?><img src="/web/Public/upload/Home//<?php echo ($imgone["img_url"]); ?>"><?php else: ?>尺寸为640*670<?php endif; ?></i> 
                                <div class="bg_he" <?php if($imgone["img_url"] != ''): ?>onclick="del('<?php echo ($imgone["id"]); ?>')"<?php endif; ?>></div>
                        </div>
                        <div class="upload clearfix"> 
                                <div class="up_btn clearfix">
                                    <input type="file" name="img<?php echo ($imgtwo["id"]); ?>[]" id="gife_img2"  onchange="preview('gife_img2','img2')" style="left: 0px;width:100px;"/>
                                    <div class="btn_bg "><?php if($imgtwo["img_url"] != ''): ?>编辑轮播图<?php else: ?>添加轮播图<?php endif; ?></div>
                                </div>
                                <i class="imgccc myimg" id="img2"><?php if($imgtwo["img_url"] != ''): ?><img src="/web/Public/upload/Home//<?php echo ($imgtwo["img_url"]); ?>"><?php else: ?>尺寸为640*670<?php endif; ?></i> 
                                <div class="bg_he" <?php if($imgtwo["img_url"] != ''): ?>onclick="del('<?php echo ($imgtwo["id"]); ?>')"<?php endif; ?>></div>
                        </div>
                        <div class="upload clearfix"> 
                                <div class="up_btn clearfix">
                                    <input type="file" name="img<?php echo ($imgthree["id"]); ?>[]" id="gife_img3"  onchange="preview('gife_img3','img3')" style="left: 0px;width:100px;"/>
                                    <div class="btn_bg "><?php if($imgthree["img_url"] != ''): ?>编辑轮播图<?php else: ?>添加轮播图<?php endif; ?></div>
                                </div>
                                <i class="imgccc myimg" id="img3"><?php if($imgthree["img_url"] != ''): ?><img src="/web/Public/upload/Home//<?php echo ($imgthree["img_url"]); ?>"><?php else: ?>尺寸为640*670<?php endif; ?></i> 
                                <div class="bg_he" <?php if($imgthree["img_url"] != ''): ?>onclick="del('<?php echo ($imgthree["id"]); ?>')"<?php endif; ?>></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- 通用详情 -->
            <div class="ttt">
                <textarea name="content" id="editor" cols="30" rows="10"><?php echo ($list["content"]); ?></textarea>
            </div>
            <!--库存-->
            <div class="kc" style="display:none;">
            <p class="red_p">说明:请填写以下各种属性的库存量（单位/件）</p>
            	<?php if($arr["is_child"] != 0 ): ?><div class="wide_bvx">
					<?php if(is_array($arr["parent"])): foreach($arr["parent"] as $key=>$res): ?><p><?php echo ($res["name"]); ?></p>
					<input type="hidden" name="parent_<?php echo ($res["id"]); ?>" />
					<input type="hidden" name="is_child" value="1"/>
					<div class="whide_c">
						<?php if(is_array($res["child"])): foreach($res["child"] as $key=>$re): ?><span>
                        		<em><?php echo ($re["name"]); ?></em>
                        		<input type="text" name="child_<?php echo ($re["id"]); ?>_<?php echo ($res["id"]); ?>" value="<?php echo ($re["num"]); ?>" />
                    		</span><?php endforeach; endif; ?>	
					</div><?php endforeach; endif; ?>
				</div>				
				<?php else: ?>
				 <div class="wide_bvx">
				 	<p><?php echo ($arr["name"]); ?></p>
						<?php if(is_array($arr["child"])): foreach($arr["child"] as $key=>$res): ?><span>
                       		 	<em><?php echo ($res["name"]); ?></em>
                        		<input type="text" name="child_<?php echo ($res["id"]); ?>" value="<?php echo ($res["num"]); ?>" />
                    		</span><?php endforeach; endif; ?>	
				 </div><?php endif; ?>
            </div>
            <input type="hidden" name="id" value="<?php echo ($list["id"]); ?>">
               <!-- .nextb -->
            <div class="nextb" >保存</div>
            </form>
        </div>
    </body>
<script>
function del(id){
	$.messager.confirm('提示信息', '请您确认要删除该图片？删除操作不需要保存即可删除，请谨慎改操作', function(r){
		if(r==true){
			$.post('<?php echo U("Shop/del_img");?>',{id:id},function(res){
				if(res.status){
					window.location.href='';
				}else{
					$.messager.alert('提示信息', res.info,'error');
				}
			});
		}
	});
}
$('.nextb').click(function(){
		$('#formsubmit').submit();		
});
UE.getEditor('editor',{initialFrameHeight:350,autoHeightEnabled:false});
</script>
</html>