<?php 

	include '../connect.php';
	include "../includes/functions/functions.php";

        // Delete Members Avatar
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // received variables
            $userid = $_POST['userid'];

            // Select All Data Depend on This ID
			$check = checkItem('UserID', 'users', $userid);

			// If There's Such ID Show The Form
			if($check > 0) {

                // avatar check
                $checkAvatar = avatarCheck('avatar', 'users', 'UserID = ', $userid);

                if ($checkAvatar > 0) { // if There is Avatar For this User

					$stmt1 = $con->prepare("SELECT avatar FROM users WHERE UserID = ?");
					$stmt1->execute([$userid]);
					$avatr = $stmt1->fetch();

					$avUrl = "../uploads/avatars/" . $avatr['avatar'];

                    if (file_exists($avUrl)) { // if file exits
                        echo 'there is avatar found ';
                        // Delete Avatar Photo File From the Server using the url given
                        // if done delete it from database
                        if (unlink($avUrl)) { 
                            // show succes message for Avatar Deleted
                            echo 'There is ' . $stmt1->rowCount() . ' Avatar Deleted';
                        } else {
                            echo 'Failed To Delete The Avatar or The Url Not Good';
                        }
                        
                    } else { // if file doesnot exits
                        echo 'No avatar Found For this user as file';
                    }

                    


				} else { // If there is no Avatar For This User Delete his info from Database
					$theMsg = 'there is not Avatar For this user';
					echo $theMsg;
				}

            } else {
				echo 'This ID Is Not Exist';
			}

        } else { echo 'Sorry You Can\'t Browse This Page Directly'; }
      		

?>