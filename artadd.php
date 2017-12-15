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
$sql='select * from cat';
$cat=mGetAll($sql);
error_reporting(E_ALL ^ (E_NOTICE && E_WARNING));
if(empty($_POST)){
 	include(ROOT.'/view/admin/artadd.html');
 }else{
 	//test le title is empty
 	$art['title']=trim($_POST['title']);
 	if($art['title'] == ''){
 		error('the title not empty');
 	}
  // test the pic
  if( !($_FILES['pic']['name'] == '' ) && $_FILES['pic']['error'] == 0) {
		$filename = createDir() . '/' . randStr() . getExt($_FILES['pic']['name']);
		if(move_uploaded_file($_FILES['pic']['tmp_name'], ROOT .  $filename)){
			$art['pic'] = $filename;
      $art['thumb']=makeThumb($filename);
		}
	}
 	//test
 	$art['cat_id']=$_POST['cat_id'];
 	if(!is_numeric($art['cat_id'])){
 		error('the cat is invaild');
 	}

 	$art['content']=$_POST['content'];
 	$art['pubtime']=time();
	$art['arttag'] = trim($_POST['tag']);;
	 if($art['content']==""){
 		error('the content  cannot  be empty');
	 }
 	if(!mExec('art',$art)){
 		error('failure');
 	}else{
		//判断是否有tag
		$art['tag'] = trim($_POST['tag']);
		if($art['tag'] == '') {
			//将cat 的 num 字段 当前栏目下的文章数 +1
			$sql = "update cat set num=num+1 where cat_id=$art[cat_id]";
			mQuery($sql);
			succ('success');
		} else {
			//获取上次 insert 操作产生的主键id
			$art_id = getLastId();
			//插入tag 到tag表
			//liunx,mysql,php
			//insert into tag (art_id,tag) values (5 , 'linux') , (5 , 'mysql') , (5 , 'php')
			$tag = explode(',', $art['tag']);//索引数组
			//print_r($tag);
			$sql = "insert into tag (art_id,tag) values ";
			foreach($tag as $v) {
				$sql .= "(" . $art_id . ",'" . $v . "') ,";
			}
			$sql = rtrim($sql , ",");
			//echo $sql;
			if(mQuery($sql)) {
				//将cat 的 num 字段 当前栏目下的文章数 +1
				$sql = "update cat set num=num+1 where cat_id=$art[cat_id]";
				mQuery($sql);
				succ('success');
			} else {
				//tag 添加失败 删除原文章
				$sql = "delete from art where art_id=$art_id";
				if(mQuery($sql)){
				//将cat 的 num 字段 当前栏目下的文章数 +1
				$sql = "update cat set num=num-1 where cat_id=$art[cat_id]";
				mQuery($sql);
					error('failure');
				}
			}
		}
	}
 }
