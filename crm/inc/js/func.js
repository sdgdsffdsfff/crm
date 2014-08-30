function $(id){return document.getElementById(id);}
function go(url){window.location.replace(url);}
function hide(id){$(id).style.display='none';}
function show(id){$(id).style.display='';}
function get(url){var ajax=new Ajax(function(){eval(ajax.Data);});ajax.get(url,"reqTime="+new Date().getTime());}
function post(url,frm,btn){var data='reqTimes='+new Date().getTime();if(frm,url){data=data+"&"+frmval(frm);}var ajax=new Ajax(function(){eval(ajax.Data);$(frm).reset();btn.disabled=false;},function(){alert('数据提交失败!');btn.disabled=false;});ajax.post(url,data);}
function ajaxdel(url,id){var ajax=new Ajax( function(){if(ajax.Data=='ok'){hide(id);}else{alert(ajax.Data);}});ajax.get(url,"reqTime="+new Date().getTime());} // 删除项目
function message(){get('message.asp?act=checknew');setTimeout(message,2000);}
function initmenu(id){var disp=getcookie(id);if(disp==null){disp='block';}$(id).style.display=disp;}	
function showmenu(id){var disp='block';if($(id).style.display!="none"){disp='none';}$(id).style.display=disp;setcookie(id,disp);}
function setcookie(n,v){var exp=new Date();exp.setTime(exp.getTime()+24*60*60*100);document.cookie=n+"="+escape(v)+";expires="+exp.toGMTString();}
function getcookie(n){var arr,reg=new RegExp("(^| )"+n+"=([^;]*)(;|$)");if(arr=document.cookie.match(reg)){return unescape(arr[2]);}else{return null;}}
function msgbox(obj,maxbox){
	var width=0,a='container',b='msgbox',t='msgtitle',m='msgcontent';
	var top=document.body.scrollTop;
	if(!top){top=document.documentElement.scrollTop;}
	var url=obj.getAttribute("url");
	var tit=obj.getAttribute("title");
	var src=obj.getAttribute("srcid");
	var frm=obj.getAttribute("frm");
	var wait=obj.getAttribute("wait");
	if(!tit){tit='&nbsp;';}
	if(!wait){wait='加载中,请稍等...';}
	if(!maxbox){width=450;}else{width=650;}
	$(a).style.display='block';
	$(a).style.width=document.body.scrollWidth+20+'px';
	$(a).style.height=document.body.scrollHeight+'px';
	$(a).onclick=function(){msgboxclose();};
	$(b).style.display='block';
	$(b).style.top=top+80+'px';
	$(b).style.left=document.body.scrollWidth/2-(width/2)+'px';
	$(b).style.width=width+'px';
	$(t).innerHTML='<span onclick="msgboxclose();" title="关闭"></span>'+tit;
	if(src){
		$(m).innerHTML=$(src).innerHTML;
	}else{
		if(frm){url=frmval(frm,url);}
		$(m).innerHTML='<div id="loading">'+wait+'</div>';
		var ajax=new Ajax(function(){$(m).innerHTML='<p>'+ajax.Data+'</p>';},function(){$(m).innerHTML='<p>服务器无响应,请稍后再试</p>';});
		ajax.get(url,"reqTime="+new Date().getTime());
	}
}
function msgboxclose(){$('msgcontent').innerHTML='';$('container').style.display=$('msgbox').style.display='none';}
// 获取表单里所有的元素
function frmval(frm,url){var data='',i=0,e='',ev='',and='';for(i=0;i<$(frm).length;i++){var e=$(frm)[i];if(e.name!=''){
if(e.type=='select-one'&&e.selectedIndex>-1){ev=e.options[e.selectedIndex].value;}else if(e.type=='checkbox' || e.type=='radio'){if(e.checked==false){continue;}ev=e.value;}else{ev=e.value;}
ev=escape(ev);//escape decodeURI decodeURIComponent
data+=and+e.name+'='+ev; and='&';}}if(url){if(url.indexOf("?")>0){data=url+'&'+data;}else{data=url+'?'+data;}}return data;}
// 标题加色
function stylefor(id){if($('stylefor').style.display=='none'){$('stylefor').style.left=id.offsetLeft+139+'px';$('stylefor').style.top=id.offsetTop+45+'px';show('stylefor');}else{hide('stylefor');}}
// 上传所用
function setvalue(id,val){$(id).value=val;}
function msgboxclosex(){document.frameupload.location.href = "about:blank";msgboxclose();}
function insertfck(id,val,ext,name){
var fck = FCKeditorAPI.GetInstance(id)
switch(ext.toLowerCase()){
case 'pic':
case 'gif':
case 'jpg':
case 'png':
case 'bmp':
case 'jpeg':fck.InsertHtml('<img src="' + val + '" />');break;
case 'mp3':
case 'wma':fck.InsertHtml('<object classid="CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95"  id="MediaPlayer" width="450" height="70"><param name=""howStatusBar" value="-1"><param name="AutoStart" value="False"><param name="Filename" value="'+val+'"></object>');break;
case 'rm':
case 'rmvb':fck.InsertHtml('<object classid="clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA" width="400" height="300"><param name="SRC" value="'+val+'" /><param name="CONTROLS" VALUE="ImageWindow" /><param name="CONSOLE" value="one" /><param name="AUTOSTART" value="true" /><embed src="'+val+'" nojava="true" controls="ImageWindow" console="one" width="400" height="300"></object><br/><object classid="clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA" width="400" height="32" /><param name="CONTROLS" value="StatusBar" /><param name="AUTOSTART" value="true" /><param name="CONSOLE" value="one" /><embed src="'+val+'" nojava="true" controls="StatusBar" console="one" width="400" height="24" /></object><br/><object classid="clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA" width="400" height="32" /><param name="CONTROLS" value="ControlPanel" /><param name="AUTOSTART" value="true" /><param name="CONSOLE" value="one" /><embed src="'+val+'" nojava="true" controls="ControlPanel" console="one" width="400" height="24" autostart="true" loop="false" /></object>');break;
case 'asf':
case 'avi':
case 'wmv':fck.InsertHtml('<object classid="clsid:22D6F312-B0F6-11D0-94AB-0080C74C7E95" codebase="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=6,0,02,902" type="application/x-oleobject" standby="Loading..." width="400" height="300"><param name="FileName" VALUE="'+val+'" /><param name="ShowStatusBar" value="-1" /><param name="AutoStart" value="true" /><embed type="application/x-mplayer2" pluginspage="http://www.microsoft.com/Windows/MediaPlayer/" src="'+val+'" autostart="true" width="400" height="300" /></object>');break;
case 'swf':fck.InsertHtml('<embed src="'+val+'" width="400" height="300" scale="exactfit" play="true" loop="true" menu="true" wmode="Window" quality="1" type="application/x-shockwave-flash"></embed>');break;
default :if(name.length==0){name=val};fck.InsertHtml(' <a href="'+val+'">下载: '+name+'</a> ');break;}}
// 时间选择器
var allMonth=[31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
var allNameOfWeekDays=["一","二", "三", "四", "五", "六", "日"];
var allNameOfMonths=["01","02","03","04","05","06","07","08","09","10","11","12"];
var newDate=new Date();
var yearZero=newDate.getFullYear();
var monthZero=newDate.getMonth();
var day=newDate.getDate();
var currentDay=0, currentDayZero=0;
var month=monthZero, year=yearZero;
var yearMin=year-6, yearMax=year+6;
var target='';
var hoverEle=false;
function setTarget(e){if(e){return e.target;}if(event){return event.srcElement;}}
function newElement(type,attrs,content,toNode){var ele=document.createElement(type);if(attrs){for(var i=0; i<attrs.length; i++){eval('ele.'+attrs[i][0]+(attrs[i][2] ? '=\u0027' :'=')+attrs[i][1]+(attrs[i][2] ? '\u0027' :''));}}if(content){ele.appendChild(document.createTextNode(content));}if(toNode){toNode.appendChild(ele);}return ele;}
function setMonth(ele){month=parseInt(ele.value);calender()}
function setYear(ele){year=parseInt(ele.value);calender()}
function setValue(ele){if(ele.parentNode.className=='week' && ele.firstChild){var dayOut=ele.firstChild.nodeValue;var monthOut=month+1;target.value=year+'-'+monthOut+'-'+dayOut;removeCalender();}}
function removeCalender(){
var parentEle=document.getElementById("calender");
while(parentEle.firstChild) parentEle.removeChild(parentEle.firstChild);
document.getElementById('basis').parentNode.removeChild(document.getElementById('basis'));}          
function calender(){
  if(year>yearMax){yearMax=year+1;yearMin=yearMax-10;}if(year<yearMin){yearMin=year;yearMax=yearMin+11;}
  var parentEle=document.getElementById("calender");
  parentEle.onmouseover=function(e){
	   var ele=setTarget(e);
	   if(ele.parentNode.className=='week' && ele.firstChild && ele!=hoverEle){
			if(hoverEle) hoverEle.className=hoverEle.className.replace(/hoverEle ?/,'');
			hoverEle=ele;
			ele.className='hoverEle '+ele.className;
	   } else {
			if(hoverEle){
				 hoverEle.className=hoverEle.className.replace(/hoverEle ?/,'');
				 hoverEle=false;
			}
	   }
  }
  while(parentEle.firstChild) parentEle.removeChild(parentEle.firstChild);
  function check(){
	   if(year%4==0&&(year%100!=0||year%400==0))allMonth[1]=29;
	   else allMonth[1]=28;
  }
  function addClass (name){ if(!currentClass){currentClass=name} else {currentClass+=' '+name} };
  if(month < 0){month+=12; year-=1}
  if(month > 11){month-=12; year+=1}
  if(year==yearMax-1) yearMax+=1;
  if(year==yearMin) yearMin-=1;
  check();
  var control=newElement('p',[['id','control',1]],false,parentEle);
  var controlPlus=newElement('a', [['href','javascript:year--;calender()',1],['className','controlPlus',1]], '<<', control);
  controlPlus=newElement('a', [['href','javascript:month--;calender()',1],['className','controlPlus',1]], '<', control);
  select=newElement('select', [['onchange',function(){setYear(this)}]], false, control);
  for(var i=yearMin; i<yearMax; i++) newElement('option', [['value',i,1]], i, select);
  select.selectedIndex=year-yearMin;
  var select=newElement('select', [['onchange',function(){setMonth(this)}]], false, control);
  for(var i=0; i<allNameOfMonths.length; i++) newElement('option', [['value',i,1]], allNameOfMonths[i], select);
  select.selectedIndex=month;
  controlPlus=newElement('a', [['href','javascript:month++;calender()',1],['className','controlPlus',1]], '>', control);
  controlPlus=newElement('a', [['href','javascript:year++;calender()',1],['className','controlPlus',1]], '>>', control);
  check();
  currentDay=1-new Date(year,month,1).getDay();
  if(currentDay > 0) currentDay-=7;
  currentDayZero=currentDay;
  var newMonth=newElement('table',[['cellSpacing',0,1],['onclick',function(e){setValue(setTarget(e))}]], false, parentEle);
  var newMonthBody=newElement('tbody', false, false, newMonth);
  var tr=newElement('tr', [['className','head',1]], false, newMonthBody);
  tr=newElement('tr', [['className','weekdays',1]], false, newMonthBody);
  for(i=0;i<7;i++) td=newElement('td', false, allNameOfWeekDays[i], tr);     
  tr=newElement('tr', [['className','week',1]], false, newMonthBody);
  for(i=0; i<allMonth[month]-currentDayZero; i++){
	   var currentClass=false;               
	   currentDay++;
	   if(currentDay==day && month==monthZero && year==yearZero) addClass ('today');
	   if(currentDay <= 0 ){
			if(currentDayZero!=-7) td=newElement('td', false, false, tr);
	   }
	   else {
			if((currentDay-currentDayZero)%7==0) addClass ('holiday');
			td=newElement('td', (!currentClass ? false : [['className',currentClass,1]] ), currentDay, tr);
			if((currentDay-currentDayZero)%7==0) tr=newElement('tr', [['className','week',1]], false, newMonthBody);
}
if(i==allMonth[month]-currentDayZero-1){i++;while(i%7!=0){i++;td=newElement('td', false, false, tr)};}}}
function datecontrol(ele){if(document.getElementById('basis')){removeCalender();}else {target=document.getElementById(ele.id.replace(/for_/,'')); var InputDT=target.value.split("-");if(parseFloat(InputDT[0])){year=parseFloat(InputDT[0]);yearZero=year;}if(parseFloat(InputDT[1])){month=parseFloat(InputDT[1])-1;monthZero=month;}if(parseFloat(InputDT[2])){day=parseFloat(InputDT[2]);}var basis=ele.parentNode.insertBefore(document.createElement('div'),ele);basis.id='basis';newElement('div', [['id','calender',1]], false, basis);calender();}}

// AJAX
function Ajax(onSuccess,onFail){this.OnSuccess=onSuccess;if(onFail){this.OnFail=onFail;}if(window.XMLHttpRequest){this.xhr=new XMLHttpRequest();}else{try{this.xhr=new ActiveXObject("Msxml2.XMLHTTP");}catch(e){this.xhr=new ActiveXObject("Microsoft.XMLHTTP");}}this.async=true;this.dataType="text";}
Ajax.prototype={
setXML:function(){this.dataType="xml";},
send:function(url,data,method,encoding){var meth="get",contentType="application/x-www-form-urlencoded";if(method&&method=="post"){meth="post";}if(meth=="post"){if(encoding){contentType+=''+encoding;}else{contentType+=";charset=GBK";}}else if(data){url+=(url.indexOf("?")>-1?"&":"?");url=url+data;data=null;}var me=this;this.xhr.open(meth.toUpperCase(),url,this.async);this.xhr.onreadystatechange=function(){me.onStateChg.call(me);};if(meth=="post"){this.xhr.setRequestHeader("Content-Type", contentType);}this.xhr.send(data);},
post:function(url,data,encoding){this.send(url,data,"post",encoding);},
get:function(url,data){this.send(url,data);},
onStateChg:function(){if(this.xhr.readyState!=4){return;}if(this.xhr.status>=200&&this.xhr.status<300){if(this.dataType=="xml"){this.Data=this.xhr.responseXML;}else{this.Data=this.xhr.responseText;}this.OnSuccess();}else if(this.OnFail){this.OnFail();}}
}