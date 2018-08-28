function showResult(str) {
  if (str.length==0) { 
    document.getElementById("resultsdiv").innerHTML="";
    document.getElementById("resultsdiv").style.border="0px";
    document.getElementById("resultsdiv").style.visibility="hidden";
    return;
  }else{
      document.getElementById("resultsdiv").style.visibility="visible"; 
  }
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
        if (this.responseText != 0){
            document.getElementById("resultsdiv").innerHTML=this.responseText; 
        }else{
            document.getElementById("resultsdiv").innerHTML="<p class='white arial'>Nothing Found.</p>";
        }
    }
  }
  xmlhttp.open("GET","php/server/livesearch.php?q="+str,true);
  xmlhttp.send();
}