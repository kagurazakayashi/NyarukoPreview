var nyarukopreview_confs = new Array();
$(document).ready(function(){
    var nyarukopreviews = $(".nyarukopreview");
    nyarukopreviews.each(function(i){
        var nnyarukopreview = $(this);
        var tvideo = nnyarukopreview.attr("video");
        $.getJSON(tvideo+"_p.json", function (data){
            nyarukopreview_confs[tvideo] = data;
        });
    });
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
    var tjson = video+"_p.json";
    var danmaku1 = $("#"+tid+" .nyarukopreview_danmaku1");
    if (tdivn != wblo && wblo > -1) {
        tdiv.attr("nowpic",wblo);
        pdiv.css("width",per*100+"%");
        tdiv.attr("class","nyarukopreview test "+video+wblo);
        if (nyarukopreview_confs[video] && nyarukopreview_confs[video]["danmaku"] && nyarukopreview_confs[video]["danmaku"][wblo-1]) {
            var dans = nyarukopreview_confs[video]["danmaku"][wblo-1];
            var danmakuarr = ["","&emsp;",""];
            var danmakui = 0;
            for (let dani = 0; dani < dans.length; dani++) {
                var nowdan = dans[dani];
                var nowdanline = danmakuarr[danmakui];
                nowdanline = nowdanline + nowdan + "&emsp;";
                danmakuarr[danmakui] = nowdanline;
                danmakui++;
                if (danmakui == 3) {
                    danmakui = 0;
                }
            }
            for (let danj = 0; danj < danmakuarr.length; danj++) {
                $("#"+tid+" .nyarukopreview_danmaku"+(danj+1)).html("<marquee>"+danmakuarr[danj]+"</marquee>");
            }
            $("#"+tid+" .nyarukopreview_danmaku").css("display","block");
        }
    }
    if (danmaku1.css("display") == "block") {
        pdivv.css("top",(tdiv.height()-80)+"px");
    } else {
        pdivv.css("top",(tdiv.height()-20)+"px");
        $("#"+tid+" .nyarukopreview_danmaku").html("");
    }
}
function hiddendanmaku(tid,tdiv,pdivv) {
    $("#"+tid+" .nyarukopreview_danmaku").css("display","none");
    pdivv.css("top",(tdiv.height()-20)+"px");
}
function nyarukopreview_mouseout(thisdiv) {
    var tid = thisdiv.id;
    var tdivv = $("#"+tid+" .nyarukopreview_progview");
    tdivv.css("display","none");
    $("#"+tid+" .nyarukopreview_danmaku").css("display","none");
}