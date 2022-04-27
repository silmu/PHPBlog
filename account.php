<?php include './connection.php';
    include './sessions.php';
    $objectDB = new DBConnect;

    $dbconn = $objectDB->connect();

    $selectQuery = "SELECT * FROM posts";
    $stmt = $dbconn->prepare($selectQuery);
    $selectResult = $stmt->execute();

    if(!$selectResult) {
        die('Query selection failed');
    }

    //Display html if user is logged in
    if($_SESSION['logged_in']){
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
            <a href='account.php'>My Blog</a>
            <a href='login.php'>Log out</a>
        </nav>
    </header>
    <main>
        <h1 id='welcome'>Welcome back!</h1>
        <!-- Add new post spoiler -->
            <label for='add-spoiler' id='add-spoiler-label'>+ Add new post</label>
            <input type='checkbox' id='add-spoiler'/>
        <!-- Add new post -->
        <div id='newpost' class='post'>
            <label for='title'></label>
            <input id='title' type='text' placeholder='Title'></input>
            <textarea class='post-content'></textarea>
            <div>
                <input type='submit' value='Add' name='addpost' class='btn-primary'>
                <input type='submit' value='Cancel' class='btn-second'>
            </div>
        </div>
        <h2>History</h2>
        
        <?php
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $title = $row["title"];
            $timestamp = $row["created_at"];
            $content = $row["content"];
        
        ?>
        <div class='post'>
            <h3><?=$title?></h3>
            <h4><?=$timestamp?></h4>
            <textarea class='post-content'><?=$content?></textarea>
            <div>
                <input type='submit' value='Update' name='update' class='btn-primary'>
                <input type='submit' value='Cancel' class='btn-second'>
            </div>
        </div>
        
        <?php }; ?>
        
    </main>
</body>
</html>

<?php } else { 
    header("Location: login.php");
}
?>