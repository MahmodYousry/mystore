<?php 

    include '../connect.php';
	include "../includes/functions/functions.php";

    // ajaxfuntions.js data gets from there and from items.php

    if (isset($_FILES['images'])) {

        $itemid = $_POST['itemid'];

        for ($count = 0; $count < count($_FILES['images']['name']); $count++) {

            if (!empty($_FILES['images']['name'][$count])) {

                $extension = pathinfo($_FILES['images']['name'][$count], PATHINFO_EXTENSION);
                // to make unique name
                $new_name = uniqid() . '.' . $extension;
    
                // Insert Item Imgs To Database and the new item id into item_imgs table
                $stmt3 = $con->prepare("INSERT INTO `item_imgs` (`img_src`, `item_ID`) VALUES ('$new_name', '$itemid') ");
                $stmt3->execute();
    
                // move uploaded functions
                move_uploaded_file($_FILES['images']['tmp_name'][$count], '../../products/' . $new_name);

            }

        }

        echo '<i class="fa fa-info-circle fa-fw"></i> Images Are Uploaded Successfully';

    }
