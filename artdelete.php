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


$art_id = $_GET['art_id'];


if(!is_numeric($art_id)){
	error("the id is invalid");
}

$sql= "select * from art where art_id=$art_id";
if(!mGetRow($sql)){
	error("the article id is not invalid!");
}
$sql= "delete from art where art_id=$art_id";
if(!mQuery($sql)){
	error('failure!');
}else{
	//succ('avec success!');
	header('Location:artlist.php');
}
