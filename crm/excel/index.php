<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>大客户池管理</title>
    <link rel="stylesheet" type="text/css" href="../js/easyui.css">
    <link rel="stylesheet" type="text/css" href="../js/icon.css"> 
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/jquery.easyui.min.js"></script>
</head>
<body > 
    <table id="dg" class="easyui-datagrid" title="客户池信息" style="width:1110px;height:auto"
            data-options="
                iconCls: 'icon-edit',
                singleSelect: false,
                url: 'getBigC.php',
                method:'get',
                pagination:true,
                pageSize:20,
                onDblClickCell:onClickCell,
                onAfterEdit:onAfterEdit         
            ">
        <thead>
            <tr>
                <th data-options="field:'id',checkbox:true,width:20">ID</th>
                <th data-options="field:'companyName',width:200,editor:'text'">公司名字</th>
                <th data-options="field:'name',width:120,editor:'text'">联系人</th>
                <th data-options="field:'tel',width:100,editor:'text'">电话</th>
                <th data-options="field:'mobile',width:100,editor:'text'">手机</th>
                <th data-options="field:'mobiletime',width:60">时间</th>
                <th data-options="field:'mobilecount',width:10">T</th> 
                <th data-options="field:'email',width:150,editor:'text'">电子邮件</th>
                <th data-options="field:'emailtime',width:60">时间</th>
                <th data-options="field:'emailcount',width:10">T</th> 
                <th data-options="field:'remark',width:170,editor:'text'">备注</th>
            </tr>
        </thead>
    </table>
     <div id="win"></div>

 
    <script type="text/javascript">
    
    	 

        $.extend($.fn.datagrid.methods, {
            editCell: function(jq,param){
                return jq.each(function(){
                    var opts = $(this).datagrid('options');
                    var fields = $(this).datagrid('getColumnFields',true).concat($(this).datagrid('getColumnFields'));
                    for(var i=0; i<fields.length; i++){
                        var col = $(this).datagrid('getColumnOption', fields[i]);
                        col.editor1 = col.editor;
                        if (fields[i] != param.field){
                            col.editor = null;
                        }
                    }
                    $(this).datagrid('beginEdit', param.index);
                    for(var i=0; i<fields.length; i++){
                        var col = $(this).datagrid('getColumnOption', fields[i]);
                        col.editor = col.editor1;
                    }
                });
            }           
        });
        
        $('#dg').datagrid({
        	toolbar:[{
	        text:'查询',
	        iconCls:'icon-search',
	        handler:function(){	             
	            $('#dg').datagrid('load',{  
            	code:$('#personSearch').val(),
            	field:$('#field').val()}  
            ); 
	        }
		    },{
	        text:'导出电话',
	        iconCls:'icon-add',
	        handler:function(){  
				openwin("mobile");
	        }
		    },{
		        text:'导出电子邮件',
		        iconCls:'icon-cut',
		        handler:function(){
		            openwin("email");
		        }
		    },'-',{
		        text:'保存',
		        iconCls:'icon-save',
		        handler:function(){
		            onClickCell(1)
		        }
		        },{
		        text:'删除',
		        iconCls:'icon-no',
		        handler:function(){
		        	
		            openwin("del");
		        }
		        },{
		        text:'导入正式库',
		        iconCls:'icon-redo',
		        handler:function(){
		        	
		            openwin("copy");
		        }
		        },{
		        text:'导入客户',
		        iconCls:'icon-tip',
		        handler:function(){ 
		           location.href="upload2.php"
		        }
		        }]
        });
        
        $("<div style='padding: 0 8px;'><select id='field'><option value='all'>所有</option><option value='companyName'>公司</option>    <option value='mobile'>手机</option>    <option value='email'>邮件</option></select><input class='easyui-searchbox' style='width: 200px;' prompt='请输入姓名或拼音查询' id='personSearch' searcher='person.search'></div>").prependTo(".datagrid-toolbar table tbody tr");
        
        

        var editIndex = undefined;
        function endEditing(){
            if (editIndex == undefined){return true}
            if ($('#dg').datagrid('validateRow', editIndex)){
                $('#dg').datagrid('endEdit', editIndex);
                editIndex = undefined;
                return true;
            } else {
                return false;
            }
        }
        function onClickCell(index, field){
            if (endEditing()){
                $('#dg').datagrid('selectRow', index)
                        .datagrid('editCell', {index:index,field:field});
                editIndex = index;
            }
        }
        function onAfterEdit(rowIndex, rowData, changes){        	
        	var rowstr = encodeURIComponent(JSON.stringify(rowData)); 
        	$.post('./poolAction.php?act=mod&json='+rowstr, rowstr, function (data) {
                 alert(data);
            });
        }
        
        function openwin(exp2){
        	var checkedItems = $('#dg').datagrid('getChecked'); 
				var names = []; 
				var mobiles = []; 
				var emails = []; 
				$.each(checkedItems, function(index, item){ 
					names.push(item.id); 
					mobiles.push(item.mobile);
					emails.push(item.email);
				});  
				ids = names.join(",");  
				$.post('./poolAction.php?act='+exp2+'&ids='+ids, ids, function (data) {
					if(exp2=="mobile"){
						 $('#win').window({
						    width:600,
						    height:400,
						    modal:true,
						    content:mobiles.join(";<BR>")
						}); 
					}
					if(exp2=="email"){
						$('#win').window({
						    width:600,
						    height:400,
						    modal:true,
						    content:emails.join(";<BR>")
						}); 
					}
					if(exp2=="del"){ 
						alert("删除成功！");
					}
					if(exp2=="copy"){ 
						alert("导入成功！");
					}
            	});       
        }
        
    </script>
</body>
</html>