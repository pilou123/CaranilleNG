<?php
error_reporting(E_ALL); 
$timestart = microtime(true);
session_start();

require_once $_SESSION['File_Root']. '/Kernel/Include.php';
require_once $_SESSION['File_Root']. '/HTML/Header.php';

SQL_News_List();

require_once $_SESSION['File_Root'] .'/HTML/Footer.php';
?>