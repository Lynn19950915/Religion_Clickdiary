<?php 
    ini_set("display_errors", 1);
    error_reporting(~0);

    $db_host    ="***";
    $db_username="***";
    $db_password="***";
    $db_name    ="***";


    try{
	   $db=new PDO("mysql:host={$db_host}; dbname={$db_name}; charset=utf8", $db_username, $db_password,
                    array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8"));
	   $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	   date_default_timezone_set("Asia/Taipei");

    }catch(PDOException $e){
	   print"資料庫連結失敗，{$e->getMessage()}<br/>";
	   die();
    }
?>
