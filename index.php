<?php include './sessions.php';
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
    
        <h1><?= $greeting?></h1>
    
</body>
</html>
