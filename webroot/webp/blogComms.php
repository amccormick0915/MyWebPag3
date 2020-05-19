<?php
$blogcomm = "";
//row no 2 is the ID
$CommentBoxID = $row[2];

$sqlcomm = "SELECT comment, comment__ID, id, username, created FROM comments ORDER BY comments.created ASC";
$resultcomms = mysqli_query($conn,$sqlcomm);

$blogcomm = '<div class="commentsection"><h1>Comment Section</h1>';


//If user is logged in, The ADD Comment button appears, else a message appears
if( isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true){
    $blogcomm = $blogcomm  .'<div class="positionright">
                            <div class="addcommbtnrel" id="btnrowID'. $CommentBoxID.'">
                                <button class="addcommbtn"  type="button" name="commentbtn" onClick="javascript:addcommentbtn(this.value);" value="rowID'. $row[2].'">Add Comment</button>
                            </div></div>';   
} else {
    $blogcomm = $blogcomm  .'<div class="positionright">
                                <div class="addcommbtnrel">
                                <p>If you want to leave a comment on this blog post, please log-in!</p>
                            </div></div>';
}


// The ROW[id] or [2] of the BLOG, is added into the COMMENT ID
// This is used for the javascript, it aids in showing the COMMENT BOX and the "ADD" or "BACK" button later 
// AND ALSO for using preventDefault() for deleting comments and entries!

//The hidden input holds the ID of the blog post, it is passed on via POST when needed to ADD the blog post ID in the table!
$blogcomm = $blogcomm  .'<div id="rowID'. $CommentBoxID .'" style="display:none" >
                            <form id="commentform" class="commentform" method="POST" action="addComm.php">
                                <input type="hidden" name="commentID" value="'. $CommentBoxID .'">
                                <textarea id="txta' . $CommentBoxID .'" name="txtar" rows="3" cols="80" placeholder="Enter comment here!"></textarea>
                                <span class="addback">
                                    <ul>
                                    <li><button class="addcommbtn" type="submit" name="addcommentbtn" value="'.$CommentBoxID.'" onClick="javascript:clicksubmit(this.value);">Add</button></li>
                                    <li><button class="addcommbtn" type="button" onClick="javascript:dontaddcommentbtn(this.value,'. $CommentBoxID .');" value="rowID' .  $CommentBoxID .'">Back</button></li>
                                    </ul>
                                </span>
                            </form>
                        </div>';


//Similar to how the blog is created, the comments are created as well, but this time, 
// already in ascending order of the date created. 
//Almost exact copy of the blog version
while($rowc = mysqli_fetch_array($resultcomms)){
    
    //If the BLOG POST ID is similar to the one stored in the database
    if($_SESSION["rowo"] == $rowc['id']) {
        $t = strtotime($rowc['created']);
        
        $blogcomm = $blogcomm . '<section class="blog_article">
                                    <div class="comm_deet">
                                        <h4>' . $rowc['username'] .':</h4> 
                                        <p class="comm_p">' .  $rowc['comment']   .   '</p>
                                    </div>
                                    <div class="deletecomm">
                                        <form method="POST" action="removecomment.php">
                                            <input type="hidden" name="commentID" value="'.$rowc['comment__ID'].'">';
                                            
                                    //if the user is admin, they can delete posts and comments
                                    if((isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) && $_SESSION["username"] == "tester1"){
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

$blogcomm = $blogcomm . '</div>';

?> 