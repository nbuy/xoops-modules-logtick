// XMLHttpRequest general handler

function createXmlHttp(){
    if (window.XMLHttpRequest) {             // Mozilla, Firefox, Safari, IE7
        return new XMLHttpRequest();
    } else if (window.ActiveXObject) {       // IE5, IE6
        try {
            return new ActiveXObject("Msxml2.XMLHTTP");    // MSXML3
        } catch(e) {
            return new ActiveXObject("Microsoft.XMLHTTP"); // until MSXML2
        }
    } else {
        return null;
    }
}

var xmlhttp = createXmlHttp();
var timerid;
function sendPostComment(myform) {
    var args = new Array();
    for (i=0; i<myform.elements.length; i++) {
	ele = myform.elements[i];
	if (ele.name!="") args.push(ele.name+"="+encodeURIComponent(ele.value));
    }
    args.push("after=0");
    xmlhttp.open("POST", "index.php");
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.onreadystatechange = function() {
	if (xmlhttp.readyState == 4 && xmlhttp.responseText != "") {
	    var mylist = xoopsGetElementById("mylist");
	    mylist.innerHTML = xmlhttp.responseText;
	}
    }
    xmlhttp.send(args.join("&"));
    myform.comment.value = "";
    return false;
}

function showNewLogs(myform) {
    var args = new Array();
    for (i=0; i<myform.elements.length; i++) {
	ele = myform.elements[i];
	if (ele.name!="" && ele.checked) args.push(ele.name+"="+encodeURIComponent(ele.value));
    }
    args.push("after="+myform.view.value);
    xmlhttp.open("GET", "index.php?"+args.join("&"));
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.onreadystatechange = function() {
	if (xmlhttp.readyState == 4 && xmlhttp.responseText != "") {
	    if (xmlhttp.responseText.match(/^\s*</)) {
		var mylist = xoopsGetElementById("mylist");
		mylist.innerHTML = xmlhttp.responseText;
	    } else {		// nothing display, only timestamp update
		var mylist = xoopsGetElementById("timestamp");
		mylist.innerHTML = xmlhttp.responseText;
	    }
	    // update time
	    ret=xmlhttp.responseText.match(/-- now: (\d+)/);
	    if (ret) {
		var myform = document.forms.logtickview;
		myform.view.value = ret[1];
	    }
	}
    }
    xmlhttp.send(null);
    if (timerid) clearTimeout(timerid);
    if (ival==null) ival=60000; // 1min redraw
    timerid = setTimeout(autoRedraw, ival);
    return false;
}

function autoRedraw() {
    showNewLogs(document.forms.logtickview);
}
