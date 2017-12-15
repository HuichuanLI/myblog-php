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
if(!acc()){
  //error('please login in');
  header('Location: log.php');
}

$sql = "select art_id,title,pubtime,comm,catname from art left join cat on art.cat_id=cat.cat_id";
$arts = mGetAll($sql);
include(ROOT.'/view/admin/artlist.html');
