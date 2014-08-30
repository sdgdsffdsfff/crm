function setdisplay(){
		document.getElementById('popbox').style.display='block';
		document.getElementById('popbox_bg').style.display='block';
}
function setundisplay(){
		document.getElementById('popbox').style.display='none';
		document.getElementById('popbox_bg').style.display='none';
}
function setvalue(val){
		document.getElementById('pic').value=val;
}
function checkreg()
{
if (document.myform.name.value=="") {
	window.alert("类别名称不能为空！！");
	document.myform.name.focus();		
	 return (false);
	}
if (document.myform.rank.value=="") {
	window.alert("排序ID不能为空！！");
	document.myform.rank.focus();		
	 return (false);
	}
	return true;
}
function show(id){
		document.getElementById('id').style.display='block';
}
function hidden(id){
		document.getElementById('id').style.display='none';
}