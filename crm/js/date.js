<SCRIPT LANGUAGE="JavaScript">
<!--
/********************************************************************
 
������
˵����
1.�����ֱ�ӵ��������´���
<Script>DateBox("InputName","DateValue")<\/Script>
����:InputName Ϊ�������ڵ��ı���.ע:����Ϊ��.
       DateValue  Ϊ�������ڵ��ı���Ĭ������ֵ.��ʽΪ:YYYY-MM-DD.��2004-01-01
                       ��ֵ���Բ����Ϊ��.��Ĭ��ֵΪ��������.(�ͻ���)
2.����"��ť"���������´���
CallDate("InputName")
����:InputName Ϊ�������ڵ��ı���.ע:����Ϊ��.
�޸���
ʱ�䣺
�޸��ˣ�
ԭ��
********************************************************************/
/*��������*/
var Frw=106; //�������
var Frh=137; //�����߶�
var Frs=4;     //Ӱ�Ӵ�С
var Hid=true;//�����Ƿ��
/*�������*/
document.writeln('<Div id=Calendar Author=smart  scrolling="no" frameborder=0 style="border:0px solid #EEEEEE ;position: absolute; width: '+Frw+'; height: '+Frh+'; z-index: 0; filter :\'progid:DXImageTransform.Microsoft.Shadow(direction=135,color=#AAAAAA,strength='+Frs+')\' ;display: none"></Div>');
/*ȡ�ý�������*/
function GetTodayDate()
{
   today= new Date();
   y= today.getYear();
   m= (today.getMonth() + 1);
   if (m<10)
   {
     m='0'+m;
   }
   d= today.getDate();
   if (d<10)
   {
     d='0'+d;
   }
return y+'-'+m+'-'+d
}
/*�����������*/
function SetTodayDate(InputBox)
{
  HiddenCalendar();
  InputBox.value=GetTodayDate();
}
/*ȡĳ��ĳ�µ�һ�������ֵ(�·�-1)*/
function GetFirstWeek(The_Year,The_Month)
{
  return (new Date(The_Year,The_Month-1,1)).getDay()
}
/*ȡĳ��ĳ����������*/
function GetThisDays(The_Year,The_Month)
{
  return (new Date(The_Year,The_Month,0)).getDate()
}
/*ȡĳ��ĳ���ϸ�����������*/
function GetLastDays(The_Year,The_Month)
{
  return (new Date(The_Year,The_Month-1,0)).getDate()
}
/*�ж��Ƿ�������*/
function RunNian(The_Year)
{
 if ((The_Year%400==0) || ((The_Year%4==0) && (The_Year%100!=0)))
  return true;
 else
  return false;
}
/* �ж�����(YYYY-MM-DD)�������Ƿ���ȷ */
function DateIsTrue(asDate){
 var lsDate  = asDate + "";
 var loDate  = lsDate.split("-");
 if (loDate.length!=3) return false; 
 var liYear  = parseFloat(loDate[0]);
 var liMonth = parseFloat(loDate[1]);
 var liDay   = parseFloat(loDate[2]);
 if ((loDate[0].length>4)||(loDate[1].length>2)||(loDate[2].length>2)) return false;
 if (isNaN(liYear)||isNaN(liMonth)||isNaN(liDay)) return false;
 if ((liYear<1800)||(liYear>2500)) return false;
 if ((liMonth>12)||(liMonth<=0))   return false;
 if (GetThisDays(liYear,liMonth)<liDay) return false;
 return !isNaN(Date.UTC(liYear,liMonth,liDay));
}
/*ȡĳ��ĳ�µ���ֵ*/
function GetCountWeeks(The_Year,The_Month)
{
 var Allday;
 Allday = 0;
 if (The_Year>2000)
 {
  
  for (i=2000 ;i<The_Year; i++) 
   if (RunNian(i)) 
    Allday += 366;
   else
    Allday += 365;
  for (i=2; i<=The_Month; i++)
  {
   switch (i)
   {
      case 2 : 
       if (RunNian(The_Year))
        Allday += 29;
       else
        Allday += 28;
       break;
      case 3 : Allday += 31; break;
      case 4 : Allday += 30; break;
      case 5 : Allday += 31; break;
      case 6 : Allday += 30; break;
      case 7 : Allday += 31; break;
      case 8 : Allday += 31; break;
      case 9 : Allday += 30; break;
      case 10 : Allday += 31; break;
      case 11 : Allday += 30; break;
      case 12 :  Allday += 31; break;
   }
  }
 }
return (Allday+6)%7;
}
/*�������ʾ*/
function InputValue(InputBox,Year,Month,Day)
{
  if (Month<10)
  {
    Month='0'+Month
  }
  if (Day<10)
  {
    Day='0'+Day
  }
  InputBox.value=Year+"-"+Month+"-"+Day
}
//��һ��
function ForwardMonth(InputBox,Year,Month,Day)
{
    Month=Month-1;
    if (Month<1)
    {
        Month=12;
        Year=Year-1;
        if (Year<1800)
            Year=2500;
    }
  Day=((GetThisDays(Year,Month)<Day)?GetThisDays(Year,Month):Day)
  Hid=false;
  ShowCalendar(InputBox,Year,Month,Day)
}
//��һ��
function NextMonth(InputBox,Year,Month,Day)
{
    Month=Month+1;
    if (Month>12)
    {
        Month=1;
        Year=Year+1;
        if (Year>2500)
            Year=1800;
    }
  Day=((GetThisDays(Year,Month)<Day)?GetThisDays(Year,Month):Day)
  Hid=false;
  ShowCalendar(InputBox,Year,Month,Day)
}
//��һ��
function ForwardYear(InputBox,Year,Month,Day)
{
    Year=Year-1;
    if (Year<1800)
        Year=2500;
  Day=((GetThisDays(Year,Month)<Day)?GetThisDays(Year,Month):Day)
  Hid=false;
  ShowCalendar(InputBox,Year,Month,Day)
}
//��һ��
function NextYear(InputBox,Year,Month,Day)
{
    Year=Year+1;
    if (Year>2500)
        Year=1800;
  Day=((GetThisDays(Year,Month)<Day)?GetThisDays(Year,Month):Day)
  Hid=false;
  ShowCalendar(InputBox,Year,Month,Day)
}
/*�����¼���ʾ����*/
function OpenDate(where)
{
 GetCalendar(where)
}
/*����������е�������ʾ����*/
function GetCalendar(where)
{
    Hid=false;
    var Box_Name=where.name;
    var Box_value=where.value;
    if (DateIsTrue(Box_value))
    {
    loDate  = Box_value.split("-");
    Y= parseFloat(loDate[0]);
    M= parseFloat(loDate[1]);
    D= parseFloat(loDate[2]);
    ShowCalendar(where,Y,M,D);
    }
  else
  {
    today= new Date();
    y= today.getYear();
    m= (today.getMonth() + 1);
    d=today.getDate();
    ShowCalendar(where,y,m,d);
  }
}
/*��������*/
function HiddenCalendar()
{
    document.all.Calendar.style.display="none";
}
function CloseCalendar()
{
  if (Hid)
    document.all.Calendar.style.display="none";
  Hid=true;
}
/*��ʾ����*/
function ShowCalendar(InputBox,The_Year,The_Month,The_Day)
{
    var Now_Year=(The_Year==null?2004:The_Year);
    var Now_Month=(The_Month==null?1:The_Month);
    var Now_Day=(The_Day==null?1:The_Day);
    var Box_Name='window.parent.document.all.'+InputBox.name;
    var fw=GetFirstWeek(Now_Year,Now_Month);
    var ld=GetLastDays(Now_Year,Now_Month);
    var td=GetThisDays(Now_Year,Now_Month);
    var isnd=false;//�Ƿ����¸��µ�����
    var d=1,w=1;
    var FrameContent;
    var Frl,Frt,Winw,Winh;
/*��ʾ��λ��*/
Winw=document.body.offsetWidth;
Winh=document.body.offsetHeight;
Frl=InputBox.getBoundingClientRect().left-2;
Frt=InputBox.getBoundingClientRect().top+InputBox.clientHeight;
if (((Frl+Frw+Frs)>Winw)&&(Frw+Frs<Winw))
  Frl=Winw-Frw-Frs;
if ((Frt+Frh+Frs>Winh)&&(Frh+Frs<Winh))
  Frt=Winh-Frh-Frs;
document.all.Calendar.style.display="";
document.all.Calendar.style.left=Frl;
document.all.Calendar.style.top=Frt;
//��ʾ��������
FrameContent="\n<table onselectstart=\"return false;\" border='0' cellpadding='0' cellspacing='0' bgcolor='#395592' width='120' height='15' style=\"color:white;font-weight:bolder;border:0px solid\">"+"\n<tr>\n";
FrameContent+="<td width=12 align=right>";
FrameContent+="<img src='-.gif' width='8' height='11' border='0' alt='��һ��' style='cursor:hand' onclick=\"parent.ForwardYear (window.parent.document.all."+InputBox.name+","+Now_Year+","+Now_Month+","+Now_Day+")\">";
FrameContent+="</td>\n";
FrameContent+="<td vAlign=middle align='center'>";
FrameContent+=Now_Year;
FrameContent+="��";
FrameContent+="</td>\n";
FrameContent+="<td width=12 align=left>";
FrameContent+="<img src='+.gif' width='8' height='11' border='0' alt='��һ��' style='cursor:hand' onclick=\"parent.NextYear (window.parent.document.all."+InputBox.name+","+Now_Year+","+Now_Month+","+Now_Day+")\">";
FrameContent+="</td>\n";
FrameContent+="<td width=12 align='right'>";
FrameContent+="<img src='-.gif' width='8' height='11' border='0' alt='��һ��' style='cursor:hand' onclick=\"parent.ForwardMonth (window.parent.document.all."+InputBox.name+","+Now_Year+","+Now_Month+","+Now_Day+")\">";
FrameContent+="</td>\n";
FrameContent+="<td vAlign=middle align='center' width='16'>";
FrameContent+=Now_Month;
FrameContent+="</td>\n";
FrameContent+="<td vAlign=middle align='center' width='13'>";
FrameContent+="��";
FrameContent+="</td>\n";
FrameContent+="<td width=12 align=left> ";
FrameContent+="<img src='+.gif' width='8' height='11' border='0' alt='��һ��' style='cursor:hand' onclick=\"parent.NextMonth (window.parent.document.all."+InputBox.name+","+Now_Year+","+Now_Month+","+Now_Day+")\">";
FrameContent+="</td>"+"\n";
FrameContent+="</tr>"+"\n";
FrameContent+="</table>"+"\n";
FrameContent+="<table onselectstart=\"return false;\" border='0' cellpadding='0' cellspacing='1' width='120' bgcolor='#CCCCCC'>"+"\n";
FrameContent+="<tr bgcolor='#F5F5F5'>"+"\n";
FrameContent+="<td><center>һ</center></td>"+"\n";
FrameContent+="<td><center>��</center></td>"+"\n";
FrameContent+="<td><center>��</center></td>"+"\n";
FrameContent+="<td><center>��</center></td>"+"\n";
FrameContent+="<td><center>��</center></td>"+"\n";
FrameContent+="<td><center>��</center></td>"+"\n";
FrameContent+="<td><center><font color='#FF0000'>��</font></center></td>"+"\n";
FrameContent+="</tr>"+"\n";
//������µ�һ��������һ��������.Ӧ������.��֤���Կ����ϸ��µ�����
    if (fw<2)
      tf=fw+7;
    else
      tf=fw;
      FrameContent+="<tr bgcolor='#FFFFFF'>"+"\n";
      //��һ����������
      for (l=(ld-tf+2);l<=ld;l++)
      {
        FrameContent+="<td  onclick=\"parent.ForwardMonth (window.parent.document.all."+InputBox.name+","+Now_Year+","+Now_Month+","+l+")\" style='cursor:hand'><center><font color='#BBBBBB'>"+l+"</font></center></td>"+"\n";
        w++;
      }
      //��һ�б�������
      for (f=tf;f<=7;f++)
      {
         //�����쵫����������
         if (((w%7)==0)&&(d!=Now_Day))
           FrameContent+="<td onMouseOver=\"this.style.background=\'#E1E1E1\'\" onMouseOut=\"this.style.background=\'#FFFFFF\'\" onClick=\"parent.InputValue(window.parent.document.all."+InputBox.name+","+Now_Year+","+Now_Month+","+d+");parent.HiddenCalendar()\" style='cursor:hand'><center><font color='#FF0000'>"+d+"</font></center></td>"+"\n";
         //����Ϊ��������
         else if (d==Now_Day)
           FrameContent+="<td style=\"background:#420042;cursor:hand\" onClick=\"parent.InputValue(window.parent.document.all."+InputBox.name+","+Now_Year+","+Now_Month+","+d+");parent.HiddenCalendar()\"><center><font color='#FFFFFF'>"+d+"</font></center></td>"+"\n";
         //����
         else
           FrameContent+="<td onMouseOver=\"this.style.background=\'#E1E1E1\'\" onMouseOut=\"this.style.background=\'#FFFFFF\'\" onClick=\"parent.InputValue(window.parent.document.all."+InputBox.name+","+Now_Year+","+Now_Month+","+d+");parent.HiddenCalendar()\" style='cursor:hand'><center>"+d+"</center></td>"+"\n";
        d++;
        w++;
      }
      FrameContent+="</tr>"+"\n";
    w=1;
    for (i=2;i<7;i++)
    {
      FrameContent+="<tr bgcolor='#FFFFFF'>"+"\n";
      for (j=1;j<8;j++)
      {
         if (isnd)//�¸��µ�����
         FrameContent+="<td style='cursor:hand' onclick=\"parent.NextMonth (window.parent.document.all."+InputBox.name+","+Now_Year+","+Now_Month+","+d+")\"><center><font color='#BBBBBB'>"+d+"</font></center></td>"+"\n";
         else//���µ�����
        {
           //�����쵫����������
           if (((w%7)==0)&&(d!=Now_Day))
             FrameContent+="<td onMouseOver=\"this.style.background=\'#E1E1E1\'\" onMouseOut=\"this.style.background=\'#FFFFFF\'\" onClick=\"parent.InputValue(window.parent.document.all."+InputBox.name+","+Now_Year+","+Now_Month+","+d+");parent.HiddenCalendar()\" style='cursor:hand'><center><font color='#FF0000'>"+d+"</font></center></td>"+"\n";
           //����Ϊ��������
           else if (d==Now_Day)
             FrameContent+="<td style=\"background:#420042;cursor:hand\" onClick=\"parent.InputValue(window.parent.document.all."+InputBox.name+","+Now_Year+","+Now_Month+","+d+");parent.HiddenCalendar()\"><center><font color='#FFFFFF'>"+d+"</font></center></td>"+"\n";
           //����
           else
             FrameContent+="<td onMouseOver=\"this.style.background=\'#E1E1E1\'\" onMouseOut=\"this.style.background=\'#FFFFFF\'\" onClick=\"parent.InputValue(window.parent.document.all."+InputBox.name+","+Now_Year+","+Now_Month+","+d+");parent.HiddenCalendar()\" style='cursor:hand'><center>"+d+"</center></td>"+"\n";
        }
        //�ж��Ƿ�Ϊ���µ�����
        if (d==td)
        {
          isnd=true;
          d=0;
        }
        w++;
        d++;
      }
      FrameContent+="</tr>"+"\n";
    }
FrameContent+="</table>"+"\n";
FrameContent+="<table onselectstart=\"return false;\" cellpadding='0' cellspacing='0' bgcolor='#F5F5F5' width='120' height='15'>"+"\n<tr>\n";
FrameContent+="<td title=\"����:"+GetTodayDate()+"\" style=\"cursor:hand\" onclick=\"parent.SetTodayDate(window.parent.document.all."+InputBox.name+")\">";
FrameContent+="<font color=red>����:</font>"+GetTodayDate();
FrameContent+="</td>\n";
FrameContent+="<td>";
FrameContent+="<img src='close.gif' width='13' height='13' border='0' alt='�ر�' style='cursor:hand' onclick=\"parent.HiddenCalendar()\">";
FrameContent+="</td>\n";
FrameContent+="</tr>\n";
document.all.Calendar.innerHTML=FrameContent;
document.all.Calendar.style.display="";
}
/*��ʾ�����*/
function DateBox(sBoxName, sDfltValue)
{
    if (sBoxName==null)
        sBoxName='Date_Box'
    if ((sDfltValue==null)||!(DateIsTrue(sDfltValue)))
//        sDfltValue= GetTodayDate()
		sDfltValue= ''
    else 
    {
      DateStr  = sDfltValue.split("-");
      Y= parseFloat(DateStr[0]);
      M= (parseFloat(DateStr[1])<10)?('0'+parseFloat(DateStr[1])):parseFloat(DateStr[1]);
      D= (parseFloat(DateStr[2])<10)?('0'+parseFloat(DateStr[2])):parseFloat(DateStr[2]);
      sDfltValue=Y+'-'+M+'-'+D
    }
    document.write("<input size='45'  class='inputdate' name='"+sBoxName+"' value='"+sDfltValue+"' onclick='GetCalendar(window.document.all."+sBoxName+")' >");
}
document.onclick = CloseCalendar;
//-->
</SCRIPT>