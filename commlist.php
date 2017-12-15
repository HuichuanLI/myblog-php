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
$sql = "select * from comment";
$comms = mGetAll($sql);

//print_r($comms);

require(ROOT . '/view/admin/commlist.html');
