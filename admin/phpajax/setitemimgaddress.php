<?php 

	include '../connect.php';
	include "../includes/functions/functions.php";

			// Insert Members Page
      		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				if ($_POST['itemid']) {

					$pid = $_POST['itemid'];
					$Img = $_POST['ImageAddress'];

					// Validate The Form
	      			$formErrors = array();

	      			// Loop Into Errors Array And Echo It
	      			foreach($formErrors as $error) {
	      				echo $error;
	      			}

	      			// Check If There's No Error Proceed The Update Operation
	      			if (empty($formErrors)) {

						// Insert Userinfo To Database
						$stmt = $con->prepare("UPDATE items SET Image = ? WHERE Item_ID = ?");
						$stmt->execute(array($Img, $pid));

						// Echo Success Message
						$theMsg = $stmt->rowCount() . ' Record Inserted';

						echo $theMsg;

		      		}


	      		} else {

		      			echo '<div class="container">';

			      			$theMsg = 'Sorry You Can\'t Browse This Page Directly';

			      			echo $theMsg;

		      			echo '</div>';

		      		}

			}
      		

?>