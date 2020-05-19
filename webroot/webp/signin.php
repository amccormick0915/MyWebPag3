<?php
session_start();
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = "";
$password = "";
$email = "";
$username_err = "";
$pass_err = ""; 
$email_err = ""; 


if(isset($_POST['submit'])){  
 
    // Checks whether username is empty or not
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username!";
    } else{
        $user = $_POST['username'];
        $sql = "SELECT id FROM USERS WHERE username = '" . $user . "'";
        $result =  mysqli_query($conn,$sql);
        $norows = mysqli_num_rows($result);

        if($norows >0){
            $username_err = "Username already taken!";
        } else {
            $username = $user;
        }
    }

    if(empty(trim($_POST["email"]))){
        $username_err = "Please enter E-mail!";
    } else{
        // Prepare sql statement
        $mail = $_POST['email'];
        $sql = "SELECT id FROM USERS WHERE email = '" . $mail . "'";
        $result =  mysqli_query($conn,$sql);
        $norows = mysqli_num_rows($result);

        if($norows >0){
            $email_err = "E-mail already in database!";
        } else {
            $email = $mail;
        }
    }


    if((strlen($_POST["password"]))<4){
        $pass_err = $pass_err . "Password length too short! Needs to be at least 4 characters!";
    }

    // Checks if password is empty or not
    if(empty(trim($_POST["password"]))){
        $pass_err = "Please enter password";     
    } else{
        $password = $_POST["password"];
    }
    

    //If there are no errors, data is stored and redirect back to index, ELSE, stays on same page and erros are shown
    if(empty($username_err) && (empty($pass_err) && empty($email_err))){
        $new_pass = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO USERS (id,username, email, password)  VALUES ( DEFAULT,'" . $username . "','" . $email . "','" . $new_pass  . "')";

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
                                <label>E-mail</label>
                                <input type="text" name="email"><br>
                            <span ><?php echo $email_err; ?></span>
                        </div> 

                        <div>
                                <label>Username</label>
                                <input type="text" name="username"><br>
                            <span ><?php echo $username_err; ?></span>
                        </div> 

                        <div>
                                <label>Password</label>
                                <input type="password" name="password"><br>
                            <span ><?php echo $pass_err; ?></span>
                        </div>

                        <p>Already have an account? <a href="login.html">Login here</a></p>

                        <div class="signin">
                            <button id="sg" name="submit" type="submit" value="Submit">SIGN UP</button>
                        </div>
                
                    </form>
                </div>
            </aside>
        </div>

        <footer>  
            <nav class="links"> 
                <ul>
                    <li><a href="https://en-gb.facebook.com/annelyn.mccormick.9"> My Facebook Account </a></li>
                    <li><a> +44 7785549784 </a></li>
                    <li><a> mail: annelynmccormick@yahoo.com </a></li>
                </ul>  
            </nav>
            <li><i> Background images © Re°</i></li>
        </footer>

    </body>
</html>