function mysub()
{
		document.getElementById('color_block').style.visibility="visible";
}
function closesub()
{
		document.getElementById('color_block').style.visibility="hidden";
}
function setcolor(str){
		document.getElementById('name').style.color=str;
		document.getElementById('title_color').value=str;
		document.getElementById('color_choose').style.background = str;
		closesub();
}
function setbold(){
	if (document.getElementById('name').style.fontWeight==""){document.getElementById('name').style.fontWeight="bold";document.getElementById('title_bold').value="bold";}else{document.getElementById('name').style.fontWeight="";document.getElementById('title_bold').value="";}
	closesub();
}
function setem(){
	if(document.getElementById('name').style.fontStyle==""){document.getElementById('name').style.fontStyle="italic";document.getElementById('title_em').value="italic";}else{document.getElementById('name').style.fontStyle="";document.getElementById('title_em').value="";}
	closesub();
}
function setu(){
	if(document.getElementById('name').style.textDecoration==""){document.getElementById('name').style.textDecoration="underline";document.getElementById('title_u').value="underline";}else{document.getElementById('name').style.textDecoration="";document.getElementById('title_u').value="";}
	closesub();
}
function setauto(){
		document.getElementById('name').style.color="";
		document.getElementById('title_color').value="";
		document.getElementById('title_bold').value="";
		document.getElementById('title_em').value="";
		document.getElementById('title_u').value="";
		document.getElementById('color_choose').style.background = "#000000";
		document.getElementById('name').style.fontStyle="normal";
		document.getElementById('name').style.fontWeight="normal";
		document.getElementById('name').style.textDecoration="none";
		closesub();
}