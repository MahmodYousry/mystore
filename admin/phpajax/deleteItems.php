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

                // Image check
                $checkImage = avatarCheck('Image', 'items', 'Item_ID = ', $itemid);

                if ($checkImage > 0) { // if There is Image For this Item

					$stmt1 = $con->prepare("SELECT Image FROM items WHERE Item_ID = ?");
					$stmt1->execute([$itemid]);
					$itemImage = $stmt1->fetch();

					$avUrl = "../../products/" . $itemImage['Image'];

                    if (file_exists($avUrl)) { // if file exits
                        echo 'there is Image found For This item ';
                        // Delete Image File From the Server using the url given
                        // if done delete it from database
                        if (unlink($avUrl)) {
                            $stmt2 = $con->prepare("DELETE FROM items WHERE Item_ID = ?");
                            $stmt2->execute([$itemid]);
                            // show succes message for Avatar Deleted
                            echo 'There is ' . $stmt2->rowCount() . ' Image Deleted';
                        } else {
                            echo 'Failed To Delete The Avatar or The Url Not Good';
                        }
                        
                    } else { // if file doesnot exits
                        echo 'No Image Found For this Item as file';

                        $stmt = $con->prepare("DELETE FROM items WHERE Item_ID = ?");
						$stmt->execute([$itemid]);
	
						$theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Record Deleted</div>';
						redirectHome($theMsg, 'back');
                    }

				} else { // If there is no Image For This Item Delete It from Database
                    $stmt3 = $con->prepare("DELETE FROM items WHERE Item_ID = ?");
                    $stmt3->execute([$itemid]);

                    echo $stmt3->rowCount() . ' Record Deleted';
				}

            } else {
				echo 'This ID Is Not Exist';
			}

        } else { echo 'Sorry You Can\'t Browse This Page Directly'; }
      		

?>