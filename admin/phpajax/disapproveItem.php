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

                // get approve value to check it
                $stmt = $con->prepare("SELECT approve FROM items WHERE Item_ID = ?");
                $stmt->execute([$itemid]);
                $getit = $stmt->fetch();
                    
                // if There is approve For this Item
                if ($getit['approve'] > 0) {

                    $stmt1 = $con->prepare("UPDATE items SET approve = 0 WHERE Item_ID = ?");
					$stmt1->execute([$itemid]);

                    echo 'Item dispproved';

				} else { // If there is no approve For This Item Approve it
                    echo 'it is already disapproved';
				}

            } else {
				echo 'This Item ID Does Not Exist';
			}

        } else { echo 'Sorry You Can\'t Browse This Page Directly'; }
      		

?>