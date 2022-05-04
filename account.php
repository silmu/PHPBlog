<?php include './connection.php';
    include './sessions.php';
    include './queries.php';

    //Display all posts that match the user id
    $userid = $_SESSION['user_id'];
    $selectQuery = "SELECT * FROM posts where user_id='$userid' ORDER BY created_at desc";
    $stmtFetchAll = queryCheck($selectQuery);

    //Send user to login page if not logged in
    if(!$_SESSION['logged_in']){
        header("Location: login.php");
    }

    //Sanitization
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    //Add new post on click
    if(isset($_POST['addpost'])){
        $title = test_input($_POST['title']);
        $content = test_input($_POST['content']);
        $addPostQuery = "INSERT INTO posts (user_id, title, content) VALUES('$userid', '$title', '$content')";

        queryCheck($addPostQuery);

        //Reload page
        header("Location: account.php");

    }
    if (isset($_POST['deletepost'])){
        $content = test_input($_POST['content']);
        queryCheck("DELETE FROM posts WHERE user_id='{$_SESSION['user_id']}' and content='{$content}'");

        //Reload page
        header("Location: account.php");
    }
    if (isset($_POST['updatepost'])){
        queryCheck("UPDATE posts SET content='{$_POST['content']}' WHERE id='{$_POST['id']}'");

        //Reload page
        header("Location: account.php");
    }
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
        <form id='newpost' method='post' class='post'>
            <label for='title'></label>
            <input id='title' type='text' name='title' placeholder='Title'></input>
            <textarea class='post-content'name='content'></textarea>
            <div>
                <input type='submit' value='Add' name='addpost' class='btn-primary'>
                <!-- <input type='button' value='Cancel' class='btn-second' id='canceladd'> 
                <label for="file-upload" >
                </label>
                <input type="file"/> -->
                
            </div>
        </form>
        
        <?php
        while($row = $stmtFetchAll->fetch(PDO::FETCH_ASSOC)){
            $id=$row["id"];
            $title = $row["title"];
            $timestamp = $row["created_at"];
            $content = $row["content"];
        
        ?>
        <form method='post' class='post'>
            <input type='hidden' name='id' value=<?=$id?>>
            <h3><?=$title?></h3>
            <h4 name="timestamp"><?=$timestamp?></h4>
            <textarea class='post-content' name='content'><?=$content?></textarea>
            <div>
                <input type='submit' value='Update' name='updatepost' class='btn-primary'>
                <input type='submit' value='Delete' name='deletepost' class='btn-second'>
                <!--  <input type='submit' value='Cancel' class='btn-second'>
                <label for="file-upload">
                </label>
                <input type="file"/> -->
                
            </div>
        </form>
        
        <?php }; ?>
        
    </main>
</body>
</html>