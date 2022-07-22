 <?php

    include 'connect.php';

    //Routes

    $tpl    = "includes/templates/";    // Template Directory
    $lang   = "includes/languages/";    // Language Directory
    $func   = 'includes/functions/';    //function directory
    $css    = "layout/css/";            // Css Directory
    $js     = "layout/js/";             // Js Directory
    
    //  Include Important Files

    include $func . 'functions.php';
    include $lang . 'english.php';
    include $tpl . 'header.php';

    // Include Navbar On All Pages Except The One With $noNavbar Variable

    if (!isset($noNavbar)) { include $tpl . 'Navbar.php'; }

    