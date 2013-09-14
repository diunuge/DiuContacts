function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function KW_getVal(o){ //v1.2
	var retVal="0";if (o.type=="select-one")
	{retVal=(o.selectedIndex==-1)?0:o.options[o.selectedIndex].value;}
	else if (o.length>1){for (var i=0;i<o.length;i++) if (o[i].checked) retVal=o[i].value;
	} else if (o.type=="checkbox") {retVal=(o.checked)?o.value:0;} else {
	retVal=Number(o.value)}return parseFloat(retVal);
}

function KW_calcForm() { //v1.2
	var str="",a=KW_calcForm.arguments; for (var i=3;i<a.length;i++)
	str+=(a[i].indexOf("#")==-1)?a[i]:KW_getVal(MM_findObj(a[i].substring(1)));
	t=Math.round(a[1]*eval(str))/a[1];tS=t.toString();if(a[2]>0){tSp=tS.indexOf(".");
	if(tSp==-1)	tS+=".";tSp=tS.indexOf(".");while(tSp!=(tS.length-1-a[2])){tS+="0";
	tSp=tS.indexOf(".");}} MM_findObj(a[0]).value=tS;
}

function YY_checkform() { //v4.71
//copyright (c)1998,2002 Yaromat.com
  var a=YY_checkform.arguments,oo=true,v='',s='',err=false,r,o,at,o1,t,i,j,ma,rx,cd,cm,cy,dte,at;
  for (i=1; i<a.length;i=i+4){
    if (a[i+1].charAt(0)=='#'){r=true; a[i+1]=a[i+1].substring(1);}else{r=false}
    o=MM_findObj(a[i].replace(/\[\d+\]/ig,""));
    o1=MM_findObj(a[i+1].replace(/\[\d+\]/ig,""));
    v=o.value;t=a[i+2];
    if (o.type=='text'||o.type=='password'||o.type=='hidden'){
      if (r&&v.length==0){err=true}
      if (v.length>0)
      if (t==1){ //fromto
        ma=a[i+1].split('_');if(isNaN(v)||v<ma[0]/1||v > ma[1]/1){err=true}
      } else if (t==2){
        rx=new RegExp("^[\\w\.=-]+@[\\w\\.-]+\\.[a-zA-Z]{2,4}$");if(!rx.test(v))err=true;
      } else if (t==3){ // date
        ma=a[i+1].split("#");at=v.match(ma[0]);
        if(at){
          cd=(at[ma[1]])?at[ma[1]]:1;cm=at[ma[2]]-1;cy=at[ma[3]];
          dte=new Date(cy,cm,cd);
          if(dte.getFullYear()!=cy||dte.getDate()!=cd||dte.getMonth()!=cm){err=true};
        }else{err=true}
      } else if (t==4){ // time
        ma=a[i+1].split("#");at=v.match(ma[0]);if(!at){err=true}
      } else if (t==5){ // check this 2
            if(o1.length)o1=o1[a[i+1].replace(/(.*\[)|(\].*)/ig,"")];
            if(!o1.checked){err=true}
      } else if (t==6){ // the same
            if(v!=MM_findObj(a[i+1]).value){err=true}
      }
    } else
    if (!o.type&&o.length>0&&o[0].type=='radio'){
          at = a[i].match(/(.*)\[(\d+)\].*/i);
          o2=(o.length>1)?o[at[2]]:o;
      if (t==1&&o2&&o2.checked&&o1&&o1.value.length/1==0){err=true}
      if (t==2){
        oo=false;
        for(j=0;j<o.length;j++){oo=oo||o[j].checked}
        if(!oo){s+='* '+a[i+3]+'\n'}
      }
    } else if (o.type=='checkbox'){
      if((t==1&&o.checked==false)||(t==2&&o.checked&&o1&&o1.value.length/1==0)){err=true}
    } else if (o.type=='select-one'||o.type=='select-multiple'){
      if(t==1&&o.selectedIndex/1==0){err=true}
    }else if (o.type=='textarea'){
      if(v.length<a[i+1]){err=true}
    }
    if (err){s+='* '+a[i+3]+'\n'; err=false}
  }
  if (s!=''){alert('Corectati urmatoarele erori:\n\n'+s)}
  document.MM_returnValue = (s=='');
}

// The ajax needed to load the pages into the layers

var loadedobjects="";
var rootdomain="http://"+window.location.hostname;

function bring_to_layer(url, containerid){
	
show_hide('loader_1');

var page_request = false;
if (window.XMLHttpRequest) // if Mozilla, Safari etc
page_request = new XMLHttpRequest()
else if (window.ActiveXObject){ // if IE
try {
page_request = new ActiveXObject("Msxml2.XMLHTTP")
} 
catch (e){
try{
page_request = new ActiveXObject("Microsoft.XMLHTTP")
}
catch (e){}
}
}
else
return false
page_request.onreadystatechange=function(){
loadpage(page_request, containerid)
}
page_request.open('POST', url, true)
page_request.send(null)
}

function loadobjs(){
if (!document.getElementById)
return
for (i=0; i<arguments.length; i++){
var file=arguments[i]
var fileref=""
if (loadedobjects.indexOf(file)==-1){ //Check to see if this object has not already been added to page before proceeding
if (file.indexOf(".js")!=-1){ //If object is a js file
fileref=document.createElement('script')
fileref.setAttribute("type","text/javascript");
fileref.setAttribute("src", file);
}
else if (file.indexOf(".css")!=-1){ //If object is a css file
fileref=document.createElement("link")
fileref.setAttribute("rel", "stylesheet");
fileref.setAttribute("type", "text/css");
fileref.setAttribute("href", file);
}
}
if (fileref!=""){
document.getElementsByTagName("head").item(0).appendChild(fileref)
loadedobjects+=file+" " //Remember this object as being already added to page
}
}
}

function loadpage(page_request, containerid){
if (page_request.readyState == 4 && (page_request.status==200 || window.location.href.indexOf("http")==-1)) {
document.getElementById(containerid).innerHTML=page_request.responseText;
show_hide('loader_1');
}
}

// The ajax needed to load the pages into the layers END

function rewriteContent(el, the_content){
	document.getElementById(el).innerHTML = the_content;
}

function goUp(el, val) {
	document.getElementById(el).scrollTop = val;
}

function setVal(el, val) {
	document.getElementById(el).value = val;
}

function show_hide (id) {
	var e = document.getElementById(id);
		if (e.style.display == 'none') { e.style.display = ''; }
		else { e.style.display = 'none'; }
}

function show_element (id) {
	var e = document.getElementById(id);
		e.style.display = '';
}

function hide_element (id) {
	var e = document.getElementById(id);
		e.style.display = 'none';
}

//select while you type
var timerid     = null;
	var matchString = "";
	var mseconds    = 1000;	// Length of time before search string is reset

function shiftHighlight(keyCode,targ)
{

	keyVal      = String.fromCharCode(keyCode); // Convert ASCII Code to a string
	matchString = matchString + keyVal; // Add to previously typed characters

	elementCnt  = targ.length - 1;	// Calculate length of array -1

	for (i = elementCnt; i > 0; i--)
	{

		selectText = targ.options[i].text.toLowerCase(); // convert text in SELECT to lower case

		if (selectText.substr(0,matchString.length) == 	matchString.toLowerCase())
		{

			targ.options[i].selected = true; // Make the relevant OPTION selected

		}

	}

	clearTimeout(timerid); // Clear the timeout
	timerid = setTimeout('matchString = ""',mseconds); // Set a new timeout to reset the key press string
	
	return false; // to prevent IE from doing its own highlight switching

}