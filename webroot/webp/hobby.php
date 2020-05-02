<?php

// Include config file
session_start();

require_once "config.php";

$conn->close();
?> 


<!DOCTYPE html>
<html lang="en" class="hobby">
    <head>
        <meta charset="utf-8">
        <title> HOBBIES! </title>
        <link rel="stylesheet" href="reset.css" type="text/css" />
        <link rel="stylesheet" href="webstyle.css" type="text/css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> 

        <audio  autoplay id="myAudio" hidden>
            <source src="music/D'sperado - Clumsy One (OBSN ver.).mp3" type="audio/mpeg">
        </audio>
        
        
    </head>

    <script>          
         var gif_names =["img/tenor.gif", "img/tenor2.gif", "img/tenor3.gif", "img/tenor4.webp", "img/tenor5.gif"];
        
         var y = gif_names[Math.floor(Math.random() * gif_names.length)];
      
                $(window).load(function () {
                    $("#thegif").attr("src", y );
                });

        var dio = document.getElementById("myAudio");
        dio.volume = 0.1;
    </script>


    <body>
        
        <header>
            <hgroup>
                <h3> Hobbies </h3>
            </hgroup>
        </header>

        <nav class="links">
            <ul class="centerbanner">
                <li><a href="index.php"> HOME </a></li>
            </ul>
        </nav>


        <aside class="mainaside">
                    <img class="gif2" id="thegif"  alt="cute gif">   
                    <figcaption class="blogcap">Here's a random gif that Sammi (my friend) likes! </figcaption>
        </aside>

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