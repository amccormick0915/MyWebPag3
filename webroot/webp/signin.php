<?php
session_start();
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = "";
$password = "";
$username_err = "";
$pass_err = ""; 


if(isset($_POST['submit'])){  
 
    // Checks whether username is empty or not
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username!";
    } else{
        // Prepare a select statement
        $user = $_POST['username'];
        $sql = "SELECT id FROM USERS WHERE username = '" . $user . "'";
        $result =  mysqli_query($conn,$sql);
        $num_rows = mysqli_num_rows($result);

        if($num_rows >0){
            $username_err = "Username already taken!";
        } else {
            $username = $user;
        }
    }

    // Checks if password is empty or not
    if(empty(trim($_POST["password"]))){
        $pass_err = "Please enter password";     
    } else{
        $password = $_POST["password"];
    }
    
    if(empty($username_err) && empty($pass_err)){
        $new_pass = password_hash($password, PASSWORD_DEFAULT);
        echo $username . $new_pass;
        $sql = "INSERT INTO users (id,username, password) VALUES ( DEFAULT,'" . $username . "','" . $new_pass  . "')";

        if(mysqli_query($conn, $sql)){
            $_SESSION["signinmssg"]  = '<h1> Sign-in Successful! you can now Log-in to POST a blog!</h1>';
            header("location: index.php");
        } else{
            echo "ERROR: Could not able to store data!";
        }

    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"name="viewport" content="width=device-width, initial-scale=1">
    <title> SIGN IN </title>
    <link rel="stylesheet" href="reset.css" type="text/css" />
    <link rel="stylesheet" href="webstyle.css" type="text/css" />


</head>
    <body>
        <div class="bgimg"></div>

        <header>
            <hgroup>
                <h3> SIGN-IN PAGE </h3>
            </hgroup>
        </header>
    
        <nav class="links">
            <ul class="centerbanner">
                <li><a href="index.php"> HOME </a></li>
            </ul>
        </nav>

    <br>

        <div class="centerlogin">
            <aside class="mainaside">
                <div class="buttons">

                    <form  method="POST" > 

                        <div>
                                <label>Username</label>
                                <input type="text" name="username" value="<?php echo $username; ?>">
                            <span ><?php echo $username_err; ?></span>
                        </div> 

                        <div>
                                <label>Password</label>
                                <input type="password" name="password" value="<?php echo $password; ?>">
                            <span ><?php echo $pass_err; ?></span>
                        </div>

                        <p>Already have an account? <a href="login.html">Login here</a></p>

                        <div class="signin">
                            <button id="sg" name="submit" type="submit" value="Submit">SIGN IN</button>
                        </div>
                
                    </form>
                </div>
            </aside>
        </div>

        <footer>  
            <nav class="links"> 
                <ul>
                    <li><a href="https://en-gb.facebook.com/annelyn.mccormick.9"> AbandonedAccount </a></li>
                    <li><a href="https://en-gb.facebook.com/annelyn.mccormick.9"> AbandonedAccount2 </a></li>
                    <li><a href="https://en-gb.facebook.com/annelyn.mccormick.9"> Abandoned3 </a></li>
                </ul>  
            </nav>
            <i> Copyright © 2020 Annelyn Mc Cormick</i>
            <li><i> Background images © Re°</i></li>
        </footer>

    </body>
</html>