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
<form name="form1" id="form1" method="post" action="<?php echo U('User/userlist');?>">
    <div class="wrap">        
        <div class="liebiao">
            <ul>
                <li class="on" onclick="javascript:location.href='<?php echo U("User/userlist");?>'">用户列表</li>
                <li onclick="javascript:location.href='<?php echo U("User/usercheck");?>'">用户账单</li>
                <li onclick="javascript:location.href='<?php echo U("User/userdraw");?>'">用户提现</li>
            </ul>
        </div>
        <div class="piliang_all">
            <div class="lliebiao">用户列表</div>
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
                    <input type="text" class="short_in" name="nick" value="<?php echo ($select_data["nick"]); ?>" placeholder="请输入用户昵称"/>
                    <span class="butt" onclick="post_data();">确定</span>
                    <span class="huanj"></span>
                </div>
                <div  class="opo" style="top:48px;">
                    <div class="bbo">
                            <span class="wenz">会员编号:</span>
                            <input type="text" class="erji1" name="user_id" value="<?php echo ($select_data["user_id"]); ?>"/>
                    </div>
                    <div class="bbo">
                            <span class="wenz">手机号:</span>
                             <input type="text" class="erji1" name="username" value="<?php echo ($select_data["username"]); ?>"/>
                    </div>
                    <div class="bbo">
                             <span class="wenz">注册时间:</span>
                             <span class="ttiime" style="background:#fff;"><img src="/web/Public/static/Home3/img/datePicker.gif"></span>
                             <!-- <input class="erji11" type="text" name="createtime" value="<?php echo ($select_data["createtime"]); ?>" name="end_time" onfocus="WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'2008-03-08 11:30:00'})" > -->
                             <input type="text" class="erji11" name="createtime" value="<?php echo ($select_data["createtime"]); ?>" id="createtime" onclick="WdatePicker({el:'createtime'})"/>
                             
                    </div>
                    <div class="bbo">
                            <span class="wenz">状态:</span>
                            <select name="enable" id="two" class="erji">
                                <option value="-1" <?php if(($select_data["enable"]) == "-1"): ?>selected="selected"<?php endif; ?>>请选择</option>
                                <option value="1" <?php if(($select_data["enable"]) == "1"): ?>selected="selected"<?php endif; ?>>激活</option>
                                <option value="0" <?php if(($select_data["enable"]) == "0"): ?>selected="selected"<?php endif; ?>>未激活</option>
                            </select>
                    </div>
                    <div class="bbo">
                            <span class="wenz">用户所属:</span>
                            <select name="agent_id" id="two" class="erji">
                            <?php if(is_array($child)): foreach($child as $key=>$re): ?><option value="<?php echo ($re["decode_id"]); ?>" <?php if(($re["decode_id"]) == $select_data["agent_id"]): ?>selected="selected"<?php endif; ?>><?php echo ($re["mer_name"]); ?></option><?php endforeach; endif; ?>                               
                            </select>
                    </div>
                </div>
            </div>
            <div class="bx_l" style="margin-top:30px;">
                <!-- <span class="span1">
                    <em>批量提现</em>
                </span> -->
                <!-- <span class="span2">
                    <em>批量充值</em>
                </span> -->
                <span class="span3" onclick="enableall(0)">
                    <em>批量冻结</em>
                </span>
                <span class="span4" onclick="enableall(1)">
                    <em>批量激活</em>
                </span>
                <span class="span5">
                    <em>批量删除</em>
                </span>
            </div>
            
        </div>
        <div class="mmain_box">
            <ul class="ul_one clearfix">
                <!-- <li class="ii_b">
                    <input type="checkbox" class="checkbox1" />
                </li> -->
                <li class="one_six" style="width:4%;">序号</li>
                <li class="huiyuan" style="width:6%;">会员编号</li>
                <li class="huiyuan" style="width:6%;">头像</li>
                <li class="nichen" style="width:11%;">昵称</li>
                <li class="nichen" style="width:10%;">手机号码</li>
                <li class="huiyuan" style="width:10%;">注册时间</li>
                <li class="zhanghu" style="width:15%;">账户</li>
                <li class="huiyuan" style="width:8%;">状态</li>
                <li class="qita" style="width:16%;">其他信息</li>
                <li class="li_on" style="width:13%;">操作</li>
            </ul>
            <?php if(is_array($userlist)): foreach($userlist as $key=>$re): ?><ul class="ul_two clearfix">
                <!-- <li class="ii_b">
                    <input type="checkbox" class="checkbox2" name="id[]" value="<?php echo ($re["id"]); ?>"/>
                </li> -->
                <li class="one_six" style="width:4%;"><?php echo ($key); ?></li>
                <li class="huiyuan" style="width:6%;"><?php echo ($re["id"]); ?></li>
                <li  class="huiyuan" style="width:6%;">
                    <div class="touxiang"><img src="<?php echo ($re["user_pic"]); ?>" width="50"/></div>
                </li>
                <li class="nichen" style="width:11%;white-space:nowrap;overflow:hidden;text-overflow: ellipsis;"><?php echo ($re["nick"]); ?></li>
                <li class="nichen" style="width:10%;"><?php echo ($re["username"]); ?></li>
                <li  class="huiyuan" style="width:10%;"><?php echo ($re["createtime"]); ?></li>
                <li  class="zhanghu" style="width:15%;"><?php if($re["gifeinfo"] != ''): if(is_array($re["gifeinfo"])): foreach($re["gifeinfo"] as $key=>$res): echo ($res["gifename"]); echo ($res["balance"]); echo ($res["gife_unit"]); ?>，<?php endforeach; endif; else: ?>暂无任何礼品<?php endif; ?></li>
                <li class="huiyuan" style="width:8%;"><?php if($re["enable"] == 1): ?>已激活<?php else: ?>已冻结<?php endif; ?></li>
                <li class="qita" style="width:16%;"><?php if($re["useraddress"] != ''): if(is_array($re["useraddress"])): foreach($re["useraddress"] as $key=>$res): ?>联系人：<?php echo ($res["username"]); ?>联系号码：<?php echo ($res["phone"]); ?>地址：<?php echo ($res["address"]); endforeach; endif; else: ?>暂无信息<?php endif; ?></li>
                <li class="li_on" style="width:13%;">
                    <div class="only_opar">
                        <!-- <span class="span_one">
                            <em>编辑</em>
                        </span> -->
                        <?php if($re["enable"] == 0): ?><span class="span_two" onclick="enable('<?php echo ($re["id"]); ?>',1)">
                             <em>激活</em>
                        </span>
                            <?php elseif($re["enable"] == 1): ?>
                        <span class="span_three" onclick="enable('<?php echo ($re["id"]); ?>',0)">
                            <em >冻结</em>
                        </span><?php endif; ?>
                        <span class="span_four" onclick="userpay('<?php echo ($re["id"]); ?>')">
                            <em>充值</em>
                        </span>
                        <!-- <span class="span_five">
                            <em>提现</em>
                        </span> -->
                        <span class="span_six" onclick="deluser('<?php echo ($re["id"]); ?>')">
                            <em>删除</em>
                        </span>
                    </div>
                </li>
            </ul><?php endforeach; endif; ?>            
        </div>
    </div>
