<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>陶源商城</title>      
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
        <link rel="stylesheet" type="text/css" href="/web/Public/static/Home3/css/taoyshop.css" />
        <script type="text/javascript" src="/web/Public/static/Home3/js/article/article.js"></script>
    </head>
    <body>
         <div class="wrap">
             <!-- 头部的代码 -->
             <!-- 头部的代码 -->
        <div class="header">
            <h1><a href="javascript:;"><img src="/web/Public/static/Home3/img/article/logo.png" height="41" width="119" alt="" /></a></h1>
            <div class="search">
                <input type="text" placeholder="搜索" name="keywords" id="keywords"  value="<?php echo ($data["keywords"]); ?>"/>
                <span></span>
            </div>
            <a class="hr"  href="<?php echo U('add');?>">
                <img src="/web/Public/static/Home3/img/article/login.png" height="42" width="42" alt="" />
                <p >上传产品</p>
            </a>
        </div>
        <script>
        //关键字搜索
        $('#keywords').keypress(function(event){  
     	  
         var keycode = (event.keyCode ? event.keyCode : event.which);  
         if(keycode == '13'){  
             var keywords =     $('#keywords').val();
             
             
             url = "<?php echo U('taoyshop');?>"+"?keywords=" + keywords;
             
             window.location.href = url;
         }  
     }); 
        </script>
               <!-- 选择代码 -->
<form method="get" action="<?php echo U('taoyshop');?>" name="theForm" id="theForm">
        <div class="choose">
            <span>地区</span>
            <span class="mm">:</span>
            <select name="province" id="province" onchange="loadArea(this.value,'city')">
               <?php if($data["province"] <= 0): ?><option value="-1" selected>省份/直辖市</option>
                <?php if(is_array($province)): foreach($province as $key=>$item): ?><option value="<?php echo ($item["area_id"]); ?>"><?php echo ($item["area_name"]); ?></option><?php endforeach; endif; ?>
               <?php else: ?>
               		<option value="-1">省份/直辖市</option>
                	<?php if(is_array($province)): foreach($province as $key=>$item): ?><option value="<?php echo ($item["area_id"]); ?>" <?php if(($item["area_id"]) == $data["province"]): ?>selected<?php endif; ?>><?php echo ($item["area_name"]); ?></option><?php endforeach; endif; endif; ?>
            </select>
            <span class="mm">省</span>
            <select name="city" id="city" onchange="loadArea(this.value,'district')">
            <?php if($data["province"] <= 0): ?><option value="-1">市/县</option>
            <?php else: ?>
            		<option value="-1">市/县</option>
                	<?php if(is_array($city)): foreach($city as $key=>$item): ?><option value="<?php echo ($item["area_id"]); ?>" <?php if(($item["area_id"]) == $data["city"]): ?>selected<?php endif; ?>><?php echo ($item["area_name"]); ?></option><?php endforeach; endif; endif; ?>
            </select>
            <span class="mm">市</span>
            <select name="district" id="district" onchange="loadArea(this.value,'null')">
             <?php if($data["city"] <= 0): ?><option value="-1">镇/区</option>
             <?php else: ?>
             		<option value="-1">镇/区</option>
                	<?php if(is_array($district)): foreach($district as $key=>$item): ?><option value="<?php echo ($item["area_id"]); ?>" <?php if(($item["area_id"]) == $data["district"]): ?>selected<?php endif; ?>><?php echo ($item["area_name"]); ?></option><?php endforeach; endif; endif; ?>
            </select>
            <span class="mm mc">县区</span>
            <span class="mm">价格</span>
            <input type="text" placeholder="最小值" class="bd" value="<?php echo ($data["min_price"]); ?>" name="min_price" />
            <span>-</span>
             <input type="text" placeholder="最大值" name="max_price" value="<?php echo ($data["max_price"]); ?>"  class="bd"/>
            <input type="checkbox" class="cb" name="pinkage" value="1" <?php if(($data["pinkage"]) == "1"): ?>checked<?php endif; ?> />
            <span  class="mm">包邮</span>
            
            <INPUT type="hidden" name="type" id="tid" value="0" />
            <input type="hidden" name="keywords" value="<?php echo ($data["keywords"]); ?>" />
            
            <span class="ss" onclick="submit()">搜索</span>
        </div>
        </form>
                <!-- 产品展示 -->
                <div class="main">
                    <div class="main_l">
                <ul>
                    <?php if(is_array($goods_type_list)): foreach($goods_type_list as $key=>$item): ?><li data-tid="<?php echo ($item["id"]); ?>" <?php if(($data["type"]) == $item["id"]): ?>class="on"<?php endif; ?>><?php echo ($item["name"]); ?></li><?php endforeach; endif; ?>
                </ul>
            </div>
                    <div class="main_r">
                        <ul>
                            <?php if(is_array($goods_list)): foreach($goods_list as $key=>$item): ?><li onclick="javascript:location.href='<?php echo U("info", "good_id=$item[id]");?>'">
                                <div class="fpic">
                                    <img src='<?php if(empty($item["img_url"])): ?>/web/Public/static/Home3/img/article/shop.gif<?php else: ?>/web/Public/upload/Home//<?php echo ($item["img_url"]); endif; ?>' alt="" />
                                </div>
                                <div class="address_and">
                                    <span class="address_andl"><?php echo ($item["agent_name"]); ?></span>
                                    <span class="address_andr"><?php if($item["shipping_scope"] == 1): ?>全国地区<?php else: echo ($item["scope_name"]); endif; ?></span>
                                </div>
                                <p class="childrens"><?php echo ($item["title"]); ?></p>
                                <div class="pricess">
                                    <span class="red_pricess"><em>￥</em><?php echo ($item["price"]); ?></span>
                                    <?php if($item["pinkage"] == 1): ?><span class="baoyou">包邮</span><?php endif; ?>
                                </div>
                            </li><?php endforeach; endif; ?>   

                        </ul>
                    </div>
                </div>
                <!-- 页脚 -->
                <!-- 页脚 -->
        <div class="footer">
               <span class="span_first" data-page="1" onclick="page('<?php echo ($page["url"]); ?>','<?php echo ($page["quick_start"]); ?>');">首页</span>
                <span class="spant" data-page='<?php echo ($page["prev"]); ?>' onclick="page('<?php echo ($page["url"]); ?>','<?php echo ($page["prev"]); ?>');">上一页</span>
                <ul> 
                    <?php if(is_array($page["quick_arr"])): foreach($page["quick_arr"] as $key=>$item): ?><li data-page="<?php echo ($item["num"]); ?>" <?php if($item["num"] == $item.sel): ?>class="onn"<?php endif; ?> onclick="page('<?php echo ($page["url"]); ?>','<?php echo ($item["num"]); ?>');"><?php echo ($item["num"]); ?></li><?php endforeach; endif; ?>
                </ul>
                <span class="spanb" data-page='<?php echo ($page["next"]); ?>' onclick="page('<?php echo ($page["url"]); ?>','<?php echo ($page["next"]); ?>','');">下一页</span>
                <span class="span_last" data-page="<?php echo ($page["page_count"]); ?>" onclick="page('<?php echo ($page["url"]); ?>','<?php echo ($page["quick_end"]); ?>');">尾页</span>
                </div>
