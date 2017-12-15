<?php
/***
*index.php front-page
*
*@author huichuan.li
*@link https://github.com/HuichuanLI
*@since 2017.6
*@copyright Gpl
*/
require('./lib/init.php');
$art_id=$_GET['art_id'];
if(!is_numeric($art_id)){
	error('the article is invalide');
}
$sql="select * from art where art_id=$art_id";

if(!mGetRow($sql)){
	error("the article is not existed!");
}
$sql="select * from cat";
$cat = mGetAll($sql);
if(empty($_POST)) {
	$sql = "select title,content,cat_id,arttag from art where art_id=$art_id";
	$art = mGetRow($sql);
	include(ROOT . '/view/admin/artedit.html');
} else {
	
	$art['title'] = trim($_POST['title']);
	if($art['title'] == '') {
		error('标题不能为空');
	}

	
	$art['cat_id'] = $_POST['cat_id'];
	if(!is_numeric($art['cat_id'])) {
		error('栏目不合法');
	}

	
	$art['content'] = trim($_POST['content']);
	if($art['content'] == '') {
		error('内容不能为空');
	}

	$art['lastup'] = time();
	if(!mExec('art' , $art ,'update' , "art_id=$art_id")) {
		error('文章修改失败');
	} else {
		header('Location:artlist.php');
	}
}
