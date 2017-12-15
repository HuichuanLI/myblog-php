<?php
/***
*index.php front-page
*
*@author huichuan.li
*@link https://github.com/HuichuanLI
*@since 2017.6
*@copyright Gpl
*/
//connect to the sql
error_reporting(E_ALL ^ E_DEPRECATED);

function mConn() {
  static $conn = null;
  if($conn === null) {
    
    $conn = mysql_connect('localhost' , 'root' , "");
    mysql_query('use blog' , $conn);
    mysql_query('set names utf8' , $conn);
  }

  return $conn;
}
//log function
/*
*
*
*
*/
function mLog($str) {
  $filename = ROOT . '/log/' . date('Ymd') . '.txt';
  $log = "-----------------------------------------\n".date('Y/m/d H:i:s') . "\n" . $str . "\n" . "-----------------------------------------\n\n";
  return file_put_contents($filename, $log , FILE_APPEND);
}



//select function
function mQuery($sql){
  $rs=mysql_query($sql,mConn());
  if($rs){
    mLog($sql);
  }else{
    mLog($sql."\n".mysql_error());
  }
  return $rs;
}

//search the item in the table
function mGetAll($sql) {
  $rs = mQuery($sql);
  if(!$rs) {
    return false;
  }

  $data = array();
  while($row = mysql_fetch_assoc($rs)) {
    $data[] = $row;
  }

  return $data;
}
// $sql = "select * from cat";
// print_r(mGetAll($sql));
/*
* select one  row item in the tables;
* @param sql
* @return the array
*/
function mGetRow($sql) {
  $rs = mQuery($sql);
  if(!$rs) {
    return false;
  }

  return mysql_fetch_assoc($rs);
}

// $sql="select * from cat where cat_id=1";
// print_r(mGetAll($sql));
/*
* select one  row item in the tables;
* @param sql
* @return the array
*/
function mGetOne($sql){
  $rs=mQuery($sql);
  if(!$rs){
      return false;
  }
  return mysql_fetch_row($rs)[0];
}
//@ exemple
// $sql="select count(*) from art where cat_id=1";
// echo mGetOne($sql);
/**
 *  use insert and insert
 *  @param str name of the table
 *  @param arr name of the value
 *  @param str $act choice of update or insert
 *  @return bool the result
 */

 function mExec($table , $data , $act='insert' , $where=0) {
 	if($act == 'insert') {
 		$sql = "insert into $table (";
 		$sql .= implode(',' , array_keys($data)) . ") values ('";
 		$sql .= implode("','" , array_values($data)) . "')";
 		return mQuery($sql);
 	} else if ($act == 'update') {
 		$sql = "update $table set ";
 		foreach($data as $k=>$v) {
 			$sql .= $k . "='" . $v . "',";
 		}

 		$sql = rtrim($sql , ',') . " where ".$where;
 		return mQuery($sql);
 	}
 }
 //exemple
// $data= array('title'=>'今天的天气','content'=>'quality of the weather','pubtime'=>'123123','author'=>'dsa');
// echo mExec('art',$data,'update','art_id=1');
function getLastId(){
  return  mysql_insert_id(mConn());
}
