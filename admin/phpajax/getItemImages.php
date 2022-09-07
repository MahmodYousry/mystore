<?php 

	include '../connect.php';
	include "../includes/functions/functions.php";

        // Delete item image first and item
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // received variables
            $itemid = $_POST['itemid'];

            // get all item images using item id
            $stmt1 = $con->prepare("SELECT * FROM item_imgs WHERE item_ID = ? ORDER BY row_id DESC");
            $stmt1->execute([$itemid]);
            $itemImages = $stmt1->fetchAll();
            $count = $stmt1->rowCount();      // count how many row we got

            if ($count > 0) { // there is images for this item id

                // Start Output with array
                $php_output_array = [];
                
                for ($count = 0; $count < count($itemImages); $count++) {

                    if (!empty($itemImages[$count])) {

                        array_push($php_output_array, $itemImages[$count]);

                    }
        
                }


                
                // Convert the array to Json to send it back to the page
                $newJson = json_encode($php_output_array);
                // echo it
                echo $newJson;

            } else {
                echo 'noImages';
            }

           
           

        } else { echo 'Sorry You Can\'t Browse This Page Directly'; }
      		

?>