<script>
var page_now='<?php echo ($page["page"]); ?>';
var param='';
<?php if(is_array($data)): foreach($data as $key=>$value): ?>param += '&'+'<?php echo ($key); ?>' + '='+'<?php echo ($value); ?>';<?php endforeach; endif; ?>
//分页提交
function page(url,page){
	window.location.href="/web/Home3/"+url+"&page="+page+"&param="+param;
}
</script>  
         </div>
        <script>
           
	var ajaxurl = "<?php echo U('getArea');?>";

   function loadArea(areaId,areaType) {
	    $.post(ajaxurl,{'areaId':areaId},function(data){
	        if(areaType=='city'){
	           $('#'+areaType).html('<option value="-1">市/县</option>');
	           $('#district').html('<option value="-1">镇/区</option>');
	        }else if(areaType=='district'){
	           $('#'+areaType).html('<option value="-1">镇/区</option>');
	        }
	        if(areaType!='null'){
	            $.each(data,function(no,items){
	            	 opt = $("<option/>").text(items.area_name).attr("value", items.area_id);
	                $('#'+areaType).append(opt);
	            });
	         
	        }
	    });
	} 
   
   function submit() {
	   $("#theForm").submit();
   }
   //分类跳转
   $(".main_l li").click(function(event) {
	   var tid = $(this).data('tid');
	   
	   $("#tid").val(tid);
	   
	   $("#theForm").submit();
	   
   }
		   
   );  

</script>
    </body>
</html>