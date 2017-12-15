<?php
/***
*index.php front-page
*
*@author huichuan.li
*@link https://github.com/HuichuanLI
*@since 2017.6
*@copyright Gpl
*/


function succ($res){
	$result='succ';
	require(ROOT.'/view/admin/info.html');
	exit();
}

function error($res){
	$result='fail';
	require(ROOT.'/view/admin/info.html');
	exit();
}
/**
 * get ip
 */
function getRealIp() {
	static $realip = null;
	if($realip !== null) {
		return $realip;
	}
	if(getenv('REMOTE_ADDR')) {
		$realip = getenv('REMOTE_ADDR');
	} else if(getenv('HTTP_CLIENT_IP')) {
		$realip = getenv('HTTP_CLIENT_IP');
	} else if (getenv('HTTP_X_FROWARD_FOR')) {
		$realip = getenv('HTTP_X_FROWARD_FOR');
	}

	return $realip;
}

/**
 * @param int $num
 * @param int $page
 * @param int $cnt in each page there is how many item
 */
function getPage($num,$curr,$cnt){
		$max=ceil($num/$cnt);
		//left
		$left=max(1,$curr-2);
		//right
		$right=min($left+4,$max);

		$left = max(1,$right-4);
		$page=array();
		for($i=$left;$i<$right;$i++){
			$_GET['page'] = $i;
 			$page[$i] = http_build_query($_GET);
		}
		return $page;
}

function randStr($num=6) {
	$str = str_shuffle('abcedfghjkmnpqrstuvwxyzABCEDFGHJKMNPQRSTUVWXYZ23456789');
	return substr($str, 0 , $num);
}

//echo randStr();

/**
* 创建目录 ROOT.'/upload/2015/01/25/qwefas.jpg'
*
*/
function createDir() {
	$path = '/upload/'.date('Y/m/d');
	$fpath = ROOT . $path;
	if(is_dir($fpath) || mkdir($fpath , 0777 , true)) {
		return $path;
	} else {
		return false;
	}
}

/**
* 获取文件后缀
* @param str $filename 文件名
* @return str 文件的后缀名,且带点.
*/
function getExt($filename) {
	return strrchr($filename, '.');
}


//echo randStr();
/*
* 生成缩略图
*
* @param str $oimg /upload/2016/01/25/asdfed.jpg location of the picture
* @param int $sw 生成缩略图的宽
* @param int $sh 生成缩略图的高
* @return str 生成缩略图的路径 /upload/2016/01/25/asdfed.png
*/

function makeThumb($oimg , $sw=200 , $sh = 200) {
	//缩略图存放的路径的名称
	$simg = dirname($oimg) . '/' . randStr() . '.png';

	$opath = ROOT . $oimg;//原图的绝对路径
	$spath = ROOT . $simg;//最终生成的小图

	//创建小画布
	$spic = imagecreatetruecolor($sw, $sh);

	//创建白色
	$white = imagecolorallocate($spic, 255, 255, 255);
	imagefill($spic, 0, 0, $white);

	//获取大图信息
	list($bw , $bh ,$btype) = getimagesize($opath);
	//1 = GIF，2 = JPG，3 = PNG，4 = SWF，5 = PSD，6 = BMP，
	//7 = TIFF(intel byte order)，8 = TIFF(motorola byte order)，9 = JPC，10 = JP2，
	//11 = JPX，12 = JB2，13 = SWC，14 = IFF，15 = WBMP，16 = XBM
	$map = array(
		1=>'imagecreatefromgif',
		2=>'imagecreatefromjpeg',
		3=>'imagecreatefrompng',
		15=>'imagecreatefromwbmp'
	);
	if(!isset($map[$btype])) {
		return false;
	}
	$opic = $map[$btype]($opath);//大图资源
	//imagecreatefromjpeg(filename)

	//计算缩略比
	$rate = min($sw/$bw , $sh/$bh);
	$zw = $bw * $rate;//最终返回的小图宽
	$zh = $bh * $rate;//最终返回的缩略小图高

	//imagecopyresampled(dst_image, src_image, dst_x, dst_y,
		//src_x, src_y, dst_w, dst_h, src_w, src_h)
	//echo $rate ,  '<br>' , $zw , '<br>' , $zh ;exit();
	//imagecopyresampled($spic, $opic, 0, 0, 0, 0, $zw, $zh, $bw, $bh);

	imagecopyresampled($spic, $opic, ($sw-$zw)/2, ($sh-$zh)/2, 0, 0, $zw, $zh, $bw, $bh);

	imagepng($spic , $spath);

	imagedestroy($spic);
	imagedestroy($opic);

	return $simg;
}
/*
*the user is log in
*/
function acc() {
	return isset($_COOKIE['name']);
	// if(!isset($_COOKIE['name']) || !isset($_COOKIE['ccode'])){
	// 	return false;
	// }
	// return $_COOKIE['ccode'] === cCode($_COOKIE['name']);
}

function cCode($name) {
	$salt = require(ROOT . '/lib/config.php');
	return md5($name . '|' . $salt['salt']);
}
