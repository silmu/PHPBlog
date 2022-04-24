<?php 
//Start session
session_start();
$visited = $_SESSION['visited'] ?? null;
$greeting = $visited ? 'Hello again, friend' : 'Hello, friend';
$_SESSION['visited'] = true;

//Check if looged in
$logged_in = $_SESSION['logged_in'] ?? 'Log in';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>PHP Blog</title>
</head>
<body>
    <header>
        <nav>
            <a href='index.php'>My Blog</a>
            <a href='login.php'><?=$logged_in?></a>
        </nav>
    </header>
    <main>
        <h1><?= $greeting?></h1>
    </main>
</body>
</html>
