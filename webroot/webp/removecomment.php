<?php

// Include config file
session_start();

require_once "config.php";
 
$commID = $_POST["commentID"];
$sql = "DELETE FROM comments WHERE comment_ID='" . $commID ."'";

if(mysqli_query($conn, $sql)){
    echo "<script>
            alert('COMMENT DELETED!');
            window.location.href='blogview.php';
          </script>";
} else {
    echo "<script>
            alert('NO COMMENT DELETED! SQL ERROR!');
          </script>";
}
?> 