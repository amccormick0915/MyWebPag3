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

//If user chooses to Re-order posts, the month chosen is aigned to var!
if(isset($_POST['reorderbtn'])){
    $date_chosen = $_POST['months'];
}

//If user wants to add entry, we first check if they are logged in or not!
if(isset($_POST['Blog0'])){
    if(( isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] == true)){
        header("location: addentry.html");
    } else {
    echo  "<script>
                alert('NOT LOGGED IN! Please Log-in first to be able to add an entry!'); 
                window.location.href='login.html';
           </script>";
    }
}

//Query that returns all values (blog posts) from the table of BLOG
$sql = "SELECT blog_details, blog_title, ID, username, created FROM `blog` ";
$result = mysqli_query($conn,$sql);

if( mysqli_num_rows($result) == 0 && ( !isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] != true)){
    echo  "<script>
                alert('No Entries Available! Please Log-in to add one!'); 
                window.location.href='login.html';
           </script>";
} else if (mysqli_num_rows($result) == 0){
    echo  "<script>
                alert('No Entries Available! Please add one!'); 
                window.location.href='addentry.html';
           </script>";
}


//Initialise the vars to be used in the following codes!
$count = 0; //used for counter for while loop
$show = false;  //used for showing a horizontal line!


//placing all ROWS from the table, inside an array!
while($data_row = mysqli_fetch_array($result)){
    $rows[$count] = $data_row;
    $count++;
}


//For loop that sorts the dates using the IDs!
for($i = 0; $i < sizeof($rows) - 1; $i++){
    for($k =  0; $k < sizeof($rows) - $i -1; $k++){
        if($rows[$k]['ID'] < $rows[$k + 1]['ID']){
            $temp = $rows[$k];
            $rows[$k] = $rows[$k +1];
            $rows[$k +1] = $temp;
        }
    }
}


//adds the horizontal line
function addHR($counter, $rows, $show, $blog){ 
    if( $counter != 0 && $show ){ 
            $blog = $blog . '<hr style="height:9pt; border-width:0; margin: 1em 0.5em 0; border-radius: 1em; background-color:rgba(245, 123, 107, 0.459)">'; 
        }
    return $blog;
}


//Loop that writes HTML code including table variables from sql!
while( $counter < sizeof($rows) ){
    $row = $rows[$counter];
    $t = strtotime($row[4]);

    //If there is RE-ORDERING of posts!
    if(isset($_POST['reorderbtn']) && (isset($date_chosen) && $date_chosen != "All" )){

            //if the month is the same month as the user chose
            if(date('F', $t) == $date_chosen ){

                $blog = addHR($counter, $rows, $show, $blog);
                $show = true; //placing this here makes sure that only after the first blog post is made, will there be a line

                $blog = $blog . '<br><article class="blog_article">
                            <h4>' . $row[1] .'</h4> 
                            <p class="blog_p">' .  $row[0]   .   '</p>
                            <div class="deets">
                                <div class="indeets">
                                    <p class="usern"> <b>Author:</b> ' .$row[3].'</p>';


                //If the user is admin, the delete entry button is added
                //Input value that is hidden holds the post's ID, used for DELETING THE ENTRY!
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

                    // assigning the "row no" the ID of the blog entry!
                    $_SESSION["rowo"] = $row[2];
                    include "blogComms.php";

                    $blog = $blog . $blogcomm ;

            } else {
                $show = false;
            }

            //This shows a message if there are no entries for the mont
            if( $counter == (sizeof($rows)-1) && empty(trim($blog))){
                $show = false;
                $blog = $blog .    '<div class="noEntryForMonth">
                                    <p> No entry for this month! :< </p>
                                    </div>';
            }
            
            
    // this else block id is for showing all the posts 
    } else if(!isset($_POST['reorderbtn']) || $date_chosen == "All"){
        $blog = addHR($counter, $rows, $show, $blog);
        $show = true;

        $blog = $blog . '<br><article class="blog_article">
                            <h4>' . $row[1] .'</h4> 
                            <p class="blog_p">' .  $row[0]   .   '</p>
                            <div class="deets">
                                <div class="indeets">
                                <p class="usern"> <b>Author:</b> ' .$row[3].'</p>';

        //If the user logged in is the ADMIN and not a guest user!
        if((isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) && $_SESSION["username"] == "tester1"){
            $blog = $blog .    '<form method="POST" action="removeentry.php">
                                    <input type="hidden" name="entryID" value="'. $row[2].'">
                                    <button class="removeentry" type="submit"  onClick="javascript:removeentry(this);">Delete Entry</button>
                                </form>';
        }

        $blog = $blog .    '    </div>
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

        //The reson we used the ID as id values for the comment box!
        function clicksubmit(txtID){
            if(document.getElementById("txta" + txtID).value.length == 0 ){
                event.preventDefault();
                    document.getElementById('txta' + txtID).style.boxShadow = "0 0 0 4px #91faff";
                    alert("Empty Comment!\r\nPlease ADD a comment or go BACK!");
            }
        };

        //The id enables to SHOW the correct comment box rather than showing ALL COMMENT BOXES
        function  addcommentbtn(rowID){
            var x = document.getElementById(rowID); 
                x.style.display = "block";
            var y = document.getElementById("btn" + rowID);
                y.style.display = "none";
        };

        //fucntion for the BACK bttn
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
                    <li><a href="https://en-gb.facebook.com/annelyn.mccormick.9"> My Facebook Account </a></li>
                    <li><a> +44 7785549784 </a></li>
                    <li><a> mail: annelynmccormick@yahoo.com </a></li>
                </ul>  
            </nav>
            <li><i> Background images © Re°</i></li>
        </footer>

    </body>
</html>