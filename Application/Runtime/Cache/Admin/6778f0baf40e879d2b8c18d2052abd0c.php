<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Insert title here</title>
<link rel="stylesheet" type="text/css" href="/Public/static/Admin/css/common.css" />
<script type="text/javascript" src="/Public/static/Admin/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/Public/static/Admin/js/common.js"></script>
</head>
<body>
	<div class="left_menu_mian">
		<div class="left_menu_box" id="menu_list">
			<ul class="menu_ul">
				<div class="parent_menu_li">
					<s></s>
					<li class="menu_ul_li">
						<div class="menu_ul_li_box">
							<span class="menu_title">帐号管理</span>
						</div>	
							<ul class="child_menu_ul">
								<li><a href="<?php echo U('Admin/adminlist');?>" target="mainFrame">管理员列表</a></li>
								<div class="li_nav"></div>
								<li>权限管理</li>
								<div class="li_nav"></div>
							</ul>						
					</li>
				</div>					
			</ul>
			<ul class="menu_ul">
				<div class="parent_menu_li">
					<s></s>
					<li class="menu_ul_li">
						<div class="menu_ul_li_box">
							<span class="menu_title">用户管理</span>
						</div>	
							<ul class="child_menu_ul">
								<li>用户列表</li>
								<div class="li_nav"></div>
								<li>记录列表</li>
								<div class="li_nav"></div>
							</ul>						
					</li>
				</div>					
			</ul>
		</div>
	</div>
</body>
</html>