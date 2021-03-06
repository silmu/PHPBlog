<?php include './connection.php';
    include './sessions.php';
    if(isset($_SESSION['logged_in'])){
        $_SESSION['logged_in'] = false;
    } 

    global $username, $password, $result, $msg, $regmsg;

    include './queries.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['submit'])){
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);

            $result = queryOnUser("SELECT id, password FROM users WHERE username=?", $username);

            //Check is username exists
            if($result){
                //Check if password is correct
                $hash = $result[0]['password'];

                if(password_verify($password, $hash)){
                    $msg = 'Password is correct';
                    session_regenerate_id(true);
                    $_SESSION['logged_in'] = true;
                    //Save user id to session
                    $_SESSION['user_id'] = $result[0]['id'];
                    header("Location: account.php");
                } else {
                    $msg = 'Password is incorrect';
                }
            } else {
                $msg = 'Username doesnt exist';
            }
        }
        //Check if username and password match any in a database
        if(isset($_POST['register'])) {
            $regusername = trim($_POST['reg_username']);
            $regpassword = trim($_POST['reg_password']);

            //Password encryption
            $regpassword = password_hash($regpassword, PASSWORD_BCRYPT);

            $result = queryOnUser("SELECT id, password FROM users WHERE username=?", $regusername);

            //Check is username exists
            if($result){
                $regmsg = 'Username is taken. Please, enter another username.';
            } else {
                //Add a new user and password
                queryCheck("INSERT INTO users(username, password) VALUES('$regusername', '$regpassword')");

                $regmsg = "Registration successful.";
            }
        }
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
                <input type='text' name='username' id='username' placeholder='Username' autocomplete="username" required>
            </div>
            <div class='form-group'>
                <label for='password'></label>
                <input type='password' name='password' id='password' placeholder='Password' autocomplete="current-password" required>
            </div>
            <input type='submit' name="submit" value='Submit' class='btn-primary'/>
            <p><?=$msg?></p>
        </form>
        <!--------- Register ----------->
        <div class="register">
        <p class="divider">or</p>
        <!--------- Show content on click ----->
        <!-- <label for='spoiler' id='spoiler-label'>Register
        </label>
        <input type='checkbox' id='spoiler' class='btn-second'/>-->
        <h2>Register</h2>

            <div class='register-form'>
            <form method="post" action='login.php'>
                <div class='form-group'>
                    <label for='reg_username'></label>
                    <input type='text' name='reg_username' id='reg_username' placeholder='Username' autocomplete="username" required>
                    </div>
                <div class='form-group'>
                    <label for='reg_password'></label>
                    <input type='password' name='reg_password' id='reg_password' placeholder='Password' autocomplete="new-password" required>
                </div>
                <input type='submit' name='register' value='Submit' class='btn-primary' />
                <p class="msg"><?=$regmsg?></p>
            </form>
            </div>
        </div>
        </div>
    </main>
</body>
</html>