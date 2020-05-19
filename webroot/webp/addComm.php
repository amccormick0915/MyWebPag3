<?php

// start session and include config file
session_start();

require_once "config.php";


//pass form variables
$comment = $_POST['txtar'];
$commID = $_POST['commentID'];
 
//prepare sql statement 
$sql = "INSERT INTO comments (id,comment, username) VALUES ( '" . $commID . "' , '" . addslashes($comment) .  "' , '" . addslashes($_SESSION['username']) . "' )";

if(mysqli_query($conn, $sql)){
    echo "<script>
            alert('Comment Added!');
            window.location.href='blogview.php';
          </script>";
} else {
    echo "<script>
            alert('NO COMMENT ADDED! SQL ERROR!');
          </script>";
}


?> 