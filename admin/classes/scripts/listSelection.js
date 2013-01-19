
function listSelection() {

    this.selectedCount = 0;
    this.selectedItems = new Object();
    
    this.findCheckbox = function(row) {
        try {
		    var cell = row.cells[row.cells.length-1];
		    var checkbox = cell.childNodes[0];
		    if(typeof(checkbox.type) == "undefined")
			    checkbox = cell.childNodes[1];
        }
        catch(e) {
        }
        return checkbox ? (checkbox.type == "checkbox" ? checkbox : null) : null;
    }
    
    this.setSelection = function(row, forseSelection) {
		
		
		if(g_shiftKey && forseSelection == undefined) {
		//alert(g_altKey);
		    this.setAllSelection(row);
		    return;
		}
		
		row.onselectstart = this.nullevent;
		var checkbox = this.findCheckbox(row);
		if(checkbox != null) {
			if(forseSelection != undefined) {
			    checkbox.checked = forseSelection;
			    row.className = checkbox.checked ? "selected" : "normal";
			    if(forseSelection)
			        this.selectItem(row);
			    else
			        this.unselectItem(row);
			}
			else {
			
			    if(!checkbox.checked) {
			        //unselect
			        if(!g_ctrlKey)
						this.clearSelection();
					this.selectItem(row);
			        checkbox.checked = !checkbox.checked;
			        row.className = checkbox.checked ? "selected" : "normal";
			        this.selectedCount++;
			    }
			    else {
			        var selcount = this.selectedCount;
			        if(!g_ctrlKey) {
						this.clearSelection();
						if(selcount > 1) {
						    this.setSelection(row);
						    this.selectedCount = 1;
						}
					}
					else {
			            this.unselectItem(row);
				        checkbox.checked = !checkbox.checked;
				        row.className = checkbox.checked ? "selected" : "normal";
				        this.selectedCount--;
                    }
			    }
			    
			}
		}
		
		try { window.getSelection().removeAllRanges(); } catch(ee) {}
		try { document.selection.empty(); } catch(ee) { }
		
	}
    
    this.findSelectedItem = function(table) {
		var els = document.getElementsByTagName("INPUT");
		var i=0;
        for(i=0; i<els.length; i++) {
            if(els[i].type == "checkbox" && els[i].getAttribute("hilitable") == "1" && (table.contains ? table.contains(els[i]) : true))
                if(els[i].checked)
                    return els[i];
        }
        return null;
    }
    
    this.findTable = function(row) {
        var table = row;
        while(table.tagName != "TABLE") {
            table = table.parentNode;
        }
        return table;
    }
    
    this.nullevent = function(e) {
        if(!e)
            e = window.event;
        e.returnValue = false;
        e.cancelBubble = true;
        return false;
    }
    
    this.setAllSelection = function(row, table) {
		if(table == undefined) {
			table = document.body; //this.findTable(row);
		}
		
		table.onselectstart = this.nullevent;
			
		// var checkbox = this.findCheckbox(row);
        var chk = this.findSelectedItem(table); 

		var els = document.getElementsByTagName("INPUT");
		var i=0;
        for(i=0; i<els.length; i++) {
            if(els[i].type == "checkbox" && els[i].getAttribute("hilitable") == "1" && (table.contains ? table.contains(els[i]) : true))
                if(els[i] == chk)
                    break;
        }
    
		for(ii=i+1; ii<els.length; ii++) {
			if(els[ii].type == "checkbox" && els[ii].getAttribute("hilitable") == "1" && (table.contains ? table.contains(els[ii]) : true)) {
			    this.setSelection(els[ii].parentNode.parentNode, !els[ii].checked);
			}
		    if(els[ii].parentNode.parentNode == row)
		        break;
		}
    }
    
    this.clearSelection = function(table) {
		
		if(table == undefined)
			table = document.body;

		var els = document.getElementsByTagName("INPUT");
		for(var i=0; i<els.length; i++) {
			if(els[i].type == "checkbox" && els[i].getAttribute("hilitable") == "1" && (table.contains ? table.contains(els[i]) : true)) {
				if(els[i].parentNode.tagName == "TD") {
					if(els[i].checked) {
					    this.setSelection(els[i].parentNode.parentNode, false);
					}
				}
			}
		}
		
		this.cleanSelection();
        
    }
    
    this.cleanSelection = function() {
		try { this.selectedItems = new Object(); } catch (e) {}
		this.selectedCount = 0;
    }
    
    this.restoreSelection = function() {
		try {
			this.selectedItems = this.unserializeSelection(this.getCookie("pioneer_windowChecks"), ":");
			for(name in this.selectedItems) {
				if(this.selectedItems[name] != null) {
					var id = this.selectedItems[name];
					var obj = document.getElementById(id);
					if(obj) {
						nodeEnsureVisible(obj);
						this.setSelection(obj, true);
						try { obj.scrollIntoView(false); } catch(e) {}
					}
					else {
						this.selectedItems[name] = null;
					}
				}
			}
			//this.selectedCount = this.selectedItems.length;
		}
		catch (e) {
		}
    }
    
    this.selectItem = function(element) {
		try {
			this.selectedItems[element.id] = element.id;
			var value = this.serializeSelection(":");
			this.setCookie("pioneer_windowChecks", value, 30, "/", "", false);
			//this.selectedCount = this.selectedItems.length;
		}
		catch (e) {
			
		}
	}
	
	this.unselectItem = function(element) {
		try {
			this.selectedItems[element.id] = null;
			var value = this.serializeSelection(":");
			this.setCookie("pioneer_windowChecks", value, 30, "/", "", false);					
			//this.selectedCount = this.selectedItems.length;
		}
		catch (e) {
			
		}
	}
	
	this.serializeSelection = function(splitter) {
		var value = "";
		for(name in this.selectedItems) {
			if(this.selectedItems[name] != null)
				value += (splitter+this.selectedItems[name]);
		}
		return value;
	}

	this.unserializeSelection = function(str, splitter) {
		var ret = new Object();
		var value = str.split(splitter);
		for(var i=0; i < value.length; i++) {
			if(value[i] != "" && value[i] != "null")
				ret[value[i]] = value[i];
		}
		return ret;
	}
	
	this.getCookie = function( c_name ) 
	{
		if (document.cookie.length>0)
		{
			c_start=document.cookie.indexOf(c_name + "=");
			if (c_start!=-1)
			{ 
				c_start=c_start + c_name.length+1;
				c_end=document.cookie.indexOf(";",c_start);
				if (c_end==-1) c_end=document.cookie.length;
				return unescape(document.cookie.substring(c_start,c_end));
			} 
		}
		return null;
		
	}

	
	this.setCookie = function( name, value, expires, path, domain, secure ) 
	{
		var today = new Date();
		today.setTime( today.getTime() );
		if ( expires )
			expires = expires * 1000 * 60 * 60 * 24;

		var expires_date = new Date( today.getTime() + (expires) );
		document.cookie = name + "=" +escape( value ) +
		( ( expires ) ? ";expires=" + expires_date.toGMTString() : "" ) + 
		( ( path ) ? ";path=" + path : "" ) + 
		( ( domain ) ? ";domain=" + domain : "" ) +
		( ( secure ) ? ";secure" : "" );
	}
	
	

}