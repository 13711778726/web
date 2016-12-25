<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>礼品设置</title>   
    <link rel="stylesheet" type="text/css" href="/web/Public/static/Home3/css/base.css" />
<link rel="stylesheet" type="text/css" href="/web/Public/static/Home3/css/add_com.css" />
<link rel="stylesheet" type="text/css" href="/web/Public/static/Home3/css/index.css" />
<link rel="stylesheet" type="text/css" href="/web/Public/static/Home3/css/my_index.css" />
<link rel="stylesheet" type="text/css" href="/web/Public/static/Home3/css/gudinghongbao.css" />
<link rel="stylesheet" type="text/css" href="/web/Public/static/Home3/css/lipinziliao.css" />

<script type="text/javascript" src="/web/Public/static/Home3/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/web/Public/static/Home3/js/index.js"></script>
<script type="text/javascript" src="/web/Public/static/Home3/js/gudinghongbao.js"></script>



    <script type="text/javascript" src="/web/Public/static/Home3/js/gudinghongbao.js"></script>
    <link rel="stylesheet" type="text/css" href="/web/Public/static/Home3/css/icons.css"/>
<script type="text/javascript" src="/web/Public/static/Home3/js/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="/web/Public/static/Home3/js/easyui/locale/easyui-lang-zh_CN.js"></script>
<script type="text/javascript" src="/web/Public/static/Home3/js/formvalidator/formValidator.js"></script>
<script type="text/javascript" src="/web/Public/static/Home3/js/formvalidator/formValidatorRegex.js"></script>
<link rel="stylesheet" type="text/css" href="/web/Public/static/Home3/js/easyui/themes/bootstrap/easyui.css" title="gray" />
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
                    <li onclick="javascript:location.href='<?php echo U("Pack/updatepack");?>?pack_id=<?php echo ($pack_id); ?>'">
                        <p class="topic_z">主题设置</p>
                        <div class="yuanjiao">1</div>
                        <div class="xian"></div>
                    </li>
<!--                    <li onclick="javascript:location.href='<?php echo U("Pack/pack_com");?>?pack_id=<?php echo ($pack_id); ?>&set_type=2'">
                        <p class="topic_z">红包雨</p>
                        <div class="yuanjiao">2</div>
                        <div class="xian"></div>
                    </li>-->
                    <li onclick="javascript:location.href='<?php echo U("Pack/pack_com");?>?pack_id=<?php echo ($pack_id); ?>&set_type=0'">
                        <p class="topic_z">礼品设置</p>
                        <div class="yuanjiao <?php if($set_type == 2): ?>ccolor<?php endif; ?>">2</div>
                        <div class="xian"></div>
                    </li>
                    <li onclick="javascript:location.href='<?php echo U("Pack/pack_draw");?>?pack_id=<?php echo ($pack_id); ?>'">
                        <p class="topic_z bbloak">兑换设置</p>
                        <div class="yuanjiao ccolor">3</div>
                        <div class="xian ccolor"></div>
                        <div class="xian ccolor"></div>
                    </li>
                </ul>
            </div>
        </div>
        <!-- add -->
        <div class="add_box">
            <span class="spppan1" onclick="javascript:location.href='<?php echo U("Present/present_store");?>?pack_id=<?php echo ($pack_id); ?>&set_type=<?php echo ($set_type); ?>&con=pack_com'"><em style="font-size:20px;color:#fff;margin-right:5px;">+</em>去礼品库添加</span>
            <!-- <span class="spppan2"><em style="font-size:20px;color:#fff;margin-right:5px;">+</em>去淘源商城添加</span> -->
        </div>
        <!-- biaoge -->
        <div class="bioage">
            <ul class="u1">
                <li class="bianhao" style="width:15%;">礼品编号</li>
                <li class="bianhao" style="width:15%;">礼品名称</li>
                <li class="bianhao" style="width:15%;">数量</li>
                <li class="bianhao" style="width:15%;">中奖率(%)</li>
                <li class="bianhao" style="width:15%;">排序</li>
                <li class="bianhao" style="width:20%;">操作</li>
            </ul>           
            <?php if(is_array($pack_com_list)): foreach($pack_com_list as $key=>$re): ?><ul class="u2">
                <li class="bianhao" style="width:15%;"><input type="text" value="<?php echo ($re["id"]); ?>" readOnly=true /></li>
                <li class="bianhao" style="width:15%;"><input type="text" value="<?php echo ($re["gifename"]); ?>" readOnly=true /></li>
                <li class="bianhao" style="width:15%;"><input type="text" value="<?php echo ($re["num"]); ?>" name="num_<?php echo ($re["id"]); ?>" onblur="save_data('<?php echo ($re["id"]); ?>','num_<?php echo ($re["id"]); ?>')"/></li>
                <li class="bianhao" style="width:15%;"><input type="text" value="<?php echo ($re["win_rate"]); ?>" name="win_rate_<?php echo ($re["id"]); ?>" onblur="save_data('<?php echo ($re["id"]); ?>','win_rate_<?php echo ($re["id"]); ?>')"/></li>
                <li class="bianhao" style="width:15%;"><input type="text" value="<?php echo ($re["s_order"]); ?>" name="s_order_<?php echo ($re["id"]); ?>" onblur="save_data('<?php echo ($re["id"]); ?>','s_order_<?php echo ($re["id"]); ?>')"/></li>
                <li class="bianhao" style="width:20%;">
                    <div class="laji" onclick="del('<?php echo ($re["id"]); ?>')"></div>
                </li>
            </ul><?php endforeach; endif; ?>         
        </div>
        <!-- .nextb -->
        <div class="nextb">下一步</div>
    </div>
    <script>
    	$('.nextb').click(function(res){
    		var set_type='<?php echo ($set_type); ?>';
    		var pack_id='<?php echo ($pack_id); ?>';
    		if(set_type==2){
    			window.location.href="<?php echo U('Pack/pack_com');?>?pack_id="+pack_id+'&set_type=0';
    		}else{
    			window.location.href="<?php echo U('Pack/pack_draw');?>?pack_id="+pack_id;
    		}
    	});
    	function del(id){
    		$.messager.confirm('提示信息', '你确定删除该礼品?', function(r){
    			if(r==true){
		    		$.post('<?php echo U("Pack/del_com_gife");?>',{id:id},function(res){
		    			if(res.status){
		    				$.messager.alert('提示信息', res.info, 'info');
		    				window.location.href="";
		    			}else{
		    				$.messager.alert('提示信息', res.info, 'error');
		    			}
		    		});
    			}
    		});
    	}
    	function save_data(id,name){
    		var name_num=$('input[name="'+name+'"]').val();
    		$.messager.confirm('提示信息', '你确定修改该礼品?', function(r){
    			if(r==true){
		    		$.post('<?php echo U("Pack/update_com_gife");?>',{id:id,name:name,name_num:name_num},function(res){
		    			if(res.status){
		    				$.messager.alert('提示信息', res.info, 'info');
		    				window.location.href="";
		    			}else{
		    				$.messager.alert('提示信息', res.info, 'error');
		    			}
		    		});
    			}
    		});
    	}
    </script>
</body>
</html>