$(window).ready(function() {
	/*左边菜单处理*/
	//处理菜单收缩开始
	$('#menu_list ul.menu_ul li.menu_ul_li ul').hide();
	//点击事件	
	$('#menu_list ul.menu_ul li.menu_ul_li div.menu_ul_li_box').click(function() {
	$(this).parents('.menu_ul').siblings('.menu_ul').find('.child_menu_ul').hide();
		var menu = $(this).parent().siblings();
        menu_ul = menu.find('ul');
        this_menu = $(this).parent();
        this_menu_ul = this_menu.find('ul');
	    //其他全部隐藏
	    menu_ul.hide();
	    if (this_menu_ul.is(":visible")) { //判断是否隐藏
	        this_menu_ul.hide();
	    } else {
	        this_menu_ul.show();
	    }
	});
});
