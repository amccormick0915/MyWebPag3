<?php
// Initialize the session
session_start();


//Session variables!
$_SESSION['logoutmssg'] = "";
$_SESSION['loginbtn'] = "";
$_SESSION['signinbtn'] = "";
$_SESSION['logout'] = "";
$_SESSION['welcomemessge'] = "";   
$_SESSION['blogbtn'] = "";

if(!isset($_SESSION["signinmssg"])){
    $_SESSION["signinmssg"] = "";      
}

// Check if the user is logged in, if not then redirect them to login page

// this statement checks whether $_SESSION[loggedin] exists!
// if it does not YET  exist or if its value is 'false' it displays the login and sign in buttons! 
if( !isset($_SESSION["loggedin"])|| $_SESSION["loggedin"] != true ){  
 
    $_SESSION['loginbtn'] = '  <div class="login">
                                    <button id="log" name="Login"  onClick="javascript:clickinnerlog(this);" > LOGIN </button>
                                </div>
                                
                                <p>login now to post something~!</p>';

    $_SESSION['signinbtn'] = '  <div class="signin">
                                    <button id="sg" name="Signin" onClick="javascript:clickinnersign(this);"> SIGNIN </button>
                                </div>

                                <p>sign-in now!</p>';

// If they are logged in, the welcome mesage appears! and the logout button and Add Post button!
} else {

    $_SESSION['welcomemessge'] = '<h1> Hi, <b>' . htmlspecialchars($_SESSION["username"]) . '</b>. Welcome to my site.</h1>';

    $_SESSION['logout'] = ' <form method="POST">
                                <div class="logout">
                                    <button id="lg" name="logout"> LOGOUT</button>
                                </div>
                            </form>';

    $_SESSION['blogbtn'] = '    <div class="blog">
                                    <button id="blog" name="Blog" onClick="javascript:clickinnerblog(this);"> ADD BLOG POST </button>
                                </div>

                                <p>post something!</p>';
}

//If the user logs out via post method, the logout.php is used on the same page!
if ( isset( $_POST['logout'] ) ) {
    require_once "logout.php";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"name="viewport" content="width=device-width, initial-scale=1">
    <title> HOME PAGE </title>
    <link rel="stylesheet" href="reset.css" type="text/css" />
    <link rel="stylesheet" href="webstyle.css" type="text/css" />
    <link rel="stylesheet" href="index.css" type="text/css" />
</head>
    <body>

        <script>
            function clickinnerlog(target){
                location.href='login.html';
            };
            function clickinnersign(target){
                location.href='signin.php';
            };
            function clickinnerblog(target){
                location.href='addentry.html';
            };
        </script>

        <header>
            <hgroup>
                <h1> Annelyn Mc Cormick </h1>
                <h3> Student </h3>
            </hgroup>

            <div class="message">
                <span class="help-block"><?php echo $_SESSION['welcomemessge']; ?></span>
                <span class="help-block"><?php echo $_SESSION["logoutmssg"]; ?></span>
                <span class="help-block"><?php echo $_SESSION['signinmssg']; ?></span>
            </div>
            
        </header>
        
            <nav class="links">
                <ul class="centerbanner">
                    <li><a href="#about"> About Myself </a></li>
                    <li><a class="cv" href="blogview.php"> View Blog Posts (UwU)/ </a></li>
                    <li><a href="#linku"> Links </a></li>
                </ul>
            </nav>
            <nav class="links">
                <ul class="centerbanner">
                    <li><a href="cv.php"> My CV </a></li>
                    <li><a href="portfolio.html"> Portfolio</a></li>
                </ul>
            </nav>
    <br>
        <div class="center">
            <article>
                <h3><u>ABOUT ME</u></h3>

                <section>
                    <p>
                        The name is Annelyn Mc Cormick. I'm a student at Queen Mary University of London. I am an Irish national 
                        descending from both Irish and Filipino citizens. 
                        <br><br>
                        I mostly grew up in Asia, specifically Philippines. This resulted in my very 
                        asian mindset. the Filipino culture was deeply ingrained in my system, thus, I 
                        consider myself more Filipino rather than Irish.
                        <br><br>
                        An interesting fact however, is that I was born in Spain, raised in Philippines
                        but am now interested in spending most of my life in England.
                        <br><br>
                        I am bilingual in both English and Filipino yet I can also speak and understand Spanish. 
                        And on rare occasions Korean!
                    </p>
                </section>

                    <aside class="picture">
                        <figure>
                            <img class="face" src="img/face.jpg" alt="my face">   
                            <figcaption> <b>A picture of my face</b></figcaption> 
                        </figure>
                    </aside>
                
            </article>

            <aside class="mainaside">
                    <div class="buttons">
                            <span class="help-block"><?php echo $_SESSION['blogbtn']; ?></span>
                            <span class="help-block"><?php echo $_SESSION['loginbtn']; ?></span>
                            <span class="help-block"><?php echo $_SESSION['signinbtn']; ?></span>
                            <span class="help-block"><?php echo $_SESSION['logout'];  ?></span>
                    </div>
            </aside>
            
        </div>

        <footer>  
            <nav class="links" id="linku"> 
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