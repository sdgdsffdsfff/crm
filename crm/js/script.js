// 全屏浏览器功能脚本made by webstudio.com.cn.egoldy
//===============================================
function openFullScreen(page) {
		var URLen=page;
		var windowNamen="mainflashwindow";
		var browserName=navigator.appName;
		var operatingSystem=navigator.platform;
		var version = parseFloat(navigator.appVersion);

		if (browserName.indexOf("Netscape")!=-1 && version>=4.0 && operatingSystem.indexOf("Mac")!=-1)
		 {
		 window.open(URLen,windowNamen,'titlebar=no,top=0,left=0,width=' + window.screen.availWidth+',height='+window.screen.availWidth+',screenX=0,screenY=0,top=0,left=0')
		 }

		else if (browserName.indexOf("Microsoft Internet Explorer")!=-1 && operatingSystem.indexOf("Mac")!=-1)
		 {
		 window.open(URLen,windowNamen,'titlebar=no,top=0,left=0,width=' + window.screen.availWidth+',height='+window.screen.availWidth+',screenX=0,screenY=0,top=0,left=0')
		 }

		else if (browserName.indexOf("Netscape")!=-1 && operatingSystem.indexOf("Mac")!=-1)
		 {
		 window.open(URLen,windowNamen,'width='+screen.width+',height='+screen.height+',top=0,left=0');
		 }

		else if (browserName.indexOf("Microsoft Internet Explorer")!=-1 && operatingSystem.indexOf("Win")!=-1)
		 {
		 //是否是完全全屏的开关.放开下面的一行,则完全全屏,注掉下面一行则打开带有标题条的全屏
                              //window.open(URLen,windowNamen,'fullscreen=yes')
		var win = window.open(URLen,windowNamen,'titlebar=0,toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=0,resizable=0,top=0,left=0,width=' + window.screen.availWidth+',height='+window.screen.availHeight+',screenX=0,screenY=0,top=0,left=0')
			win.resizeTo(screen.width, screen.height);
			 //win.moveTo(1, 1);
			 //win.moveTo(0, 0);
			 //win.resizeTo(screen.width, screen.height);
		 }

		
		else if (browserName.indexOf("Netscape")!=-1 && operatingSystem.indexOf("Win")!=-1)
		 {
		 window.open(URLen,windowNamen,'width='+screen.width+',height='+screen.height+',top=0,left=0');
		 }

		else
		 {
		 window.open(URLen,windowNamen);
		 }

	}