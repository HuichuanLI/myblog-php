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

$conn=mysql_connect('localhost','root','');
mysql_query('use blog',$conn);
mysql_query('set names utf-8');
$sql = "select * from cat";
$rs =mysql_query($sql);
$cat = array();
while($row=mysql_fetch_assoc($rs) ){
  $cat[]=$row;
}
require('./view/admin/catlist.html');
