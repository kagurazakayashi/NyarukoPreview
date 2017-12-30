$(document).ready(function(){
});
function mousemove(thisdiv) {
    var tid = thisdiv.id;
    var tdiv = $("#"+tid);
    var offx = event.offsetX;
    var twidth = parseInt(tdiv.width());
    var per = offx / twidth;
    var pdiv = $("#"+tid+" .nyarukopreview_prog");
    var wblo = parseInt(per*10);
    var tdivn = parseInt(tdiv.attr("nowpic"));
    if (tdivn != wblo && wblo > -1) {
        tdiv.attr("nowpic",wblo);
        pdiv.css("width",per*100+"%");
        //console.log(wblo);
    }
}