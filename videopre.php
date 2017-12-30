<?php
//返回值：0成功 1截取失败 2目标已存在 3源文件不存在 4取源文件信息失败
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
$picfile = $ffilename."00.jpg";
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
$cmd2 = $ffmpeg." -i ".$videoaddr." -vf fps=".$picnum."/".$seconds." -f image2 -s ".$picsize." ".$dir.$ffilename."%02d.jpg -y 2>&1";
exec($cmd2,$callback2);
if (count($callback2) == 0) {
    die("1");
}
echo "0";
?>