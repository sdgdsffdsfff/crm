<html>
<head>
    <meta charset="UTF-8">
    <title>自动发送短信</title>
    <link rel="stylesheet" type="text/css" href="../js/easyui.css">
    <link rel="stylesheet" type="text/css" href="../js/icon.css"> 
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/jquery.easyui.min.js"></script>
</head>
<body > 
    <table id="dg" class="easyui-datagrid" title="自动发送短信" style="width:1110px;height:500"
            data-options="
                iconCls: 'icon-edit',
                singleSelect: false,
                url: './jsonAction.php',
                method:'get',
                pagination:true,
                pageSize:20,
                onDblClickCell:onClickCell,
                onAfterEdit:onAfterEdit         
            ">
        <thead>
            <tr>
                <th data-options="field:'id',checkbox:true,width:20">ID</th>
                <th data-options="field:'type',width:30,editor:'text'">类型</th>
                <th data-options="field:'conditions',width:630,editor:'textarea'">SQL条件</th>
                <th data-options="field:'title',width:350,editor:'textarea'">标题</th>
                <!--<th data-options="field:'content',width:260,editor:'textarea'">内容</th>-->
                <th data-options="field:'isstop',editor:{type:'checkbox',options:{on:'0',off:'1'}},width:40">停用</th> 
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
		        text:'新增',
		        iconCls:'icon-add',
		        handler:function(){
		            addRow()
		        }
		        },{
		        text:'保存',
		        iconCls:'icon-save',
		        handler:function(){
		            onClickCell(1)
		             $("#dg").datagrid('reload')
		        }
		        },{
		        text:'删除',
		        iconCls:'icon-no',
		        handler:function(){ 
		            openwin("del");
		            $("#dg").datagrid('reload')
		        }
		        },{
		        text:'单独发送短信',
		        iconCls:'icon-tip',
		        handler:function(){ 
		           location.href="send.php?type=短信"
		        }
		        },{
		        text:'自动发送短信',
		        iconCls:'icon-tip',
		        handler:function(){ 
		           location.href="cronRun.php"
		        }
		        }]
        });
        
        
        
        

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
         function addRow(target){
          	$('#dg').datagrid('appendRow',{isstop:'0'});
    		 
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
        	$.post('./jsonAction.php?act=mod&json='+rowstr, rowstr, function (data) {
                 alert(data);
            });
        }
        
        function openwin(exp2){
        	var checkedItems = $('#dg').datagrid('getChecked'); 
					var names = [];  
					$.each(checkedItems, function(index, item){ 
						names.push(item.id);  
					});  
					ids = names.join(",");  
					if(ids!="" && confirm('您确定要这样做吗？')){ 					
						$.post('./jsonAction.php?act='+exp2+'&ids='+ids, ids, function (data) { 
								if(exp2=="del"){ 
									alert("删除成功！");
								}
		          });  
	        }     
        }
        
    </script> 
</body>
</html>