</form> 
<!--用户充值-->
<div id="pay_user_dialog" class="easyui-dialog" title="用户充值" data-options="modal:true,closed:true,iconCls:'icons-application-application_edit',buttons:[{text:'确定',iconCls:'icons-other-tick',handler:function(){$('#pay_user_dialog_form').submit();}},{text:'取消',iconCls:'icons-arrow-cross',handler:function(){$('#pay_user_dialog').dialog('close');}}]" style="width:300px;height:250px;"></div>

<script>
//获取所选择选择框内容(id)
/* function plcheck(){
	  var str='';
      $("input[name='id[]']:checked").each(function(){
             str +=$(this).val()+",";
      });
      return str;
} */
//用户充值
function userpay(id){
	$('#pay_user_dialog').dialog({href:'<?php echo U('userpay');?>?id='+id});
	$('#pay_user_dialog').dialog('open');
}
//批量删除
$('.span5').click(function(event) {
		$.messager.confirm('提示信息', '请您确认已经通过搜索查找您要删除的内容，请谨慎该操作以免给你带来不必要的麻烦', function(r){
			if(r){
				$.post('<?php echo U('User/userdel');?>?param='+param,function(res){
					if(res.status){
						$.messager.alert('提示信息', res.info, 'info');
						window.location.href="<?php echo U('User/userlist');?>?param="+param+'&page='+page_now;
					}else{
						$.messager.alert('提示信息', res.info, 'error');
					}
				});
				
			}
		});	
});
//单个删除
function deluser(id){
	$.messager.confirm('提示信息', '你确定删除该用户?', function(r){
		if(r==true){
			$.post('<?php echo U('User/userdel');?>',{id:id},function(res){
				if(res.status){
					$.messager.alert('提示信息', res.info, 'info');
					window.location.href="<?php echo U('User/userlist');?>?param="+param+'&page='+page_now;
				}else{
					$.messager.alert('提示信息', res.info, 'error');
				}
			});
		}
	});	
}
//批量激活、冻结
function enableall(status){
	$.messager.confirm('提示信息', '请您确认已经通过搜索查找您要操作的内容，请谨慎该操作以免给你带来不必要的麻烦?', function(r){
		if(r==true){
			$.post('<?php echo U('User/userenable');?>?param='+param,{status:status},function(res){
				if(res.status){				
					window.location.href="<?php echo U('User/userlist');?>?param="+param+'&page='+page_now;
				}else{
					$.messager.alert('提示信息', res.info, 'error');
				}
			});
		}
	});
}
//激活、冻结(单个)
function enable(id,status){
	$.post('<?php echo U('User/userenable');?>',{id:id,status:status},function(res){
			if(res.status){				
				window.location.href="<?php echo U('User/userlist');?>?param="+param+'&page='+page_now;
			}else{
				$.messager.alert('提示信息', res.info, 'error');
			}
	});
}
</script>   
</body>
</html>