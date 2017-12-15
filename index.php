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
//search the id from address
$sql="select cat_id,catname from  cat";
$cats= mGetAll($sql);

if(isset($_GET['cat_id'])){
    $where= " and art.cat_id=$_GET[cat_id]";
}else {
    $where="";
}
//page

$sql = "select count(*) from art where 1" . $where;//获取总的文章数
$num = mGetOne($sql);//总的文章数
//getPage()
$curr = isset($_GET['page']) ? $_GET['page'] : 1;//当前页码数
$cnt = 4;//每页显示条数
$page = getPage($num , $curr, $cnt);
//search all the article
$sql = "select art_id,title,content,pubtime,comm,catname,thumb from art inner
join cat on art.cat_id=cat.cat_id where 1" . $where . ' order by art_id desc limit ' . ($curr-1)*$cnt . ',' . $cnt;// choice of the article

$arts = mGetAll($sql);


require('./view/front/index.html');





?>
