<?php 
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
session_start();

include ("encrypt.php");

// $rollno     = encrypt_decrypt('decrypt', $_SESSION['rollno']);
// $name1     = encrypt_decrypt('decrypt', $_SESSION['name1']);
$access     = encrypt_decrypt('decrypt', $_SESSION['access']);


// if(!isset($rollno))
// {
// 	header("location: index.php");
//         exit;
// }

?>
