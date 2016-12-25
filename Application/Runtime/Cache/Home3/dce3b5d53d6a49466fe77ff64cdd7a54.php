<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>数据统计</title>
    <link rel="stylesheet" type="text/css" href="/web/Public/static/Home3/css/shuju.css"/>
    <link rel="stylesheet" type="text/css" href="/web/Public/static/Home3/css/base.css" />
<link rel="stylesheet" type="text/css" href="/web/Public/static/Home3/css/add_com.css" />
<link rel="stylesheet" type="text/css" href="/web/Public/static/Home3/css/index.css" />
<link rel="stylesheet" type="text/css" href="/web/Public/static/Home3/css/my_index.css" />
<link rel="stylesheet" type="text/css" href="/web/Public/static/Home3/css/gudinghongbao.css" />
<link rel="stylesheet" type="text/css" href="/web/Public/static/Home3/css/lipinziliao.css" />

<script type="text/javascript" src="/web/Public/static/Home3/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/web/Public/static/Home3/js/index.js"></script>
<script type="text/javascript" src="/web/Public/static/Home3/js/gudinghongbao.js"></script>



</head>
<body>
    <div class="wrap">
        
        <div class="shuju">今日数据</div>
        <div class="big_box">
            <ul>
                <li>
                    <p class="p11">今日支出(元)</p>
                    <p class="momey"><a href="<?php echo U('merchant/merasset');?>" style='color:#fff'><?php echo ($info["integral_pay"]); ?></a>元</p>
                </li>
                 <li>
                    <p class="p11">提现申请(个)</p>
                    <p class="momey"><a href="<?php echo U('User/userdraw');?>" style="color:#fff"><?php echo ($info["drawcount"]); ?></a></p>
                </li>
                 <li>
                    <p class="p11">新增用户(位)</p>
                    <p class="momey"><?php echo ($info["usercount"]); ?></p>
                </li>
                 <li>
                    <p class="p11">红包转发(次)</p>
                    <p class="momey"><?php echo ($info["packcount"]); ?></p>
                </li>
                 <!-- <li>
                    <p class="p11">红包转00发(次)</p>
                    <p class="momey">2399</p>
                </li> -->
            </ul>
             <!-- <ul>
                <li>
                    <p class="p11">今日支出(元)</p>
                    <p class="momey">5.23万</p>
                </li>
                 <li>
                    <p class="p11">提现申请(个)</p>
                    <p class="momey">2333</p>
                </li>
                 <li>
                    <p class="p11">新增用户(位)</p>
                    <p class="momey">0</p>
                </li>
                 <li>
                    <p class="p11">红包转发(次)</p>
                    <p class="momey">233</p>
                </li>
                 <li>
                    <p class="p11">红包转00发(次)</p>
                    <p class="momey">2399</p>
                </li>
            </ul> -->
        </div>
        <div class="shuju">账号数据</div>
        <div class="zhanghao">
            <div class="vb">
                <div class="bg_iimg"></div>
                <div class="wez">
                    <p class="jieyu">账户结余</p>
                    <p class="wwan"><span><?php echo ($acctinfo["integral"]); ?></span>元</p>
                </div>
            </div>
            <div class="vb vb2">
                <div class="bg_iimg"></div>
                <div class="wez">
                    <p class="jieyu">总用户数</p>
                    <p class="wwan"><span class="pan1"><?php echo ($info["usernum"]); ?></span>位</p>
                </div>
            </div>
            <div class="vb vb3">
                <div class="bg_iimg"></div>
                <div class="wez">
                    <p class="jieyu">红包总转发数</p>
                    <p class="wwan"><span class="pan2"><?php echo ($info["packnum"]); ?></span>次</p>
                </div>
            </div>
            <div class="vb vb4">
                <div class="bg_iimg"></div>
                <div class="wez">
                    <p class="jieyu">流量卡库存</p>
                    <p class="wwan"><span class="pan3" onclick="javascript:location.href='<?php echo U("Lcard/cardlist");?>'"><?php echo ($lcard_info["total_count"]); ?></span>张</p>
                </div>
            </div>
            <div class="vb vb5">
                <div class="bg_iimg"></div>
                <div class="wez">
                    <p class="jieyu">话费卡库存</p>
                    <p class="wwan"><span class="pan4" onclick="javascript:location.href='<?php echo U("Hcard/cardlist");?>'"><?php echo ($hcard_info["total_count"]); ?></span>张</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>