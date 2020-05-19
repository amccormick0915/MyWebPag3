<?php

//didnt use session destroy, because, still on the same page, because logout is a POST
    $_SESSION['logoutmssg'] = "<h1> Successful! you are now logged out!</h1>";
    $_SESSION['loginbtn'] = '  <div class="login">
                                    <button id="log" name="Login"  onClick="javascript:clickinnerlog(this);" > LOGIN</button>
                              </div>
                                <p>login now to post something~!</p>';
    $_SESSION['signinbtn'] = '  <div class="signin">
                                    <button id="sg" name="Signin" onClick="javascript:clickinnersign(this);"> SIGNIN</button>
                                </div>
                                 <p>sign-in now!</p>';
    $_SESSION['logout'] = "";
    $_SESSION['welcomemessge'] = "";
    $_SESSION['blogbtn'] = "";
    $_SESSION["loggedin"] = false;   
    $_SESSION["signinmssg"] = "";      

?>