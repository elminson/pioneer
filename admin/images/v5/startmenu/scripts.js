var last_fl = null;
function  fl_up(event, obj) {
    if(last_fl) {
        last_fl.className="item";
        document.getElementById(last_fl.id+"_childs").style.display = "none";
    }
        
    obj.className = "item selected";
    document.getElementById(obj.id+"_childs").style.display = "";
    
    last_fl = obj;
}

function startmenu_show(event, left, top) {
    event.cancelBubble = true;
    
    if(document.getElementById("startmenu").style.display == "") {
        startmenu_hide();
        return false;
    }
    

    document.getElementById("startmenu").style.display = "";
    document.getElementById("startmenu").style.left = left+"px";
    document.getElementById("startmenu").style.top = top+"px";
    return false;
}

function startmenu_hide() {
     document.getElementById("startmenu").style.display = "none";
}

function stop_clickevent(event) {
    event.cancelBubble = true;
    return false;
}

var mf_last = null;
function mf_up(event, obj) {
    if(mf_last && mf_last.childNodes[1])
        mf_last.childNodes[1].style.display = "none";
    if(obj.childNodes[1])
        obj.childNodes[1].style.display = "";
    mf_last = obj;
}

function mf_down() {
    if(mf_last && mf_last.childNodes[1])
        mf_last.childNodes[1].style.display = "none";
}