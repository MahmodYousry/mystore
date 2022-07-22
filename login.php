<?php
	ob_start();
	session_start();
    $pageTitle = 'Login';
    if (isset($_SESSION['user'])) {
    	header('Location: index.php');
    }
	include 'init.php';

    // Check If User Coming From HTTP Post Request

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      if (isset($_POST['login'])) {
    
	      $user = $_POST['username'];
	      $pass = $_POST['password'];
	      $hashedpass = sha1($pass);

	      // Check If User Is Exist In Database

	      $stmt = $con->prepare("SELECT
	                                  UserID, Username, Password 
	                                FROM 
	                                    users 
	                                WHERE
	                                    Username = ? 
	                                AND 
	                                    Password = ? ");

	      $stmt->execute(array($user, $hashedpass));

	      $get = $stmt->fetch();

	      $count = $stmt->rowCount();

	      // If Count > 0 This Mean The Database Contain Record About This Username

	      if ($count > 0) {

	        $_SESSION['user'] = $user; // Register Session name

	        $_SESSION['uid'] = $get['UserID']; // Register User ID in Session

	    	header('Location: index.php'); //Redirect To Dashboard Page

	        exit();
	      }

      }

	}

?>

	<div class="container login-page">
		<h1 class="text-center">
			<span class="selected" data-class="login">Login</span> | 
			<span data-class="signup">Signup</span>
		</h1>

		<!-- Start Login Form -->
		<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
			<div class="input-container">
				<input 
					class="form-control"
					type="text" 
					name="username" 
					autocomplete="off"
					placeholder="Type Your Username"
					required />
			</div>
			<div class="input-container">
				<input 
					class="form-control" 
					type="password" 
					name="password" 
					autocomplete="new-password"
					placeholder="Type Your Password"
					required />
				<input class="btn btn-primary btn-block" name="login" type="submit" value="Login" />
			</div>
		</form>
		<!-- END Login Form -->
		<!-- Start Signup Form -->
		<form id="addNewUser" class="signup" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">

			<progress id="progressBar" style="width: 100%;height: 50px;color: #f90;" value="0" max="100" ></progress>
			<h3 class="statusbar" id="status"></h3>
			<p id="loading_n_total"></p>

			<div class="input-container">
				<input
					pattern=".{4,}"
					title="Username Must Be More Than 4 Characters" 
					class="form-control username"
					type="text" 
					name="username" 
					autocomplete="off"
					placeholder="Type Your Username"
					/>
			</div>
			<div class="input-container">
				<input
					class="form-control pass" 
					type="password" 
					name="password" 
					autocomplete="new-password"
					placeholder="Type Your Complex Password"
				/>
			</div>
			<div class="input-container">
				<input 
					class="form-control pass2" 
					type="password" 
					name="password2" 
					autocomplete="new-password"
					placeholder="Type a password again"
				/>
			</div>
			<div class="input-container">
				<input 
					id="emailsign"
					class="form-control" 
					type="text" 
					name="email"
					placeholder="Type a Valid Email"
				/>
			</div>
			<div class="input-container">
				<div class="custom-file">
					<input type="file" class="custom-file-input" name="avatarImg" id="customFile">
					<label class="custom-file-label" for="customFile">اختر صوره لك</label>
				</div>
				<input class="btn btn-success btn-block" name="signup" type="submit" value="Signup" />
			</div>
		</form>
		<!-- END Signup Form -->
		<div class="the-errors text-center">
			<?php 

				if (!empty($formErrors)) {

					foreach ($formErrors as $error) {
						echo '<div class="msg error">' . $error . '</div>';
					}

				}

				if (isset($succesMsg)) {
					
					echo '<div class="msg success">' . $succesMsg . '</div>';
					
				}

			?>
		</div>
	</div>

<?php 
	include $tpl . 'footer.php';
	ob_end_flush();
?>