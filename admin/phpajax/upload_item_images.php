<?php 

    include '../connect.php';
	include "../includes/functions/functions.php";

    // ajaxfuntions.js data gets from there and from items.php

    if (isset($_FILES['images'])) {

        // get the last id of item
        $stmt1 = $con->prepare("SELECT * FROM items ORDER BY Item_ID DESC LIMIT 1");
        $stmt1->execute();
        $lastItemid = $stmt1->fetch();

        if ($stmt1->rowCount() > 0) { // if last item id = 49 then new id = 50
            $main_id = $lastItemid['Item_ID'] + 1; // if last item id = 49 then new id = 50
        } else {
            $main_id = 1; // if there is no id in items make it the first one
        }
        // the is the new id we made for the new  item
        

        // make item id first with any data in items table to make itemid exist first
        $stmt2 = $con->prepare("INSERT INTO `items` (`Item_ID`, `Name`, `Description`, `Price`, `Add_Date`, `Country_Made`, `Image`, `Status`, `Rating`, `Approve`, `Cat_ID`, `Member_ID`, `tags`)
                                    VALUES ('$main_id', 'new', '1', '1', '01-01-2020', '', NULL, NULL, NULL, '0', '11', '7', 'door')");
        $stmt2->execute();      

        for ($count = 0; $count < count($_FILES['images']['name']); $count++) {

            $extension = pathinfo($_FILES['images']['name'][$count], PATHINFO_EXTENSION);
            // to make unique name
            $new_name = uniqid() . '.' . $extension;

            // Insert Item Imgs To Database and the new item id into item_imgs table
            $stmt3 = $con->prepare("INSERT INTO `item_imgs` (`img_src`, `item_ID`) VALUES ('$new_name', '$main_id') ");
            $stmt3->execute();

            // move uploaded functions
            move_uploaded_file($_FILES['images']['tmp_name'][$count], '../../products/' . $new_name);

        }

        echo 'success';

    }
