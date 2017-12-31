<?php
//返回值：0成功 1截取失败 2目标已存在 3源文件不存在 4取源文件信息失败 5读取临时截图失败 6图片拼接失败 7删除临时文件失败 8创建CSS失败
include "videopreconf.php";
header('Content-Type: text/plain');
if (!isset($_GET["file"])) {
    die("1");
}
$overlay = false;
if (isset($_GET["overlay"])) {
    $overlay = true;
}
$videoaddr = $maindir.htmlentities($_GET["file"]);
if (!isset($videoaddr)) {
    die("3");
}
$videoaddrarr = explode(DIRECTORY_SEPARATOR,$videoaddr);
$ifilename = $videoaddrarr[count($videoaddrarr)-1];
$ffilename = explode(".",$ifilename)[0];
$picfile = $ffilename."_p.jpg";
array_pop($videoaddrarr);
$dir = implode(DIRECTORY_SEPARATOR,$videoaddrarr).DIRECTORY_SEPARATOR;
if (file_exists($dir.$picfile) && $overlay == false) {
    die("2");
}
$cmd = $ffmpeg." -i ".$videoaddr." 2>&1 | grep 'Duration' | cut -d ' ' -f 4 | sed s/,//";
exec($cmd,$callback);
if (count($callback) == 0) {
    die("4");
}
$cmdr = $callback[0];
$parsed = date_parse($cmdr);
$seconds = $parsed['hour'] * 3600 + $parsed['minute'] * 60 + $parsed['second'];
$cmd2 = $ffmpeg." -i ".$videoaddr." -vf fps=".$picnum."/".$seconds." -f image2 -s ".$picwidth."x".$picheight." ".$dir.$ffilename."%02d.jpg -y 2>&1";
exec($cmd2,$callback2);
if (count($callback2) == 0) {
    die("1");
}
$imagesarr = array();
$cmd3 = $imagemagick_convert." -append ";
$cmd4 = $deletecmd;
$cssclass = ".".$ffilename." ";
$css = $cssclass."{display:inline-block; overflow:hidden; background-repeat:no-repeat; background-image:url(".$picfile.");}";
$ppicsizeheight = $picnum * $picheight;
for ($i=1; $i < $picnum+1; $i++) { 
    $istr = strval($i);
    if ($i<10) {
        $istr = "0".$istr;
    }
    $npicfile = $dir.$ffilename.$istr.".jpg";
    if (!file_exists($npicfile)) {
        die("5".$npicfile);
    }
    $cmd3 = $cmd3.$npicfile." ";
    $cmd4 = $cmd4." ".$npicfile;
    $css = $css." .".$ffilename.$i." {width:".$picwidth."px; height:".$picheight."px; background-position:0px -".($picheight*($i-1))."px;}";
}
$cmd3 = $cmd3.$dir.$ffilename."_p.jpg 2>&1";
exec($cmd3,$callback3);
if (count($callback3) != 0) {
    die("6");
}
exec($cmd4,$callback4);
if (count($callback4) != 0) {
    die("7");
}
try 
{ file_put_contents($dir.$ffilename."_p.css", $css); } 
catch(Exception $e)
{ die("8"); }
echo "0";
?>