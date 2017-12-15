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
if(empty($_POST)) {
	require(ROOT . '/view/front/login.html');
} else {
	$user['name'] = trim($_POST['name']);
	if(empty($user['name'])) {
		error('not empty');
	}

	$user['password'] = trim($_POST['password']);
	if(empty($user['password'])) {
		error('password not empty');
	}

	$sql = "select * from user where name='$user[name]' and password='$user[password]'";
	//$sql = "select * from user where name='$user[name]'";
	$row = mGetRow($sql);
	//print_r($row);exit();
	if(!$row) {
    //header('Location: log.php');
		error('wrong id');
	} else {
      setcookie('name' , $user['name']);
      header('Location: artlist.php');
    // if(md5($user['password'].$row['salt']) === $row['password']){
		// 	setcookie('name' , $user['name']);
		// 	setcookie('ccode' , cCode($user['name']));
		// 	header('Location: artlist.php');
		// } else {
		// 	error('password wrong');
		// }
	}
}

?>
