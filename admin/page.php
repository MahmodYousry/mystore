<?php

    /*
        Categories => [ Manage | Edite | Update | Add | Delete | Stats ]

        Condition ? True : False

    */

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    //If This Page Is Main Page

 	if ($do == 'Manage') {

        echo 'welcome you are in manage category page';
        echo '<a href="page.php?do=Add">Add New Category +</a>';

    } elseif ($do == 'Add') {

        echo 'welcome you are in Add category page';

    } elseif ($do == 'Insert') {

        echo 'welcome you are in Insert category page';

    } else {

        echo 'Error There\'s No page with this name';
        
    }

