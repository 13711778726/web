<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="/web/Public/static/Home3/css/base.css" />
    <link rel="stylesheet" type="text/css" href="/web/Public/static/Home3/css/index.css" />
    <script type="text/javascript" src="/web/Public/static/Home3/js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="/web/Public/static/Home3/js/index.js"></script>
    <script>
    function change(menu){
        window.location.href="<?php echo U('index/top');?>?menu="+menu;
    }
</script>
</head>
<div class="long_all" style="width:100%;background:#ced2d4;">
    <div class="wrap" style="width:80%">
        <div class="header">
                    <div class="logo">
                        <div class="logo_img">
                            <img src="/web/Public/static/Home3/img/logo.png" height="45" width="45" alt="" />
                        </div>
                        <div class="welcome">
                            <p>Hi!<span class="user_name"><?php echo ($acctinfo["mer_name"]); ?></span></p>
                            <p class="qiehuan">[<a href="<?php echo U('Tool/logout');?>" target="_top">切换用户</a>]</p>
                        </div>
                    </div>
                    <div class="h_c">
                        <ul>
                            <?php if($acct_show == 0): ?><li <?php if($menu == 1): ?>class="yingyong"<?php endif; ?>><a onclick="change('1')" href="<?php echo U('Index/center');?>" target="mainFrame" >应用</a></li><?php endif; ?>
							<?php if($acct_show == 0): ?><li <?php if($menu == 2): ?>class="yingyong"<?php endif; ?>><a onclick="change('2')" href="<?php echo U('Index/service');?>" target="mainFrame">服务</a></li><?php endif; ?>
                            <li <?php if($menu == 6): ?>class="yingyong"<?php endif; ?>><a onclick="change('6')" href="<?php echo U('Index/data');?>" target="mainFrame">数据</a></li>
                            <?php if($acct_show == 0): ?><li <?php if($menu == 3): ?>class="yingyong"<?php endif; ?>><a onclick="change('3')" href="<?php echo U('Present/presentlist');?>" target="mainFrame">礼品</a></li>
                            <li <?php if($menu == 4): ?>class="yingyong"<?php endif; ?>><a onclick="change('4')" href="<?php echo U('User/userlist');?>" target="mainFrame">用户</a></li><?php endif; ?>
                            <li <?php if($menu == 5): ?>class="yingyong"<?php endif; ?>><a onclick="change('5')" <?php if($acct_show == 0): ?>href="<?php echo U('Cooperation/unionlist');?>" <?php else: ?> href="<?php echo U('Merchant/merchantlist');?>"<?php endif; ?> target="mainFrame">商家</a></li>
                            <?php if($acct_show == 0): ?><li <?php if($menu == 7): ?>class="yingyong"<?php endif; ?>><a onclick="change('7')" href="<?php echo U('Shop/goodslist');?>" target="mainFrame">商城</a></li><?php endif; ?>
                            <?php if($acct_show != 0): ?><li <?php if($menu == 8): ?>class="yingyong"<?php endif; ?>><a onclick="change('8')" href="<?php echo U('Order/orderlist');?>" target="mainFrame" >订单</a></li><?php endif; ?>
                            <!-- <?php if($acct_show != 0): ?><li <?php if($menu == 9): ?>class="yingyong"<?php endif; ?>><a onclick="change('9')" href="<?php echo U('Index/center');?>" target="mainFrame" >下单</a></li><?php endif; ?> -->
                        </ul>
                    </div>
                    <div class="h_r">设置
                        <div class="sb_box">
                            <ul>
                                <li><a href="<?php echo U('edit');?>" target="mainFrame" >基本资料</a></li>
                                <li>操作日志</li>
                                <li>退出</li>
                            </ul>
                        </div>
                    </div>
        </div>
    </div>
</div>