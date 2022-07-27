<?php 

    include '../connect.php';
	include "../includes/functions/functions.php";

    // ajaxfuntions.js data gets from there and from items.php

    if ($_SERVER['REQUEST_METHOD'] == 'POST' || isset($_POST['name'])) {

        // variables
        $name 		= $_POST['name'];
        $desc 		= $_POST['description'];
        $price 		= $_POST['price'];
        $status 	= $_POST['status'];
        $member 	= $_POST['member'];
        $cat 		= $_POST['category'];
        $tags 		= $_POST['tags'];

        // get the last id of item
        $stmt1 = $con->prepare("SELECT * FROM items ORDER BY Item_ID DESC LIMIT 1");
        $stmt1->execute();
        $lastItemid = $stmt1->fetch();
        // the is the new id we made for the new  item
        $main_id = $lastItemid['Item_ID']; // Last id that been created in upload_item_images.php
        
        // Validate The Form
        $formErrors = array();

        if (empty($name)) { $formErrors[] = 'Name Can\'t be <strong>Empty</strong>'; }
        if (empty($desc)) { $formErrors[] = 'Description Can\'t be <strong>Empty</strong>'; }
        if (empty($price)) { $formErrors[] = 'Price Can\'t be <strong>Empty</strong>'; }
        if ($status == 0) { $formErrors[] = 'You Must Choose The <strong>Status</strong>'; }
        if ($member == 0) { $formErrors[] = 'You Must Choose The <strong>Member</strong>'; }
        if ($cat == 0) { $formErrors[] = 'You Must Choose The <strong>Category</strong>'; }

        // Loop Into Errors Array And Echo It
        foreach($formErrors as $error) { echo '<div class="alert alert-danger">' . $error . '</div>'; }

        // Check If There's No Error Proceed The Update Operation
        if (empty($formErrors)) {

            // update item ino To Database

            $stmt = $con->prepare(" UPDATE `items`
                                    SET `Name` = ?, `Description` = ?, Price = ?,
                                    `Status` = ?, `Add_Date` = now(), Cat_ID = ?, Member_ID = ?, tags = ?
                                    WHERE `Item_ID` = ?");

            $stmt->execute([$name, $desc, $price, $status, $cat, $member, $tags, $main_id]);

            // if Success
            if ($stmt->rowCount() == 1) {
                echo 'success';
            } else { // if failed
                echo 'failed';
            }

          }


    } else {echo '<div class="alert alert-danger">Sorry You Can\'t Browse This Page Directly</div>';}

