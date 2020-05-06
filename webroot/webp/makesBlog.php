<? php
while( $counter < sizeof($rows) ){
    $row = $rows[$counter];
    $t = strtotime($row[4]);

    //If there is RE-ORDERING of posts!
    if(isset($_POST['reorderbtn']) && isset($date_chosen) && $date_chosen!= "All" ){

            if(date('F', $t) == $date_chosen ){
                $show = true;

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
        $show = true;
        $blog = addHR($counter, $rows, $show, $blog);
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
  
?>

