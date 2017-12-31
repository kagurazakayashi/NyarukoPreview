$(document).ready(function(){
});
function nyarukopreview_mousemove(thisdiv) {
    var tid = thisdiv.id;
    var tdiv = $("#"+tid);
    var offx = event.offsetX;
    var twidth = parseInt(tdiv.width());
    var per = offx / twidth;
    var pdiv = $("#"+tid+" .nyarukopreview_prog");
    var pdivv = $("#"+tid+" .nyarukopreview_progview");
    pdivv.css("display","block");
    var wblo = parseInt(per*10)+1;
    var tdivn = parseInt(tdiv.attr("nowpic"));
    var video = tdiv.attr("video");
    if (tdivn != wblo && wblo > -1) {
        tdiv.attr("nowpic",wblo);
        pdiv.css("width",per*100+"%");
        tdiv.attr("class","nyarukopreview test "+video+wblo);
    }
}
function nyarukopreview_mouseout(thisdiv) {
    var tid = thisdiv.id;
    var tdivv = $("#"+tid+" .nyarukopreview_progview");
    tdivv.css("display","none");
}