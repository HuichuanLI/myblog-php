<?php
/***
*index.php front-page
*
*@author huichuan.li
*@link https://github.com/HuichuanLI
*@since 2017.6
*@copyright Gpl
*/
error_reporting(E_ALL ^ E_DEPRECATED);
//connect to the sql
$conn=mysql_connect('localhost','root','');
mysql_query('use blog',$conn);
mysql_query('set names utf-8');
//check the item is Empty

$cat_id =trim($_GET['cat_id']);
if(empty($_POST)){
  $sql="select catname from cat where cat_id=$cat_id";
  $rs=mysql_query($sql);
  $cat=mysql_fetch_assoc($rs);
  require('./view/admin/catedit.html');
}else{
  $sql="update cat set catname='$_POST[catname]' where cat_id=$cat_id";
  if(!mysql_query($sql)){
    echo "failure, error!";
  }else{
    echo "success!";
  }
}
