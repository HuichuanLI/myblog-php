<?php
/***
*index.php front-page
*
*@author huichuan.li
*@link https://github.com/HuichuanLI
*@since 2017.6
*@copyright Gpl
*/
$cat_id = $_GET['cat_id']; // get the id from the html

error_reporting(E_ALL ^ E_DEPRECATED);
//connect to the mysql;
$conn=mysql_connect('localhost','root','');
mysql_query('use blog',$conn);
mysql_query('set names utf-8');
//test the id is a number
if(!is_numeric($cat_id)){
    echo"error! the id is invalid!";
    exit();
}
// test the id in the mysql
$sql="select count(*) from cat where cat_id=$cat_id";
$rs= mysql_query($sql);
if(mysql_fetch_row($rs)[0]==0){
  echo"error! the item is invalid";
  exit();
}
// test if there is article under the cat
$sql="select count(*) from art where cat_id=$cat_id";
$rs= mysql_query($sql);
if(mysql_fetch_row($rs)[0]!=0){
  echo"error! there is article ";
  exit();
}
// delete the cat
$sql="delete from cat where cat_id=$cat_id";
if(!mysql_query($sql)){
    echo "failure";
}else{
  header('Location:catlist.php');
}
