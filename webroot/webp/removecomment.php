<?php

// Include config file
session_start();

require_once "config.php";
 
$commID = $_POST["commentID"];
echo "<script>
alert('" . $_POST["commentID"] .  "');
window.location.href='blogview.php';
</script>";
$sql = "DELETE FROM comments WHERE comment_ID=" . $commID ."";
echo "<script>
alert('" . $commID .  "');
window.location.href='blogview.php';
</script>";
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