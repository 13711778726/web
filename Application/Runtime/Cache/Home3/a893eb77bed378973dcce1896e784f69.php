<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>列表</title>   
    <script type="text/javascript" src="/web/Public/static/Home3/js/My97DatePicker/WdatePicker.js"></script>     
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
</head>
<body>
<form name="form1" id="form1" method="post" action="<?php echo U('Present/presentlist');?>">
    <div class="wrap">        
        <div class="piliang_all">
            <div class="lliebiao">礼品列表</div>
            <!--引入分页-->
            <div class="bx_r">
                <div class="ttto">
                     <span class="numm"><em><?php if(is_array($page["quick_arr"])): foreach($page["quick_arr"] as $key=>$re): if($re["sel"] == 1): echo ($re["num"]); endif; endforeach; endif; ?></em>/<?php echo ($page["page_count"]); ?></span>
                     <span class="lolo"></span>
                     <span class="rrr" onclick="page('<?php echo ($page["url"]); ?>','<?php echo ($page["next"]); ?>','');"> > </span>
                     <span class="lll" onclick="page('<?php echo ($page["url"]); ?>','<?php echo ($page["prev"]); ?>','');"> < </span>
                     <!-- <span class="rrr" onclick="javascript:location.href='/web/Home3/<?php echo ($page["url"]); ?>?page=<?php echo ($page["next"]); ?>'"> > </span>
                     <span class="lll" onclick="javascript:location.href='/web/Home3/<?php echo ($page["url"]); ?>?page=<?php echo ($page["prev"]); ?>'"> < </span> -->
                </div>
                <div class="hie">
                    <div class="hie_bb">
                        <em>每页显示</em>
                        <input type="text" paceholder="请输入" onkeypress="if(event.keyCode==13){page('<?php echo ($page["url"]); ?>',1,this.value);}" value="<?php echo ($page["page_size"]); ?>"/>
                        <!-- <input type="text" paceholder="请输入" onkeypress="if(event.keyCode==13){window.location.href='/web/Home3/<?php echo ($page["url"]); ?>?page_size='+this.value+'&page=1';}" value="<?php echo ($page["page_size"]); ?>"/> -->
                        <em>条</em>
                    </div>
                     <div class="hie_bb">
                        <em>跳转到</em>
                        <input type="text" paceholder="请输入" onkeypress="if(event.keyCode==13){page('<?php echo ($page["url"]); ?>',this.value,'');}"  value="<?php echo ($page["page"]); ?>"/>
                        <!-- <input type="text" paceholder="请输入" value="<?php echo ($page["page"]); ?>" onkeypress="if(event.keyCode==13){window.location.href='/web/Home3/<?php echo ($page["url"]); ?>?page='+this.value;}" /> -->                       
                        <em>页</em>
                    </div>
                </div>
</div>
<script>
var page_now='<?php echo ($page["page"]); ?>';
var param='';
<?php if(is_array($select_data)): foreach($select_data as $key=>$value): ?>param += '&'+'<?php echo ($key); ?>' + '='+'<?php echo ($value); ?>';<?php endforeach; endif; ?>
//分页提交
function page(url,page,page_size){
	window.location.href="/web/Home3/"+url+"&page="+page+"&page_size="+page_size+"&param="+param;
}
</script>            
            <div class="bx_c">
                <div class="los">
                    <span class="searc"></span>
                    <input type="text" class="short_in" name="title" value="<?php echo ($select_data["title"]); ?>" placeholder="请输入礼品名称"/>
                    <span class="butt" onclick="post_data();">确定</span>
                    <span class="huanj"></span>
                </div>
            </div >
            <div class="bx_l"><a href='<?php echo U("Taoyuan/taoyshop");?>' target="_blank"><span class="span1"><em>淘源商城</em></span></a></div>
            <div class="bx_l">
                <span class="span1" onclick="javascript:location.href='<?php echo U("Present/addpresent");?>'" >
                    <em>添加礼品</em>
                </span>
            </div> 
        </div>
        <div class="mmain_box">
            <ul class="ul_one clearfix">
                <li class="one_six" style="width:5%;">序号</li>
                <li class="huiyuan" style="width:10%;">图标</li>
                <li class="nichen" style="width:12%;">名称</li>
                <li class="nichen" style="width:8%;">简称</li>
                <li class="huiyuan" style="width:8%;">库存</li>
                <li class="zhanghu" style="width:8%;">提现限制</li>
                <li class="huiyuan" style="width:8%;">单位</li>
                <li class="huiyuan" style="width:8%;">排序</li>
                <li class="li_on" style="width:25%;">详情</li>
                <li class="li_on" style="width:7%;">操作</li>
            </ul>
            <?php if(is_array($presentlist)): foreach($presentlist as $key=>$re): ?><ul class="ul_two clearfix">
                <li class="one_six" style="width:5%;"><?php echo ($key); ?></li>
                <li  class="huiyuan" style="width:10%;">
                    <div class="touxiang"><img src="/web/Public/upload/Home//<?php echo ($re["gife_img"]); ?>" width="50" height="50"></div>
                </li>
                <li class="nichen" style="width:12%;"><?php echo ($re["title"]); ?></li>
                <li class="nichen" style="width:8%;"><?php echo ($re["gifename"]); ?></li>
                <li  class="huiyuan" style="width:8%;"><?php echo ($re["gife_store"]); ?></li>
                <li  class="huiyuan" style="width:8%;"><?php echo ($re["tx_limit"]); ?></li>
                <li  class="huiyuan" style="width:8%;"><?php echo ($re["gife_unit"]); ?></li>
                <li  class="huiyuan" style="width:8%;"><?php echo ($re["o_order"]); ?></li>
                <li  class="huiyuan" style="width:25%;white-space:nowrap;overflow:hidden;text-overflow: ellipsis;"><?php echo ($re["desc"]); ?></li>
                <li class="li_on" style="width:7%;">
                    <div class="only_opar">
                        <span class="span_one" onclick="update_gife('<?php echo ($re["id"]); ?>')">
                            <em>编辑</em>
                        </span>                        
                        <span class="span_six" onclick="del('<?php echo ($re["id"]); ?>')">
                            <em>删除</em>
                        </span>
                    </div>
                </li>
            </ul><?php endforeach; endif; ?>            
        </div>
    </div>
</form> 
<script>
//修改礼品
function update_gife(id){
	window.location.href="<?php echo U('Present/updatepresent');?>?id="+id;
}
//单个删除
function del(id){
	$.messager.confirm('提示信息', '你确定删除该礼品?', function(r){
		if(r==true){
			$.post('<?php echo U('Present/presentdel');?>',{id:id},function(res){
				if(res.status){
					$.messager.alert('提示信息', res.info, 'info');
					window.location.href="<?php echo U('Present/presentlist');?>?param="+param+'&page='+page_now;
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