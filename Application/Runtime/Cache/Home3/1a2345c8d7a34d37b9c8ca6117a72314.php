<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>爆品文章</title>  
        <script type="text/javascript" src="/web/Public/static/Home3/js/article/jquery.js"></script>    
        <link rel="stylesheet" type="text/css" href="/web/Public/static/Home3/css/icons.css"/>
<script type="text/javascript" src="/web/Public/static/Home3/js/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="/web/Public/static/Home3/js/easyui/locale/easyui-lang-zh_CN.js"></script>
<script type="text/javascript" src="/web/Public/static/Home3/js/formvalidator/formValidator.js"></script>
<script type="text/javascript" src="/web/Public/static/Home3/js/formvalidator/formValidatorRegex.js"></script>
<link rel="stylesheet" type="text/css" href="/web/Public/static/Home3/js/easyui/themes/bootstrap/easyui.css" title="gray" />
        <link rel="stylesheet" type="text/css" href="/web/Public/static/Home3/css/article/base.css" />
    	<link rel="stylesheet" type="text/css" href="/web/Public/static/Home3/css/base.css" />
        <script type="text/javascript" src="/web/Public/static/Home3/js/article/article.js"></script>
		<link rel="stylesheet" type="text/css" href="/web/Public/static/Home3/css/taoarticle.css" />
		<link rel="stylesheet" type="text/css" href="/web/Public/static/Home3/css/base.css" />
    <link rel="stylesheet" type="text/css" href="/web/Public/static/Home3/css/index.css" />
    <link rel="stylesheet" type="text/css" href="/web/Public/static/Home3/css/artical.css" />
    </head>
    <body>
        <div class="wrap">
            <!-- header部分代码 -->
            <link rel="stylesheet" type="text/css" href="/web/Public/static/Home3/css/taoyshop.css" />
<link rel="stylesheet" type="text/css" href="/web/Public/static/Home3/css/taoarticle.css" />
<style type="text/css">
    ::-webkit-input-placeholder{color:#fff;}
    ::-moz-placeholder{color:#fff;}
    :-moz-placeholder{color:#fff;}
</style>
<div class="header">
    <div class="all_header" style="overflow:hidden;">
        <h1><a href="javascript:;"><img src="/web/Public/static/Home3/img/article/logining.png" height="41" width="119" alt="" /></a></h1>
                    <div class="search" style="width:280px">
                    <input type="text" style="width:245px" placeholder="搜索" name="keywords" id="keywords"  value="<?php echo ($data["name"]); ?>"/>
                    <span></span>
                </div>
                    <div class="twoffl">
                         <a class="helpw" href="">
                            <img src="/web/Public/static/Home3/img/article/helpb.png" alt="" />
                            <p>求助高级文案</p>
                         </a>
                         <a class="helpw nml" href="<?php echo U('add');?>">
                            <img src="/web/Public/static/Home3/img/article/attrb.png" alt="" />
                            <p>发表文章</p>
                         </a>
                        <a class="helpw nml" href="<?php echo U('add_cat');?>">
                            <img src="/web/Public/static/Home3/img/article/attrb.png" alt="" />
                            <p>添加爆品</p>
                        </a>
                    </div>
    </div>       
</div>
<script>
    //关键字搜索
    $('#keywords').keypress(function(event){
        var keycode = (event.keyCode ? event.keyCode : event.which);  
        if(keycode == '13'){  
            var keywords =     $('#keywords').val();
            if(keywords){
                url = "<?php echo U('taoarticle');?>"+"?keywords=" + keywords;
            }else{
                url = "<?php echo U('taoarticle');?>";
            }
            window.location.href = url;
        }  
    }); 
</script>
            <!-- 产品介绍代码 -->
            <div class="main_boxxx" style="margin:-30px auto;min-width:1024px;">
                <div class="main_obxl">
                    <div class="blkb_box bhbk">
                        <div class="bighe">
                            <span class="bighe_l">文章分类</span>
                            <span class="bighe_r"></span>
                        </div>
                        <ul>
                            <?php if(is_array($type_list)): foreach($type_list as $key=>$item): ?><li onclick="submit('<?php echo ($item["id"]); ?>')" <?php if($key%2 != 0): ?>class="mmon"<?php endif; ?>><?php echo ($item["name"]); ?></li><?php endforeach; endif; ?>
                        </ul>
                    </div>
                    <div class="blkb_box blbk">
                        <div class="bighe">
                            <span class="bighe_l">最新文章</span>
                            <span class="bighe_r">更多>></span>
                        </div>
                        <ul>
                            <li>食品养生保健养生养养生</li>
                            <li>食品养生保健养生养养生</li>
                            <li>食品养生保健养生养养生</li>
                            <li>食品养生保健养生养养生</li>
                            <li>食品养生保健养生养养生</li>
                            <li>食品养生保健养生养养生</li>
                        </ul>
                    </div>    
                </div>
                <div class="main_obxr">
                    <ul>
                        <?php if(is_array($list)): foreach($list as $key=>$item): ?><li>
                            <div class="pic" onclick="javascript:location.href='<?php echo U("info", "id=$item[id]");?>'">
                                <img src="<?php if(empty($item["img_url"])): ?>/web/Public/static/Home3/img/article/shop.gif<?php else: ?>/web/Public/upload/Home//<?php echo ($item["img_url"]); endif; ?>" alt="" width="130" height="78"/>
                            </div>
                            <div class="pw">
                                <p class="pb" onclick="javascript:location.href='<?php echo U("info", "id=$item[id]");?>'"><?php echo ($item["name"]); ?></p>
                                <p class="pl"><?php echo (date("Y-m-d H:i:s", $item["time"])); ?></p>
                                <div class="bianjilaji">
                                    <div class="baijjjj">
                                        <?php if($agent_id == 83): ?><div class="edit_menu chuchu" style="float:right;" onclick="javascript:location.href='<?php echo U("delete");?>?id=<?php echo ($item["id"]); ?>'"></div>
                                            <div style="height:25px;border-left:1px solid #dbd9d9;margin:0 8px;width:1px;float:right;"></div>
											<div class="edit_menu xiuxiu" style="float:right;" onclick="javascript:location.href='<?php echo U("edit", "id=$item[id]");?>'"></div><?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </li><?php endforeach; endif; ?>
                    </ul>
                </div>
            </div>
            <!-- 页脚 -->    
             <!-- 页脚 -->
        <div class="footer_a">
               <span class="span_first" data-page="1">首页</span>
                <span class="span1" data-page='<?php echo ($page["prev"]); ?>'>上一页</span>
                <ul> 
                    <?php if(is_array($page["quick_arr"])): foreach($page["quick_arr"] as $key=>$item): ?><li data-page="<?php echo ($item["num"]); ?>" <?php if($item["num"] == $item.sel): ?>class="onn"<?php endif; ?>><?php echo ($item["num"]); ?></li><?php endforeach; endif; ?>
                </ul>
                <span class="span2" data-page='<?php echo ($page["next"]); ?>'>下一页</span>
                <span class="span_last" data-page="<?php echo ($page["page_count"]); ?>">尾页</span>
        </div>       
        </div>
       
                <script>

     function submit(id){
         window.location.href="<?php echo U('Mode/taoarticle');?>?type="+id;
     }
        </script>
    </body>
</html>