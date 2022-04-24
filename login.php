<?php include './connection.php';

    $objectDB = new DBConnect;
    $dbconn = $objectDB ->connect();

    global $username, $password, $result, $msg;

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['submit'])){
            
            $username = $_POST['username'];
            $password = $_POST['password'];

            $checkUser = "SELECT password FROM users WHERE username=?";

            $stmt = $dbconn->prepare($checkUser);
            $stmt->execute([$username]);
            $result =  $stmt->fetchAll(PDO::FETCH_ASSOC);

            //Check is username exists
            if($result){
                //Check if password is correct
                if($result[0]['password'] == $password){
                    $msg = 'Password is correct';
                    header("Location: account.php");
                } else {
                    $msg = 'Password is incorrect';
                }
            } else {
                $msg = 'Username doesnt exist';
            }
        } else if(isset($_POST['register'])) {
            header("Location: register.php");
        }

        //Check if username and password match any in a database

        //If they match log in, otherwise display "Username not found" or "Incorrect password" message
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>Log in</title>
</head>
<body>
    <header>
        <nav>
            <a href='index.php'>My Blog</a>
            <a href='login.php'>Log in</a>
        </nav>
    </header>
    <main>
        <!--------- Log in ----------->
        <div class="form-container">
        <form method='POST' action='login.php'>
        <h1>Log in</h1>
            <div class='form-group'>
                <label for='username'></label>
                <input type='text' name='username' id='username' placeholder='Username' required>
            </div>
            <div class='form-group'>
                <label for='password'></label>
                <input type='password' name='password' id='password' placeholder='Password' required>
            </div>
            <input type='submit' name="submit" value='Submit' />
            <p><?=$msg?></p>
        </form>
        <!--------- Register ----------->
        <div class="register">
        <p>or</p>
        <!--------- Show content on click ----->
        <label for='spoiler' id='spoiler-label'>Register
        </label>
        <input type='checkbox' id='spoiler'/>

            <div class='register-form'>
            <form>
                <div class='form-group'>
                    <label for='reg_username'></label>
                    <input type='text' name='username' id='reg_username' placeholder='Username' required>
                    </div>
                <div class='form-group'>
                    <label for='reg_password'></label>
                    <input type='password' name='password' id='reg_password' placeholder='Password' required>
                </div>
                <input type='submit' name='register' value='Submit' />
            </form>
            </div>
        </div>
        </div>
    </main>
</body>
</html>