<?php 

	include '../connect.php';
	include "../includes/functions/functions.php";

        // Delete item image first and item
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // received variables
            $itemid = $_POST['item_id'];

            // Select All Data Depend on This ID
			$check = checkItem('Item_ID', 'items', $itemid);

			if($check > 0) { // If There's Such Item ID
                
                // get the url of item images files
                $stmt1 = $con->prepare("SELECT * FROM item_imgs WHERE item_ID = ?");
                $stmt1->execute([$itemid]);
                $itemImages = $stmt1->fetchAll();

                if ($stmt1->rowCount() > 0) { // there is images in database

                    foreach ($itemImages as $itemImage) {

                        $avUrl = "../../products/" . $itemImage['img_src'];
    
                        if (file_exists($avUrl)) { // if file exits
    
                            // delete the image as file
                            unlink($avUrl);
    
                            // delete images as data
                            $stmt2 = $con->prepare("DELETE FROM item_imgs WHERE item_ID = ?");
                            $stmt2->execute([$itemid]);
    
                            // delete item from items
                            $stmt3 = $con->prepare("DELETE FROM items WHERE item_ID = ?");
                            $stmt3->execute([$itemid]);
    
                        } else {
    
                            // delete images as data
                            $stmt22 = $con->prepare("DELETE FROM item_imgs WHERE item_ID = ?");
                            $stmt22->execute([$itemid]);
    
                            // delete item from items
                            $stmt33 = $con->prepare("DELETE FROM items WHERE item_ID = ?");
                            $stmt33->execute([$itemid]);
    
                        }
                       
                    }

                } else { // if there is no images in database delete the item
                    // delete images as data
                    $stmt44 = $con->prepare("DELETE FROM item_imgs WHERE item_ID = ?");
                    $stmt44->execute([$itemid]);

                    // delete item from items
                    $stmt66 = $con->prepare("DELETE FROM items WHERE item_ID = ?");
                    $stmt66->execute([$itemid]);
                }


            } else {
				echo 'This item ID Is Not Exist';
			}

        } else { echo 'Sorry You Can\'t Browse This Page Directly'; }
      		

?>