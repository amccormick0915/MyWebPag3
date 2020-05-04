<?php
$blogcomm = "";

$sqlcomm = "SELECT comment, comment__ID, id, username, created FROM comments ORDER BY comments.created ASC";

$resultcomms = mysqli_query($conn,$sqlcomm);

$blogcomm = '<div class="commentsection"><h1>Comment Section</h1>';

if( isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true){
    $blogcomm = $blogcomm   .'<div class="positionright">
                            <div class="addcommbtnrel" id="btnrowID'. $row[2].'">
                                <button class="addcommbtn"  type="button" name="commentbtn" onClick="javascript:addcommentbtn(this.value);" value="rowID'. $row['id'].'">Add Comment</button>
                            </div></div>';   
} else {
    $blogcomm = $blogcomm   .'<div class="positionright">
                                <div class="addcommbtnrel">
                                <p>If you want to leave a comment on this blog post, please log-in!</p>
                            </div></div>';
}

$blogcomm = $blogcomm   .'<div id="rowID'. $row[2].'" style="display:none" >
                            <form id="commentform" class="commentform" method="POST" action="addComm.php">
                                <input type="hidden" name="commentID" value="'. $row[2].'">
                                <textarea id="txta' . $row[2] .'" name="txtar" rows="3" cols="80" placeholder="Enter comment here!"></textarea>
                                <span class="addback">
                                    <ul>
                                    <li><button class="addcommbtn" type="submit" name="addcommentbtn" value="'.$row[2].'" onClick="javascript:clicksubmit(this.value);">Add</button></li>
                                    <li><button class="addcommbtn" type="button" onClick="javascript:dontaddcommentbtn(this.value,'. $row[2] .');" value="rowID' .  $row[2] .'">Back</button></li>
                                    </ul>
                                </span>
                            </form>
                        </div>';

while($rowc = mysqli_fetch_array($resultcomms)){
    
    if($_SESSION["rowo"] == $rowc['id']) {
        $t = strtotime($rowc['created']);
        
        $blogcomm = $blogcomm . '<section class="blog_article">
                                    <div class="comm_deet">
                                        <h4>' . $rowc['username'] .':</h4> 
                                        <p class="comm_p">' .  $rowc['comment']   .   '</p>
                                    </div>
                                    <div class="deletecomm">
                                        <form method="POST" action="removecomment.php">
                                            <input type="hidden" name="commentID" value="'.$rowc['comment_ID'].'">';
                                  
                                    if((isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) && $_SESSION["username"] == "maki"){
                                        $blogcomm = $blogcomm .    '<button class="addcommbtn" type="submit"   onClick="javascript:removecomm(this);">Delete Comment</button>';
                                    }

        $blogcomm = $blogcomm .         '</form>
                                            </div>
                                            <div class="comm_deets">
                                                <p class="date">' .date('j/m/y', $t). '</p>
                                            </div>
                                        </section>';
    }
}

$blogcomm = $blogcomm . "</div>";
?> 