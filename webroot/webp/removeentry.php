<?php

// Include config file
session_start();

require_once "config.php";
 
$entryID = $_POST["entryID"];
$sql = "DELETE FROM blog WHERE ID='" . $entryID ."'";

if(mysqli_query($conn, $sql)){
    $sql="DELETE FROM comments WHERE id='" . $entryID ."'";
    if(mysqli_query($conn, $sql)){
        echo "<script>
                alert('ENTRY & COMMENTS DELETED!');
                window.location.href='blogview.php';
            </script>";
    } else {
        echo "<script>
                alert('NO ENTRY DELETED! SQL ERROR 1!');
              </script>";
    }
} else {
    echo "<script>
            alert('NO ENTRY DELETED! SQL ERROR 2!');
          </script>";
}
?> 