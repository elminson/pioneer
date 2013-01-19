	window.dialogs = new Array();
	
	var imgLoading = new Image();
	imgLoading.src = "/admin/images/loading.gif";
	
	ShowLoading(true);

	
	if(navigator.appName == "WebTV")
	{
		window.browserType = "WTV";
	}
	if(navigator.appName == "Netscape")
	{
		window.browserType = "NS";
	}
	if(navigator.appName == "Microsoft Internet Explorer")
	{
		window.browserType = "IE";
	}
	
	window.browserVersion = (navigator.appVersion.split(" "))[0];
	
	window.selectionInfo = new listSelection();
	
	function Size(w, h, resizable, modal) {
		this.width = w;
		this.height = h;
		this.resizable = resizable;
		this.modal = modal;
	}

	function UploadFile(enable) {
		if(enable)
			document.getElementById('idfPostBack').enctype="multipart/form-data";
		else
			document.getElementById('idfPostBack').enctype="application/x-www-form-urlencoded";
	}

	function PostBack(command, method, section, action, message, adurl) {

		var b = true;
		if(message)
			b = window.confirm(message);
    
		if(b) {

            try {		    
		        ShowLoading();
			    if(method != null)
				    document.getElementById('idfPostBack').method = method;
			    if(section != null)
				    document.getElementById('idfPostBack').elements.postback_section.value = section;
			    if(action != null)
				    document.getElementById('idfPostBack').elements.postback_action.value = action;
			    document.getElementById('idfPostBack').elements.postback_command.value = command;
			    for(url in adurl) {
					var u = document.getElementById('idfPostBack').elements[url];
					if(u) {
						u.value = adurl[url];
					}
					else {
						var input = document.createElement("INPUT");
						input.type = "hidden";
						input.name = url;
						input.value = adurl[url];
						document.getElementById('idfPostBack').appendChild(input);
					}
			    }
			    document.getElementById('idfPostBack').submit();
			}
			catch(e) {
			    
			}
			if(window.event) {
			    window.event.returnValue = false;
			    window.event.cancelBubble = true;
			}
			return false;
		}
	}
	
	function PostBackToFloater(command, method, section, action, message, adurl, width, height, resizable, except) {
		var b = true;
		if(message)
			b = window.confirm(message);
		if(b) {
		    
		    // ShowLoading();
		
			url = "floating.php?";
			url += "postback_section="+section+"&";
			url += "postback_action="+action+"&";
			url += "postback_command="+command+"&";
				
			var form = document.getElementById('idfPostBack');
			for(var i=0; i<form.elements.length; i++) {
				var el = form.elements[i];
                if(el.name && el.name.substr(0, "postback_".length) != "postback_" && el.value != '') {
					if(el.type=="checkbox") {
						if(el.checked && (el.value != '' && el.value != null)) {
							try {
								if(except.indexOf(el.name) == -1)
									url += el.name + "="+escape(el.value)+"&";
							}
							catch(e) {
								url += el.name + "="+escape(el.value)+"&";									
							}
						}
					}
					else  {
                        if(el.value != '' && el.value != null) {
						    try {
							    if(except.indexOf(el.name) == -1)
								    url += el.name + "="+escape(el.value)+"&";
						    }
						    catch(e) {
							    url += el.name + "="+escape(el.value)+"&";									
						    }
                        }
					}
				}
			}
			
			for(u in adurl) {
				url += u + "="+adurl[u]+"&";
			}
			url = url.substr(0, url.length-1);
			OpenFloater(null, url, new Size(width, height, resizable));
		}			
	}
	
	function Relocate(url, e) {
        if(g_ctrlKey) {
            window.open(url);
        }
        else {
	    	ShowLoading(); 
	    	location = url;
        }
	}
	
	function ShowLoading(wr) {
	    if(wr) {
	        document.write("<div id='idLoading' style='position: absolute; left: 49%; top: 49%; z-index: 10000; padding-left: 10px; padding-right: 10px;'><table height='70'><tr><td><img src='/admin/images/loading.gif'></td></tr></table></div>");
	    }
	    else {
	        document.getElementById('idLoading').style.display = "";
	    }
	}
	
	function ShowWindow(url, name, initialsize) {
/*	  if (window.browseType == "IE") {
		
		var cx = (window.screen.width - initialsize.width) / 2 - 50;
		var cy = (window.screen.height- initialsize.height) / 2 - 50;
		if(!initialsize.resizable) 
			initialsize.resizable = "no";
		else
			initialsize.resizable = "yes";
		var attributes = "resizable;"+initialsize.resizable+",scrollbars:0;top:" + cy + "px;left:" + cx + "px;dialogWidth:" + (initialsize.width+20) + "px;dialogHeight:" + initialsize.height+"px";

		if(initialsize.modal == undefined || initialsize.modal == false)
			currentPopup = window.showModelessDialog(url, window, attributes+';minimize:yes;maximize:yes;help:no;scroll:no;status:no;center:yes;');
		else
			currentPopup = window.showModalDialog(url, window, attributes+';minimize:yes;maximize:yes;help:no;scroll:no;status:no;center:yes;');
		currentPopup.document.open();
		currentPopup.document.write("<body><iframe style='width:100%; height:100%' src='"+url+"'></body>");
		currentPopup.document.close();
//		currentPopup = window.open(url, name, attributes+',dependent=yes,modal=yes,status=no');
	  }
	  else
	  {
		  */
		var cx = (window.screen.width - initialsize.width) / 2 - 50;
		var cy = (window.screen.height- initialsize.height) / 2 - 50;
		if(!initialsize.resizable) 
			initialsize.resizable = 0;
		else
			initialsize.resizable = 1;
		var attributes = "ontop=1,status=0,help=0,resizable="+initialsize.resizable+",scrollbars=0,top=" + cy + ", left=" + cx + ", width=" + initialsize.width + ",height=" + initialsize.height;

		currentPopup = window.open(url, name, attributes+',dependent=yes,modal=yes,status=no'+(initialsize.modal == undefined || initialsize.modal == false ? ",modal=yes" : ""));
//	  }
	  currentPopup.focus();
	  currentPopup.opener = window;
	  return currentPopup;
	}
	
	function OpenFloater(name, url, initialsize) {
		if(name == null) {
			name = new Date();
			name = "name"+name.getFullYear()+name.getMonth()+name.getDate()+name.getHours()+name.getMinutes()+name.getSeconds();
		}
		var wnd = ShowWindow(url, name, initialsize);
		wnd.opener = window;
	}
	
	function ReloadFloatingOwnerWindow(urlargs) {
		try {
			
			ShowLoading(); 
			
			var obj = window.opener;
			var href = obj.location.href;
			var hrefs = href.split("?");
			if(hrefs.join != undefined) {
				href = hrefs[0];
			}
			if(urlargs != "")
				obj.location = href+"?"+urlargs;
			else
				obj.location.reload();
			window.setTimeout("FocusMe();", 200);
		}
		catch(e) {}
	}
	
	function createArray() {
		var ret = new Array();
		for(var i=0; i<arguments.length;i+=2) {
			ret[arguments[i]] = arguments[i+1];
		}
		return ret;
	}

	function FocusMe() {
		try {
			window.focus();
			window.setActive();
		}
		catch(e) {}
	}
	
	function getFirstChildElement(node) {
		var n = node.childNodes[0];
		if(window.browserType != "IE")
			n = node.childNodes[1];
		return n;
	}
	
	function toggleBranch(img, e, id) {
	    if(!e)
	        e = window.event;
	    
	    try {
	        var srccheck = img.src.substr(("http://"+document.domain).length);
            var normal = img.getAttribute("normal").toString();
            window.selectionInfo.setCookie("site_table_id_"+id, (srccheck != normal), 30, "/", "", false);
            showBranch(img, (srccheck != normal));
	    }
        catch(ex) {
	    }
	    
	    e.returnValue = false;
	    e.cancelBubble = true;
	    return false;
	}

    function showBranch(img, show){
        var c = null;
        
        c = img;
        while(c.nodeName != "LI") {
            c = c.parentNode;
        }
        
        if(window.browserType == "IE")
            c = c.childNodes[1];
        else
            c = c.childNodes[3];
        
        var closed = img.getAttribute("closed");
        var normal = img.getAttribute("normal");
        if(show) {
            img.src = normal;
            c.style.display = "";
        }
        else {
            img.setAttribute("src", img.getAttribute("closed"));
            c.style.display = "none";
        }
    }
    
    function nodeEnsureVisible(node) {
        try {
            var tt = findParentULs(node, "tree");
            for(var i=0; i<tt.length-1; i++) {
                var obj = tt[i];
                showBranch(obj.parentNode.childNodes[0].rows[0].cells[0].childNodes[0].rows[0].cells[0].childNodes[0], true);
            }    
        }
        catch(ex) {}
    }
    
    function findParentULs(ul, idParent) {
        var tmp = ul;
        var t = new Array();
        while(tmp.id != idParent) {
            if(tmp.nodeName == "UL") {
                t[t.length] = tmp;
            }
            tmp = tmp.parentNode;
        }
        return t;
    }
	
