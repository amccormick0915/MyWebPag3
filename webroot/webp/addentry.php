<?php

// Include config file
session_start();
require_once "config.php";


$username = "";
$blogentry = $_POST['txtAre']; 
$btitle = $_POST['blogtitle'];
$err_mssg ="";

// Processing form data when form is submitted

if( !empty($blogentry) && !empty($btitle)){
            
    $usern = $_SESSION['username'];
    // Prepare an insert statement
    $sql = "INSERT INTO blog (username, blog_details, blog_title) VALUES ('" . $usern . "','" . $_POST['txtAre'] . "','" . $_POST['blogtitle'] . "')"; 
    
    if(mysqli_query($conn, $sql)){
        echo "<script>
                alert('Blog Entry Added!');
                window.location.href='blogview.php';
              </script>";
    } else {
        echo "<script>
                alert('NO ENTRY ADDED! SQL ERROR!');
              </script>";
    }
}
?> 
