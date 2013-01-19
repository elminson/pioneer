
    window.loadActions = new Array();

	String.prototype.trim = function(char){
		if(!char)
			char = " ";
		var s = new String(this);
		while (s.charAt(0) == char){
			s = s.substr(1, s.length - 1);
		}
		
		while (s.charAt(s.length - 1) == char){
			s = s.substr(0, s.length - 1);
		}
		return s;
	}
	
	function _selectnull() {
		return false;
	}

	function setCheckbox(name, value) {
		if(!document.getElementById("idfPostBack").elements[name].checked) {
			try {
			    window.selectionInfo.clearSelection();
			    window.selectionInfo.setSelection(document.getElementById("idfPostBack").elements[name].parentNode.parentNode, true);
			}
			catch(ex) {

			}
		}
	}
	
	function countSelectedChecks(table) {
	    var ret = new Array();
        for(var i=0; i<table.rows.length; i++) {
            var checkbox;
            if(window.browserType=="IE") {
            //alert(table.rows[i].cells[1].innerHTML);
                checkbox = table.rows[i].cells[1].children[0];
            }
            else
                checkbox = table.rows[i].cells[1].childNodes[0];
            
            if(checkbox) {
                if(checkbox.checked)
                    ret[ret.length] = checkbox;
            }
        }
        return ret;
	}
	
	function hideRow(row) {
	    row.parentNode.cells[1].style.display = row.parentNode.cells[1].style.display == "" ? "none" : "";
	    row.parentNode.className = row.parentNode.className == "" ? "hidden" : "";
	}

	function setRowCheck(row, forseSelection) {
	    window.selectionInfo.setSelection(row, forseSelection);
	}

	function popupWindow(name, src, w, h, resizable){
		var cx = window.screen.width / 2 - 50;
		var cy = window.screen.height / 2 - 50;
		if(!resizable) resizable = 0;
		var attributes = "status=0,help=0,resizable="+resizable+",scrollbars=0,top=" + cy + ", left=" + cx + ", width=" + w + ",height=" + h;
		window.open(src, name, attributes);
	}

    function toggleView(img, toggleObj, hide)    {
        
        if(toggleObj == undefined)
            toggleObj = img.offsetParent.offsetParent.rows[0].cells[1];
        if(hide == undefined)
            hide = img.offsetParent.offsetParent.rows[0].cells[2];
    
        toggleObj.style.display = toggleObj.style.display == "" ? "none" : "";
        hide.style.display = hide.style.display == "" ? "none" : "";
        if(toggleObj.style.display == "")
            img.src = img.getAttribute('hilited');
        else
            img.src = img.getAttribute('normal');
    }

	var g_ctrlKey = false;
	var g_altKey = false;
	var g_shiftKey = false;

	window.onload = windowLoad;
	document.onkeydown = _documentKeyDown;
	document.onkeyup = _documentKeyDown;

	function _documentKeyDown(e) {
		if(!e)
			e = window.event;

		g_ctrlKey = e.ctrlKey;
		g_altKey = e.altKey;
		g_shiftKey = e.shiftKey;

	}
	
    function ProcessTab(e) {
        if(!e)
            e = window.event;

        if(window.browserType == "IE") {
            if(e.keyCode == 9) { 
                var r = document.selection.createRange();
                r.text = '\t'; 
                r.collapse(false);
                r.select();
                return false;
            }
        }
        else {
            if(e.keyCode == 9) {
                var obj = e.target;
                start = obj.selectionStart;
                obj.value = obj.value.substr(0,start)+'\t'+obj.value.substr(start);
                obj.setSelectionRange(start+1, start+1);
                obj.focus();
                return false;
            }
        }
        return true;
    }
	
	function windowLoad() {
		try {
		    document.getElementById("idLoading").style.display = "none";
			window.selectionInfo.restoreSelection();
            for(key in window.loadActions) {
                eval(window.loadActions[key]);
            }
		}
		catch(ex) {
		}


	}
    
    window.onload = loadWindow;
    
    function resizeMainDiv(e) {

        var t = document.getElementById('top');
        var b = document.getElementById('bottom');
        var div = document.getElementById("divResizeMain");
    
        div.style.height = (document.body.clientHeight - t.offsetHeight - b.offsetHeight - 10) + 'px'; //(document.body.clientHeight-h)+"px";

    }
    
    function loadWindow() {

        if(window.browseType != "IE" && document.getElementById("divResizeMain") != null) {
            try { window.onresize = resizeMainDiv; } catch(ee) {}
            try { document.onresize = resizeMainDiv; } catch(ee) {}
            try { document.onclick = startmenu_hide; } catch(ee) {}
            try { resizeMainDiv(); } catch(ee) {}
        }
        
        windowLoad();
    }    


