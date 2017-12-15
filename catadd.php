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
error_reporting(E_ALL ^ E_DEPRECATED);
if(empty($_POST)){
  include('./view/admin/catadd.html');
}
else{
    $conn=mysql_connect('localhost','root','');
    mysql_query('use blog',$conn);
    mysql_query('set names utf-8');
    //check the item is Empty

    $cat['catname'] =trim($_POST['catname']);
    if(empty($cat['catname'])){
      error ('empty!');
      exit();
    }
    $sql="select count(*) from cat where catname='$cat[catname]'";
    $rs=mysql_query($sql);
    $cat1=mysql_fetch_row($rs)[0];// get the element in the mysql
    if($cat1!=0){
      error("item exist!");
      exit();
    }
    //add item in the list
    $sql="insert into cat (catname) values ('$cat[catname]')";
    if(!mExec('cat',$cat)){
      header('Location:catlist.php');
    }
    else{
      header('Location:catlist.php');
    }
}
?>
