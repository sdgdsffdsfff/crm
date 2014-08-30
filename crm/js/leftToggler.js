  var   p=0   
function   switchSysBar()
{   
  if   (p==0)
  {   
	  switchPoint.innerHTML="<img src=/myimages/1/toggler_1.gif>"   
	  document.all("frmTitle").style.display="none"   
	  p=1   
 	 }   
  else
  	{   
		  switchPoint.innerHTML="<img src=/myimages/1/toggler_2.gif>"   
		  document.all("frmTitle").style.display=""   
		  p=0   
 		 }   
  } 
  
 function SetCwinHeight(){
  var iframeid=document.getElementById("frmright"); //iframe id
  if (document.getElementById){
   if (iframeid && !window.opera){
    if (iframeid.contentDocument && iframeid.contentDocument.body.offsetHeight){
     iframeid.height = iframeid.contentDocument.body.offsetHeight;
    }else if(iframeid.Document && iframeid.Document.body.scrollHeight){
     iframeid.height = iframeid.Document.body.scrollHeight;
    }
   }
  }
 }


