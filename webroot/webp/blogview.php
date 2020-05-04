<?php

// Include config file
session_start();

require_once "config.php";

$blogcreated = "";
$username = "";
$blogentry = "";
$btitle = "";
$blog = "";
$blogcomm = "";
$date_chosen ="";
$counter = 0;

$_SESSION["rowo"] = "";


if(isset($_POST['reorderbtn'])){
    $date_chosen = $_POST['months'];
}

if(isset($_POST['Blog0'])){
    if(( isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] == true)){
    header("index.php");
    } else {
    echo  "<script>
                alert('NOT LOGGED IN! Please Log-in first to be able to add an entry!'); 
                window.location.href='login.html';
           </script>";
    }
}
// ORDER BY `blog`.`created` DESC
$sql = "SELECT blog_details, blog_title, id, username, created FROM `blog` ";

$result = mysqli_query($conn,$sql);

if( mysqli_num_rows($result) == 0 && ( !isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] != true)){
    echo  "<script>
                alert('No Entries Available! Please Log-in to add one!'); 
                window.location.href='login.html';
           </script>";
} else if (mysqli_num_rows($result) == 0){
    echo  "<script>
                alert('No Entries Available! Please add one!'); 
           </script>";
}

$count = 0;

while($data_row = mysqli_fetch_array($result)){
    $rows[$count] = $data_row;
    $count++;
}

for($i = 0; $i < sizeof($rows) - 1; $i++){
    for($k =  1; $k < sizeof($rows) - $i - 1; $k++ ){
        $temp = $rows[$k];
        $rows[$k] = $rows[$k +1];
        $rows[$k +1] = $temp;
    }
}
while( $counter < sizeof($rows) ){
    $row = $rows[$counter];
    $t = strtotime($row[4]);

    if(isset($_POST['reorderbtn']) && isset($date_chosen) && $date_chosen!= "All" ){

            if(date('F', $t) == $date_chosen ){
                
                $blog = $blog . '<br><article class="blog_article">
                            <h4>' . $row[1] .'</h4> 
                            <p class="blog_p">' .  $row[0]   .   '</p>
                            <div class="deets">
                                <div class="indeets">
                                    <p class="usern"> <b>Author:</b> ' .$row[3].'</p>';

                if((isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) && $_SESSION["username"] == "tester1"){
                    $blog = $blog .    '<form method="POST" action="removeentry.php">
                                            <input type="hidden" name="entryID" value="'. $row[2].'">
                                            <button class="removeentry" type="submit"  onClick="javascript:removeentry(this);">Delete Entry</button>
                                        </form>';
                }
                $blog = $blog .    '</div>
                                        <p class="date">' .date('jS F Y', $t). '</p><br><p class="date">' .date('g:i A e', $t) .'</p>
                                    </div>
                                </article>';

                                $_SESSION["rowo"] = $row[2];
                                include "blogComms.php";

                                $blog = $blog . $blogcomm ;
            } if(empty(trim($blog))){
                $blog = $blog .    '<div class="noEntryForMonth">
                                    <p> No entry for this month! :< </p>
                                    </div>';
            }

    } else if(!isset($_POST['reorderbtn']) || $date_chosen == "All"){

        $blog = $blog . '<br><article class="blog_article">
                            <h4>' . $row[1] .'</h4> 
                            <p class="blog_p">' .  $row[0]   .   '</p>
                            <div class="deets">
                                <div class="indeets">
                                    <p class="usern"> <b>Author:</b> ' .$row[3].'</p>';

        if((isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) && $_SESSION["username"] == "tester1"){
            $blog = $blog .    '<form method="POST" action="removeentry.php">
                                    <input type="hidden" name="entryID" value="'. $row[2].'">
                                    <button class="removeentry" type="submit"  onClick="javascript:removeentry(this);">Delete Entry</button>
                                </form>';
        }

        $blog = $blog .    '</div>
                                <p class="date">' .date('jS F Y', $t). '</p><br><p class="date">' .date('g:i A e', $t) .'</p>
                            </div>
                        </article>';

                         $_SESSION["rowo"] = $row[2];
                        include "blogComms.php";

                        $blog = $blog . $blogcomm ;
    }
    $counter++;
};
  
$conn->close();

?> 
<!DOCTYPE html>
<html lang="en" class="blogview">
    <head>
        <meta charset="utf-8">
        <title> BLOG VIEW </title>
        <link rel="stylesheet" href="reset.css" type="text/css" />
        <link rel="stylesheet" href="webstyle.css" type="text/css" />
        <link rel="stylesheet" href="blogviewcss.css" type="text/css" />
    </head>

    <script>          
        function  addentry(target){
            location.href='addentry.html';
        };

        function clicksubmit(txtID){
            if(document.getElementById("txta" + txtID).value.length == 0 ){
                event.preventDefault();
                    document.getElementById('txta' + txtID).style.boxShadow = "0 0 0 4px #91faff";
                    alert("Empty Comment!\r\nPlease ADD a comment or go BACK!");
            }
        };

        function  addcommentbtn(rowID){
            var x = document.getElementById(rowID); 
                x.style.display = "block";
            var y = document.getElementById("btn" + rowID);
                y.style.display = "none";
        };

        function  dontaddcommentbtn(rowID, txtID){
            var x = document.getElementById(rowID);
                x.style.display = "none";
                document.getElementById("txta" +  txtID).style.boxShadow ="none";
                
            var y = document.getElementById("btn" + rowID);
                y.style.display = "block";
        };

        function  removecomm(target){
            var x = confirm("Are you sure you want to delete this comment?");
                if(!x){
                    event.preventDefault();
                }
        };

        function  removeentry(target){
            var x = confirm("Are you sure you want to delete this entry?");
                if(!x){
                    event.preventDefault();
                }
        };
    </script>

    <body>
    
        <header>
            <hgroup>
                <h3> BLOG ENTRIES </h3>
            </hgroup>
        </header>

        <nav class="links">
            <ul class="centerbanner">
                <li><a href="index.php"> HOME </a></li>
            </ul>
        </nav>
        
        
        <div class="blogo"> 
        <!-- <div class="blog">
                <button id="blog" name="Blog" onClick="javascript:addentry(this);"> ADD BLOG ENTRY </button>
            </div> -->

            <div class="blog">
                <form method="POST">
                    <button id="blog0" name="Blog0"> ADD BLOG ENTRY </button>
                </form>
            </div>
                    
            <form method="POST" >
                    <p>You can view blog entries for a specific month!</p>
                    <br>
                    <select name="months">
                        <option value="All">ALL</option>
                        <option value="January">January</option>
                        <option value="February">February</option>
                        <option value="March">March</option>
                        <option value="April">April</option>
                        <option value="May">May</option>
                        <option value="June">June</option>
                        <option value="July">July</option>
                        <option value="August">August</option>
                        <option value="September">September</option>
                        <option value="October">October</option>
                        <option value="November">November</option>
                        <option value="December">December</option>
                    </select> 
                    
                    <button type="submit" name="reorderbtn">Re-order</button>
            </form>
            
                <br><br><span><?php echo $blog; ?></span>
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