<?php session_start();
//Start session
$visited = $_SESSION['visited'] ?? null;
$greeting = $visited ? 'Hello again, friend' : 'Hello, friend';
$_SESSION['visited'] = true;

//Check if looged in
$logged_in ='Log in';
if(isset( $_SESSION['logged_in'])){
$logged_in = $_SESSION['logged_in'] ? 'Log out' : 'Log in';
}
 
?>
