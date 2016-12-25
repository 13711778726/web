<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<title>提示信息</title>
<script type="text/javascript" src="/web/Public/static/Home3/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/web/Public/static/Home3/js/js.js"></script>
<script type="text/javascript" src="/web/Public/static/Home3/js/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="/web/Public/static/Home3/js/easyui/locale/easyui-lang-zh_CN.js"></script>
<script type="text/javascript" src="/web/Public/static/Home3/js/formvalidator/formValidator.js"></script>
<script type="text/javascript" src="/web/Public/static/Home3/js/formvalidator/formValidatorRegex.js"></script>
<link rel="stylesheet" type="text/css" href="/web/Public/static/Home3/js/easyui/themes/bootstrap/easyui.css" title="gray" />
<style type="text/css">
a{color:#08c;text-decoration:none}
a:hover,a:focus{color:#005580;text-decoration:underline}
</style>
</head>
<body>
<div class="easyui-window" title="提示信息" style="width:380px;height:200px" data-options="iconCls:'',modal:false,resizable:false,collapsible:false,minimizable:false,maximizable:false,closable:false">
<div style="font-size:18px;text-align:center;margin-top:40px">
	<?php if(isset($message)): ?><p class="success"><?php echo ($message); ?></p>
	<?php else: ?>
		<p class="error"><?php echo ($error); ?></p><?php endif; ?>
	<p style="font-size:12px">
		页面自动 <a id="href" href="<?php echo ($jumpUrl); ?>">跳转</a> 等待时间： <b id="wait"><?php echo ($waitSecond); ?></b>
	</p>
</div>
</div>
<script type="text/javascript">
(function(){
var wait = document.getElementById('wait'),href = document.getElementById('href').href;
var interval = setInterval(function(){
	var time = --wait.innerHTML;
	if(time <= 0) {
		location.href = href;
		clearInterval(interval);
	};
}, 1000);
})();
</script>
</body>
</html>