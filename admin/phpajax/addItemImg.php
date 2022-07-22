<?php 

	include '../connect.php';
	include "../includes/functions/functions.php";

			// Insert Members Page

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				$itemid = $_POST['itemid'];

				// Upload Variables
	      		$ImgName 	= $_FILES['postImg']['name'];
	      		$ImgSize 	= $_FILES['postImg']['size'];
	      		$ImgTmp		= $_FILES['postImg']['tmp_name'];
	     		$ImgType 	= $_FILES['postImg']['type'] . '<br>';

	     		// List Of Allowed File Types To Upload
	     		$avatarAllowedExtension = array("jpeg", "jpg", "png", "gif");

	     		// Get postImg Extension
	     		$string = 'Osama.ahmed.sayed.ali';
				$explodedImg = explode('.', $ImgName);
	     		$avatarExtension = strtolower(end($explodedImg));

				// Validate The Form
      			$formErrors = array();
				
				
      			if (! empty($ImgName) && ! in_array($avatarExtension, $avatarAllowedExtension)) {
	     			$formErrors[] = 'This Extension Is Not <strong>Allowed</strong>';
	     		}

	     		if (empty($ImgName)) {
	     			$formErrors[] = 'Image Is <strong>Required</strong>';
	     		}

	     		if ($ImgSize > 16194304) {
	     			$formErrors[] = 'Image Can\'t Be Larger Than <strong>6MB</strong>';
	     		}

      			// Loop Into Errors Array And Echo It
      			foreach($formErrors as $error) {
      				echo $error;
      			}

      			// Check If There's No Error Proceed The Update Operation
      			if (empty($formErrors)) {
					
					$Img = rand(0, 1000000000) . '_' . $ImgName;

      				move_uploaded_file($ImgTmp, "../../products/" . $Img);

      				// Insert Item Img To Database
	  				$stmt = $con->prepare("UPDATE items SET Image = ? WHERE Item_ID = ?");
					$stmt->execute(array($Img, $itemid));

					// Echo Success Message
					$theMsg = '<p>Image Inserted and its name is : ' . $Img . '</p>';

					echo $theMsg;

	      		}


      		} else {

      			echo '<div class="container">';
	      			echo 'Sorry You Can\'t Browse This Page Directly';
      			echo '</div>';

	      	}
      		

?>