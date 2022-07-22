<?php 


	include '../admin/connect.php';
	include "../admin/includes/functions/functions.php";

	// Insert Members Page
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		// Validate The Form
		$formErrors = array();

		$username 	= $_POST['username'];
  		$password 	= $_POST['password'];
  		$password2 	= $_POST['password2'];
  		$email 		= $_POST['email'];

 		// Upload avatar image Variables
  		$ImgName 	= $_FILES['avatarImg']['name'];
  		$ImgSize 	= $_FILES['avatarImg']['size'];
  		$ImgTmp		= $_FILES['avatarImg']['tmp_name'];
 		$ImgType 	= $_FILES['avatarImg']['type'];

 		// List Of Allowed File Types To Upload
 		$avatarAllowedExtension = array("jpeg", "jpg", "png", "gif");

 		// Get postImg Extension
 		$string = 'Osama.ahmed.sayed.ali';

		$imgNameExp = explode('.', $ImgName);
 		$avatarExtensionbanner 	= strtolower(end($imgNameExp));

		if (isset($username)) {

  			$filterdUser = filter_var($username, FILTER_SANITIZE_STRING);
  			if (strlen($filterdUser) < 4) {
  				$formErrors[] = '<strong>Username</strong> Must Be Larger Than <strong>4</strong> Characters';
  			}

		}

		if (isset($password) && isset($password2)) {

  			if (empty($password)) {
  				$formErrors[] = 'Sorry <strong>Password</strong> Can\'t Be <strong>Empty</strong>';
  			}

  			if (sha1($password) !== sha1($password2)) {
  				$formErrors[] = 'Sorry <strong>Password</strong> Is Not Match';
  			}

		}

		if (isset($email)) {

  			$filterdEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
  			if (filter_var($filterdEmail, FILTER_VALIDATE_EMAIL) != True) {
  				$formErrors[] = 'This Email Is Not Valid';
  			}

      	}

 		if (! empty($ImgName) && ! in_array($avatarExtensionbanner, $avatarAllowedExtension)) {
 			$formErrors[] = 'This Extension Is Not <strong>Allowed</strong>';
 		}

 		if ($ImgName > 8388608) {
 			$formErrors[] = 'Image Can\'t Be Larger Than <strong>6MB</strong>';
 		}

		// Loop Into Errors Array And Echo It
		foreach($formErrors as $error) {
			echo $error;
		}

		// Check If There's No Error Proceed The Update Operation
		if (empty($formErrors)) {

			// Check If User Is Exist In Database
			$check = checkItem("Username", "users", $username);
			// 1 means exist
			if ($check == 1) {
				$formErrors[] = 'Sorry This User Is Exist';
			} else {

				$Img = rand(0, 1000000000) . '_' . $ImgName;

				move_uploaded_file($ImgTmp, "../admin/uploads/avatars/" . $Img);

				echo $ImgName . " <span class='orange-font'>upload is complete</span></br></br>";
					
      			// Insert Userinfo To Database
  				$stmt = $con->prepare("INSERT INTO users(Username, Password, Email, RegStatus, Date, avatar) 
					      				VALUES(:zuser, :zpass, :zmail, 0, now(), :zavatar)");
  				$stmt->execute(array(

  					'zuser' 	=> $username,
  					'zpass' 	=> sha1($password),
  					'zmail' 	=> $email,
  					'zavatar' 	=> $Img

  				));

       			// Echo Success Message
 
      			$succesMsg = 'مبروك ! انت الان عضو مسجل';
      			// Echo Success Message
				echo  $stmt->rowCount() . " <span class='orange-font'>Stored in Database successfuly</span></br>";
				echo $succesMsg;

			}

		}


	} else {

		echo '<div class="container">';

			$theMsg = 'Sorry You Can\'t Browse This Page Directly';

			echo $theMsg;

		echo '</div>';

	}
      		

?>