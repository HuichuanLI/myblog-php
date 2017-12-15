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
$comment_id = $_GET['comment_id'];
//获取当前评论的 art_id
$sql = 'select art_id from comment where comment_id=' . $comment_id;
$art_id = mGetOne($sql);
//删除评论表这条评论
$sql = 'delete from comment where comment_id=' . $comment_id;
$rs = mQuery($sql);
//如果获取art_id 成功 更改art表的comm 评论数
if($art_id) {
$sql = 'update art set comm=comm-1 where art_id=' . $art_id;
mQuery($sql);
}
//跳转到上一页 commlist.php
$ref = $_SERVER['HTTP_REFERER'];
header("Location: $ref");


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
