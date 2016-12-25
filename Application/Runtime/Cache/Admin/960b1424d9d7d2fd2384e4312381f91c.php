<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<script type="text/javascript" src="/Public/static/Admin/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/Public/static/Admin/js/jquery-easyui-1.5/jquery.easyui.min.js"></script>
<!-- <script type="text/javascript" src="/Public/static/Admin/js/easyui/locale/easyui-lang-zh_CN.js"></script> -->
<!-- <script type="text/javascript" src="/Public/static/Admin/js/formvalidator/formValidator.js"></script>
<script type="text/javascript" src="/Public/static/Admin/js/formvalidator/formValidatorRegex.js"></script> -->
<link rel="stylesheet" type="text/css" href="/Public/static/Admin/js/jquery-easyui-1.5/themes/default/easyui.css" title="gray" />
<link rel="stylesheet" type="text/css" href="/Public/static/Admin/js/jquery-easyui-1.5/themes/icon.css"/>
<link rel="stylesheet" type="text/css" href="/Public/static/Admin/css/icons.css"/>

<title>Insert title here</title>
</head>
<body>
<div class="page-header">
     <h2>账户管理<small>->账户列表</small></h2>  
</div>
<div class="row">
        <div class="col-xs-12">
        	 <form id="tb" class="easyui-form" data-options="novalidate:true" style="margin-bottom: 10px;">
                <table>
                    <tr>
                        <!-- <td>所属活动:</td>
                        <td>
                            <select id="type" class="easyui-combobox"
                                    data-options="panelHeight:'auto',value:2">
                                <option value="2">投票活动</option>
                            </select>
                        </td> -->
                        <td>账户名称:</td> 
                        <td><input type="text" class="easyui-textbox" id="name" name="name" /></td>                     
                        <td>手机号码:</td> 
                        <td><input type="text" class="easyui-textbox" id="tel" name="tel" /></td>                     
                        <td>&emsp;
                            <a onclick="searchGrid()" href="javascript:void(0)"
                               class="easyui-linkbutton">查询</a>
                        </td>
                    </tr>
                </table>
            </form>
            <table id="grid" style="width:100%;height:600px">
            </table>
        </div>
</div>
<div id="window" class="easyui-window" style="padding: 10px"
         data-options="modal:true,minimizable:false,maximizable:false,collapsible:false,closed:true">
        <form id="ff" class="easyui-form" method="post" data-options="novalidate:true" enctype="multipart/form-data">
            <table cellpadding="5">
                <!-- <tr>
                    <td>所属活动:</td>
                    <td colspan="3" style="padding: 5px 0;">
                        <select class="easyui-combobox" name="type" data-options="panelHeight:'auto',required:true,editable:false">
                            <option value="2">投票活动</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>投票类型:</td>
                    <td colspan="3" style="padding: 5px 0;">
                        <select class="easyui-combobox" name="objectType" data-options="panelHeight:'auto',required:true,editable:false">
                            <option value="1">up主</option>
                            <option value="2">视频</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>状态:</td>
                    <td colspan="3" style="padding: 5px 0;">
                        <select class="easyui-combobox" name="status" data-options="panelHeight:'auto',required:true,editable:false">
                            <option value="1">正常</option>
                            <option value="2">异常</option>
                            <option value="3">系统票</option>
                        </select>
                    </td>
                </tr> -->                
                <tr>
                    <td>账户名称:</td>
                    <td colspan="3" style="padding: 5px 0;">
                        <input class="easyui-textbox" name="name"
                               data-options="required:true"/>
                    </td>
                </tr> 
                <tr>
                    <td>密码:</td>
                    <td colspan="3" style="padding: 5px 0;">
                        <input class="easyui-textbox" name="password"
                               data-options="required:true"/>
                    </td>
                </tr>              
                <tr>
                    <td>邮箱:</td>
                    <td colspan="3" style="padding: 5px 0;">
                        <input class="easyui-textbox" name="email"
                               data-options="required:true"/>
                    </td>
                </tr>
                <tr>
                    <td>手机:</td>
                    <td colspan="3" style="padding: 5px 0;">
                        <input class="easyui-textbox" name="tel"
                               data-options="required:true"/>
                    </td>
                </tr>               
            </table>
        </form>
        <div style="text-align:center;padding:5px">
            <a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitForm()">提交</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" onclick="clearForm()">重置</a>
        </div>
    </div>
