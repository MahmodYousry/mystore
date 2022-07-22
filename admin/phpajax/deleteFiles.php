<?php 

	include '../connect.php';
	include "../includes/functions/functions.php";

			// Insert Members Page
      		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      			if (isset($_POST['subdeliImage'])) {
	      		
	      			// Get Variables From The Form
	      			$path = "../../products/" . $_POST['delitemImageAddress'];
	      			unlink($path);
	      			echo "the image has been <strong>Deleted</strong> successfully";
	      			
	      		} else {

		      			echo '<div class="container">';
			      			$theMsg = 'Sorry You Can\'t Browse This Page Directly';
			      			echo $theMsg;
		      			echo '</div>';

		      		}


	      	} else { echo 'this is not post method'; }

      		

?>