<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = "";
$password = "";
$username_err = "";
$password_err = "";
 
 
$mail = $_POST["email"];
$password = $_POST["password"];

$sql = "SELECT id, username, password FROM USERS WHERE email = '" . $mail . "'";
$result = mysqli_query($conn, $sql);
$num_rows = mysqli_num_rows($result);

if($num_rows == 1){
    $row = mysqli_fetch_array($result);
    $hashed_password = $row['password'];
    // password_verify(
    if(trim($password) == $hashed_password){
        session_start();
        // Store data in session variables
        $_SESSION["loggedin"] = true;
        $_SESSION["id"] = $id;
        $_SESSION["username"] = $row['username'];   
        $_SESSION["signinmssg"] = "";                            
        
        // Redirect user to welcome page
        header("location: addentry.html");
    } else{
        // Display an error message if password is not valid
        $password_err = "The password you entered was not valid.";
    }
} else{
    // Display an error message if username doesn't exist
    $username_err = "No account found with that email.";

}
    echo  "<script>
                alert('"  . $username_err  ."\\n" . $password_err .  "'); 
                window.location.href='login.html';
           </script>";
?>