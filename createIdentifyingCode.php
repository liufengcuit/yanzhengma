<?php
  //启动session
session_start();

$image = imagecreatetruecolor(100, 30);   //设置验证码图片大小的图片
$bgcolor = imagecolorallocate($image, 255, 255, 255);

imagefill($image, 0, 0, $bgcolor);

//设置变量
$identifying_code = "";
//生成随机数字
for($i=0;$i<4;$i++){
	$fontsize = 6;
	$fontcolor = imagecolorallocate($image, rand(0,120), rand(0,120), rand(0,120));
	//随机字母或者数字
	$fontcontent = null;
	$fongnum = rand(0,2);
	if($fongnum == 0){
		$fontcontent = rand(0,9);
	}else if($fongnum == 1){
		$fontcontent = chr(rand(65,90));
	}else{
		$fontcontent = chr(rand(97,122));
	}

	$identifying_code.= $fontcontent;

	$x = ($i*100/4)+rand(5,10);
	$y = rand(5,10);

	imagestring($image, $fontsize, $x, $y, $fontcontent, $fontcolor);
}

// 存到session
$_SESSION['authcode'] = $identifying_code;

//增加干扰元素，设置雪花点
for($i = 0;$i<200;$i++){
	//设置点的颜色，50-200颜色比数字浅，不干扰阅读
	$pointcolor = imagecolorallocate($image, rand(50,200), rand(50,200), rand(50,200));
	imagesetpixel($image, rand(1,99), rand(1,29), $pointcolor);
}

//增加干扰元素，设置横线
for($i=0;$i<4;$i++){
	//设置线的颜色
	$linecolor = imagecolorallocate($image, rand(80,220), rand(80,220), rand(80,220));
	//设置线，两点一线
	imageline($image,rand(1,99), rand(1,29), rand(1,99), rand(1,29), $linecolor);
}

//设置头部，image.png
header('Content-Type: image/png');
// imagpng()建立png图形函数
imagepng($image);
//imagedestory()结束图形函数，销毁$image
imagedestroy($image);
?>