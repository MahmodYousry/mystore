<?php 

	include '../connect.php';
	include "../includes/functions/functions.php";

        // Delete item image first and item
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // received variables
            $row_id = $_POST['row_id'];

            // Select All Data Depend on This ID
			$check = checkItem('row_id', 'item_imgs', $row_id);

			if($check > 0) { // If There's Such Item ID
                
                // get the url of item images files
                $stmt1 = $con->prepare("SELECT * FROM item_imgs WHERE row_id = ?");
                $stmt1->execute([$row_id]);
                $itemImages = $stmt1->fetchAll();

                foreach ($itemImages as $itemImage) {

                    $avUrl = "../../products/" . $itemImage['img_src'];

                    if (file_exists($avUrl)) { // if file exits

                        // delete the image as file
                        unlink($avUrl);
                        // delete images as data
                        $stmt2 = $con->prepare("DELETE FROM item_imgs WHERE row_id = ?");
                        $stmt2->execute([$row_id]);

                        echo 'success';

                    } else {
                        // delete images as data
                        $stmt22 = $con->prepare("DELETE FROM item_imgs WHERE row_id = ?");
                        $stmt22->execute([$row_id]);

                        echo 'success';
                    }
                   
                }


            } else {
                echo 'failed';
			}

        } else { echo 'Sorry You Can\'t Browse This Page Directly'; }
      		

?>