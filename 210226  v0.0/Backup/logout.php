<?php
header("Content-Type:text/html; charset=utf-8");

session_start();
session_destroy();
header("Location:http://cdiary3.tw");

?>