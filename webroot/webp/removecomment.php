<?php

// Include config file
session_start();

require_once "config.php";
 
//gets the value from a hidden input value, that value holds the exact ID of the comment
$commID = $_POST["commentID"];
  
$sql = "DELETE FROM comments WHERE comment__ID=" . $commID ."";

if(mysqli_query($conn, $sql)){
    echo "<script>
            alert('COMMENT DELETED!');
            window.location.href='blogview.php';
          </script>";
} else {
    echo "<script>
            alert('NO COMMENT DELETED! SQL ERROR!');
            window.location.href='blogview.php';
          </script>";
}
?> 