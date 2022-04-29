<?php include './connection.php';
    include './sessions.php';

    $_SESSION['logged_in'] = false;

    $objectDB = new DBConnect;
    $dbconn = $objectDB ->connect();

    global $username, $password, $result, $msg, $regmsg;

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['submit'])){
            
            $username = $_POST['username'];
            $password = $_POST['password'];

            $checkUser = "SELECT id, password FROM users WHERE username=?";

            $stmt = $dbconn->prepare($checkUser);
            $stmt->execute([$username]);
            $result =  $stmt->fetchAll(PDO::FETCH_ASSOC);

            //Check is username exists
            if($result){
                //Check if password is correct
                //Refactor with hash generated passwords
                //Add sanitization
                if($result[0]['password'] == $password){
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

        //If they match log in, otherwise display "Username not found" or "Incorrect password" message
        if(isset($_POST['register'])) {
            $regusername = $_POST['reg_username'];
            $regpassword = $_POST['reg_password'];

            $checkUser = "SELECT id, password FROM users WHERE username=?";

            $stmt = $dbconn->prepare($checkUser);
            $stmt->execute([$regusername]);
            $result =  $stmt->fetchAll(PDO::FETCH_ASSOC);

            //Check is username exists
            if($result){
                $regmsg = 'Username is taken. Please, enter another username.';
            } else {
                $regQuery = "INSERT INTO users(username, password) VALUES('$regusername', '$regpassword')";

                $stmt = $dbconn->prepare($regQuery);
                $stmt->execute();

                // $_SESSION['logged_in'] = true;
                // $checkUser = "SELECT id FROM users WHERE username='$regusername'";
                // $stmt = $dbconn->prepare($checkUser);
                // $stmt->execute([$username]);
                // $result =  $stmt->fetchAll(PDO::FETCH_ASSOC);
                // $_SESSION['user_id'] = 

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
                <input type='text' name='username' id='username' placeholder='Username' required>
            </div>
            <div class='form-group'>
                <label for='password'></label>
                <input type='password' name='password' id='password' placeholder='Password' required>
            </div>
            <input type='submit' name="submit" value='Submit' class='btn-primary'/>
            <p><?=$msg?></p>
        </form>
        <!--------- Register ----------->
        <div class="register">
        <p>or</p>
        <!--------- Show content on click ----->
        <label for='spoiler' id='spoiler-label'>Register
        </label>
        <input type='checkbox' id='spoiler' class='btn-second'/>

            <div class='register-form'>
            <form method="post" action='login.php'>
                <div class='form-group'>
                    <label for='reg_username'></label>
                    <input type='text' name='reg_username' id='reg_username' placeholder='Username' required>
                    </div>
                <div class='form-group'>
                    <label for='reg_password'></label>
                    <input type='password' name='reg_password' id='reg_password' placeholder='Password' required>
                </div>
                <input type='submit' name='register' value='Submit' class='btn-primary' />
                <p><?=$regmsg?></p>
            </form>
            </div>
        </div>
        </div>
    </main>
</body>
</html>