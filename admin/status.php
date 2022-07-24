<?php

	/*
	=================================================
	== Status Page
    == Add | edit | Delete Status
	=================================================
	*/

	ob_start(); // OutPut Buffering Start
	session_start();
	$pageTitle = 'Status';

    if (isset($_SESSION['Username'])) {
      include 'init.php';
      $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

	    if ($do == 'Manage') {

      	// Select All Users Except Admin
      	$stmt = $con->prepare("SELECT * FROM status ORDER BY stat_id DESC");
      	$stmt->execute();
      	$status = $stmt->fetchAll();

      	if (! empty($status)) {

      		?>

			<h1 class="text-center">Manage status</h1>
			<div class="container">
				<div class="members-options">
					<a class="btn btn-md btn-primary" href="status.php?do=Add"><i class="fa fa-plus"></i> New status</a>
					<a class="btn btn-primary btn-md" href="dashboard.php">back 
						<i class="fa fa-chevron-right fa-xs"></i>
					</a>
				</div>
				<div class="table-responsive">
					<table class="main-table text-center table table-bordered">
						<tr>
							<td>#ID</td>
							<td>Name</td>
							<td>Control</td>
						</tr>

						<?php
							foreach ($status as $stat) {
								echo "<tr>";
									echo "<td>" . $stat['stat_id'] . "</td>";
									echo "<td>" . $stat['stat_name'] . "</td>";
									echo "<td>
											<a href='status.php?do=Edit&stat_id=" . $stat['stat_id'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
											<a href='status.php?do=Delete&stat_id=" . $stat['stat_id'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete</a>";
									echo "</td>";
								echo "</tr>";
							}
						?>

					</table>
				</div>
			</div>

			<?php } else {

				echo '<div class="container">';
					echo '<div class="nice-message">There\'s No Status To Show</div>';
					echo '<a href="status.php?do=Add" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> New Status</a>';
				echo '</div>';


			} ?>

		<?php 


	  	} elseif ($do == 'Add') { ?>

	  		<h1 class="text-center">Add New Status</h1>
			<div class="container">
				<form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
					<!-- Start status Name Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Name</label>
						<div class="col-sm-10 col-md-8">
							<input 
								type="text" 
								name="name" 
								class="form-control" 
								required="required" 
								placeholder="Status Name" />
						</div>
					</div>
                    <!-- END status Name Field -->
					<!-- Start submit Field -->
					<div class="form-group form-group-lg">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="submit" value="Add status" class="btn btn-primary btn-sm" />
							<a class="btn btn-primary btn-sm" href="status.php">back 
								<i class="fa fa-chevron-right fa-xs"></i>
							</a>
						</div>
					</div>
					<!-- END submit Field -->
				</form>
			</div>

		<?php 


	    } elseif ($do == 'Insert') {

      		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	      		echo '<h1 class="text-center">Insert Status</h1>';
	      		echo '<div class="container">';

      			// Get Variables From The Form
      			$name   = $_POST['name'];
      			// Validate The Form
      			$formErrors = array();
      			if (empty($name)) { $formErrors[] = 'Name Can\'t be <strong>Empty</strong>'; }
      			// Loop Into Errors Array And Echo It
      			foreach($formErrors as $error) { echo '<div class="alert alert-danger">' . $error . '</div>'; }

      			// Check If There's No Error Proceed The Update Operation
      			if (empty($formErrors)) {

					// Insert Userinfo To Database
					$stmt = $con->prepare("INSERT INTO status(stat_name) VALUES(:zname)");
					$stmt->execute(array('zname'    => $name ));

					// Echo Success Message
					$theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Record Inserted</div>';
					redirectHome($theMsg, 'back');
      			}

      		} else {

      			echo '<div class="container">';
					$theMsg = '<div class="alert alert-danger">Sorry You Can\'t Browse This Page Directly</div>';
					redirectHome($theMsg);
      			echo '</div>';

      		}

      		echo '</div>';


	    } elseif ($do == 'Edit') {

			// Check If Get Request status Is Numberic & Get The Integer Value of it.
			$stat_id = isset($_GET['stat_id']) && is_numeric($_GET['stat_id']) ? intval($_GET['stat_id']) : 0;

			// Select All Data Depend on This ID
			$stmt = $con->prepare("SELECT * FROM status WHERE stat_id = ?");
			$stmt->execute([$stat_id]);
			$stat = $stmt->fetch();
			$count = $stmt->rowCount();

			// If There\s Such ID Show The Form
			if($count > 0) { ?>

				<h1 class="text-center">Edit Status</h1>
				<div class="container">
					<form class="form-horizontal" action="?do=Update" method="POST">
						<input type="hidden" name="stat_id" value="<?php echo $stat_id ?>" />
						<!-- Start Name Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Name</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="name" class="form-control" required="required" value="<?php echo $stat['stat_name'] ?>" />
							</div>
						</div>
						<!-- END Name Field -->
						<!-- Start submit Field -->
						<div class="form-group form-group-lg">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="submit" value="Save Status" class="btn btn-primary btn-sm">
								<a class="btn btn-primary btn-sm" href="status.php">back <i class="fa fa-chevron-right fa-xs"></i></a>
							</div>
						</div>
						<!-- END submit Field -->
					</form>	
				</div>

      		<?php

      		// If Theres No such ID show Error Message
      		} else {

      			echo '<div class="container">';
      				$theMsg = '<div class="alert alert-danger">There\'s no such id</div>';
      				redirectHome($theMsg);
      			echo '</div>';

      		}


	    } elseif ($do == 'Update') {

	    	echo '<h1 class="text-center">Update status</h1>';
      		echo '<div class="container">';

      		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      			// Get Variables From The Form
      			$stat_id        = $_POST['stat_id'];
      			$stat_name      = $_POST['name'];
      			// Validate The Form
      			$formErrors = array();
      			if (empty($stat_name)) { $formErrors[] = 'Name Can\'t be <strong>Empty</strong>'; }

      			// Loop Into Errors Array And Echo It
      			foreach($formErrors as $error) { echo '<div class="alert alert-danger">' . $error . '</div>'; }

      			// Check If There's No Error Proceed The Update Operation
      			if (empty($formErrors)) {

	      			// Update The Database With This Info
	      			$stmt = $con->prepare("UPDATE status SET stat_name = ? WHERE stat_id = ?");
	      			$stmt->execute([$stat_name, $stat_id]);

	       			// Echo Success Message
	      			$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';
	      			redirectHome($theMsg, 'back');

      			}

      		} else {

      			$theMsg = '<div class="alert alert-danger">Sorry You Can\'t Browse This Page Directly</div>';
      			redirectHome($theMsg);

      		}

      		echo '</div>';

	    } elseif ($do == 'Delete') {

			echo '<h1 class="text-center">Delete status</h1>';
      		echo '<div class="container">';

	      		// Check If Get Request status Is Numberic & Get The Integer Value of it.
				$stat_id = isset($_GET['stat_id']) && is_numeric($_GET['stat_id']) ? intval($_GET['stat_id']) : 0;

				// Select All Data Depend on This ID
				$check = checkItem('stat_id', 'status', $stat_id);

				// If There's Such ID Show The Form
				if ($check > 0) {
                    // begin to Delete
					$stmt = $con->prepare("DELETE FROM status WHERE stat_id = ?");
					$stmt->execute([$stat_id]);
                    // Echo msg
					$theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Record Deleted</div>';
					redirectHome($theMsg, 'back');

				} else {

					$theMsg = '<div class="alert alert-danger">This ID Is Not Exist</div>';
					redirectHome($theMsg);

				}

			echo '</div>';

		}

		include $tpl . 'footer.php';

	} else {

  		header('Location: index.php');

  		exit();

  }

	ob_end_flush();

?>