<script type="text/javascript">	
$('#grid').datagrid({
    title: '帐号管理',
    method: 'get',
    //rownumbers: true,
    pagination: true,
    pageSize: 20,
    //fit:true,
    width: '99%',
    height: 'auto',
    fitColumns: true,
    iconCls:'icon-edit',
    singleSelect:false,//是否单选
    frozenColumns:[[ 
         {field:'ck',checkbox:true} 
    ]],
    url:"<?php echo U('Admin/adminlistAjax');?>",
    onBeforeLoad: function (param) {
     /* param.start = ((param.page - 1) * param.page_size) < 0 ? 0 : ((param.page - 1) * param.page_size);
     param.limit = param.page_size; */
    },
    toolbar: [{ 
        text: '添加', 
        iconCls: 'icon-add', 
        handler: function() { 
        	add();
        } 
    },/* '-', { 
        text: '修改', 
        iconCls: 'icon-edit', 
        handler: function() { 
            openDialog("add_dialog","edit"); 
        } 
    }, '-',{ 
        text: '删除', 
        iconCls: 'icon-remove', 
        handler: function(){ 
            delAppInfo(); 
        } 
    } */],
    columns: [
        [
            {title: 'ID', field: 'id', width: 50, align: 'center'},            
            {title: '账户名称', field: 'name', width: 100, align: 'center'},
            {title: '密码', field: 'password', width: 50, align: 'center'},
            {title: '邮箱', field: 'email', width: 100, align: 'center'},
            {title: '电话', field: 'tel', width: 100, align: 'center'},
            {
                title: '操作', field: 'opt', width: 80, align: 'center', formatter: function (value, row, index) {
                var btn1 = '<a class="easyui-linkbutton" onclick="edit(\'' + index + '\')"  href="javascript:void(0)">編輯</a> | ';
                var btn2 = '<a class="easyui-linkbutton" onclick="del(\'' + row.id + '\')"  href="javascript:void(0)">刪除</a>';
                return btn1 + btn2;
            }
            }
        ]
    ],
});
function searchGrid() {
    var name = $('#name').textbox('getValue');
    var tel = $('#tel').textbox('getValue');
    $('#grid').datagrid('reload', {
        name: name,
        tel: tel,
    });
}
var selectRow;
var ctrlUrl = "<?php echo U('admin/edit');?>";
function add() {
    $('#window').window({
        title: "添加账户"
    });
    selectRow = null;
    $('#window').window('open');
    $('#ff').form('clear');
}
function edit(index) {
    $('#grid').datagrid('selectRow', index);
    $('#window').window({
        title: "編輯账户"
    });
    selectRow = $('#grid').datagrid('getSelected'); //此处竟然传引用。
    //$('#img').attr('src', selectRow.img);
    $('#ff').form('load', selectRow);
    $('#window').window('open');
}
function del(id) {
    $.messager.confirm('刪除账户', '你確定要刪除該信息嗎?', function (r) {
        if (r) {
            $.post(ctrlUrl, {id: id, oper: 'del'}, function (data) {
                if (data.status == 0) {
                	$.messager.alert('删除数据','删除失败！！','error');
                    $('#grid').datagrid('reload');
                    return;
                }
                //alert('操作成功');
                $('#grid').datagrid('reload');
            }, 'json')
        }
    });
}
function submitForm() {
    $('#ff').form('submit', {
        url: ctrlUrl,
        onSubmit: function (param) {
            if (selectRow != null) {
                param.id = selectRow.id;
                param.oper = 'edit';
            } else {
                param.oper = 'add';
            }	
            return $(this).form('enableValidation').form('validate');
        },
        success: function (data) {
            if (data.status == 0) {
            	$.messager.alert('修改数据','修改失败！！','error');
                return;
            }
            //$.messager.alert('修改数据','修改成功！！','info');
            $('#window').window('close');
            $('#grid').datagrid('reload');
            clearForm();
        }
    });
}
function clearForm() {
    $('#ff').form('clear');
}
</script>
</body>
</html>