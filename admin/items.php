<?php

	/*
	=================================================
	== Items Page
	=================================================
	*/

	ob_start(); // OutPut Buffering Start
	session_start();
	$pageTitle = 'Items';

    if (isset($_SESSION['Username'])) {
      include 'init.php';
      $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

	    if ($do == 'Manage') {
      	// Select All Users Except Admin

      	$stmt = $con->prepare("SELECT 
      								items.*, 
      								categories.Name AS catgory_name,
      								users.Username 
      							FROM 
      								items
								INNER JOIN 
									categories 
								ON 
									categories.ID = items.Cat_ID 

								INNER JOIN 
									users 
								ON 
									users.UserID = items.Member_ID
								ORDER BY 
      						   		Item_ID DESC");

      	$stmt->execute();
      	$items = $stmt->fetchAll();

      	if (! empty($items)) {

      		?>

			<h1 class="text-center">Manage Items</h1>
			<div class="container">
				<div class="members-options">
					<a class="btn btn-md btn-primary" href="items.php?do=Add"><i class="fa fa-plus"></i> New Item</a>
					<a class="btn btn-primary btn-md" href="dashboard.php">back 
						<i class="fa fa-chevron-right fa-xs"></i>
					</a>
				</div>
				<div class="table-responsive">
					<table class="main-table text-center table table-bordered">
						<tr>
							<td>#ID</td>
							<td>Image</td>
							<td>Name</td>
							<td>Description</td>
							<td>Price</td>
							<td>Adding Date</td>
							<td>Category</td>
							<td>Username</td>
							<td>Control</td>
						</tr>

						<?php
							foreach ($items as $item) {
								echo "<tr>";
									echo "<td>" . $item['Item_ID'] . "</td>";
									echo "<td><img class='items-image' src='../products/" . $item['Image'] . "'/></td>";
									echo "<td>" . $item['Name'] . "</td>";
									echo "<td>" . $item['Description'] . "</td>";
									echo "<td>" . $item['Price'] . "</td>";
									echo "<td>" . $item['Add_Date'] . "</td>";
									echo "<td>" . $item['catgory_name'] . "</td>";
									echo "<td>" . $item['Username'] . "</td>";
									echo "<td>
											<a href='items.php?do=Edit&itemid=" . $item['Item_ID'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
											<a href='items.php?do=setimg&itemid=" . $item['Item_ID'] . "' class='btn btn-primary'><i class='fa fa-edit'></i> Set Image</a>
											<a href='items.php?do=removeimg&itemid=" . $item['Item_ID'] . "' class='btn btn-danger'><i class='fa fa-close'></i> Delete Img</a>
											<a href='items.php?do=Delete&itemid=" . $item['Item_ID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete all</a>";
											if ($item['Approve'] == 0) {
												echo "<a href='items.php?do=Approve&itemid=" . $item['Item_ID'] . "' class='btn btn-info activate'><i class='fa fa-check'></i> Approve</a>";
											}
									echo "</td>";
								echo "</tr>";
							}
						?>

					</table>
				</div>
			</div>

			<?php } else {

				echo '<div class="container">';
					echo '<div class="nice-message">There\'s No Items To Show</div>';
					echo '<a href="items.php?do=Add" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> New Item</a>';
				echo '</div>';


			} ?>

		<?php 


	  	} elseif ($do == 'Add') { ?>

	  		<h1 class="text-center">Add New Item</h1>
			<div class="container">
				<form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
					<!-- Start Name Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Name</label>
						<div class="col-sm-10 col-md-8">
							<input 
								type="text" 
								name="name" 
								class="form-control" 
								required="required" 
								placeholder="Name of The Item" />
						</div>
					</div>
					<!-- END Name Field -->
					<!-- Start Description Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Description</label>
						<div class="col-sm-10 col-md-8">
							<input 
								type="text" 
								name="description" 
								class="form-control" 
								required="required" 
								placeholder="Description of The Item" />
						</div>
					</div>
					<!-- END Description Field -->
					<!-- Start Price Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Price</label>
						<div class="col-sm-10 col-md-8">
							<input 
								type="text" 
								name="price" 
								class="form-control" 
								required="required" 
								placeholder="Price of The Item" />
						</div>
					</div>
					<!-- END Price Field -->
					<!-- Start Country Field -->
					<!-- <div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Country</label>
						<div class="col-sm-10 col-md-8">
							<input 
								type="text" 
								name="country" 
								class="form-control" 
								required="required" 
								placeholder="Country of Made" />
						</div>
					</div> -->
					<!-- END Country Field -->
					<!-- Start Status Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Status</label>
						<div class="col-sm-10 col-md-8">
							<select name="status">
								<option value="0">...</option>
								<option value="1">New</option>
								<option value="2">Like New</option>
								<option value="3">Used</option>
								<option value="4">Very Old</option>
							</select>
						</div>
					</div>
					<!-- END Status Field -->
					<!-- Start Members Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Member</label>
						<div class="col-sm-10 col-md-8">
							<select name="member">
								<option value="0">...</option>
								<?php
									$allMembers = getAllFrom("*", "users", "", "", "UserID");
									foreach ($allMembers as $user) {
										echo "<option value='" . $user['UserID'] . "'>" . $user['Username'] . "</option>";
									}
								?>
							</select>
						</div>
					</div>
					<!-- END Members Field -->
					<!-- Start Categories Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Category</label>
						<div class="col-sm-10 col-md-8">
							<select name="category">
								<option value="0">...</option>
								<?php
									$allCats = getAllFrom("*", "categories", "where parent = 0", "", "ID");
									foreach ($allCats as $cat) {
										echo "<option value='" . $cat['ID'] . "'>" . $cat['Name'] . "</option>";
										$childCats = getAllFrom("*", "categories", "where parent = {$cat['ID']}", "", "ID");
										foreach ($childCats as $child) {
											echo "<option value='" . $child['ID'] . "'>--- " . $child['Name'] . "</option>";
										}
									}
								?>
							</select>
						</div>
					</div>
					<!-- END Categories Field -->
					<!-- Start Tags Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Tags</label>
						<div class="col-sm-10 col-md-8">
							<input 
								type="text" 
								name="tags" 
								class="form-control"
								placeholder="Separate Tags With Comma (,)" />
						</div>
					</div>
					<!-- END Tags Field -->
					<!-- Start upload pic Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label" for="filepic">img</label>
						<div class="col-sm-10 col-md-8">
							<input type="file" class="form-control" id="filepic" name="productpic">
						</div>
						
					</div>
					<!-- END upload pic Field -->
					<!-- Start submit Field -->
					<div class="form-group form-group-lg">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="submit" value="Add Item" class="btn btn-primary btn-sm" />
							<a class="btn btn-primary btn-sm" href="items.php">back 
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

	      		echo '<h1 class="text-center">Insert Item</h1>';
	      		echo '<div class="container">';

      			// Get Variables From The Form

				// Upload Variables
				$avatarName =  $_FILES['productpic']['name'];
				$avatarSize =  $_FILES['productpic']['size'];
				$avatarTmp 	=  $_FILES['productpic']['tmp_name'];
			   	$avatarType =  $_FILES['productpic']['type'] . '<br>';

				// List Of Allowed File Types To Upload
				$avatarAllowedExtension = array("jpeg", "jpg", "png", "gif");

				// explose shortcut for php 8 need
				$explodeThispl = explode('.', $avatarName);
				$avatarExtension = strtolower(end($explodeThispl));

      			$name 		= $_POST['name'];
      			$desc 		= $_POST['description'];
      			$price 		= $_POST['price'];
      			//$country 	= $_POST['country'];
      			$status 	= $_POST['status'];
      			$member 	= $_POST['member'];
      			$cat 		= $_POST['category'];
      			$tags 		= $_POST['tags'];

      			// Validate The Form
      			$formErrors = array();

      			if (empty($name)) { $formErrors[] = 'Name Can\'t be <strong>Empty</strong>'; }
				if (empty($desc)) { $formErrors[] = 'Description Can\'t be <strong>Empty</strong>'; }
      			if (empty($price)) { $formErrors[] = 'Price Can\'t be <strong>Empty</strong>'; }
      			//if (empty($country)) { $formErrors[] = 'Country Can\'t be <strong>Empty</strong>'; }
				if ($status == 0) { $formErrors[] = 'You Must Choose The <strong>Status</strong>'; }
				if ($member == 0) { $formErrors[] = 'You Must Choose The <strong>Member</strong>'; }
				if ($cat == 0) { $formErrors[] = 'You Must Choose The <strong>Category</strong>'; }

				if (empty($avatarName)) { $formErrors[] = 'Avatar Is <strong>Required</strong>'; }
				if ($avatarSize > 6194304) { $formErrors[] = 'Avatar Can\'t Be Larger Than <strong>6MB</strong>'; }

      			// Loop Into Errors Array And Echo It
      			foreach($formErrors as $error) {
      				echo '<div class="alert alert-danger">' . $error . '</div>';
      			}

      			// Check If There's No Error Proceed The Update Operation
      			if (empty($formErrors)) {

					$avatar = rand(0, 10000) . '_' . $avatarName;
      				move_uploaded_file($avatarTmp, "../products/" . $avatar);

					// Insert Userinfo To Database
					$stmt = $con->prepare("INSERT INTO 
							items(Name, Description, Price, Status, Add_Date, Cat_ID, Member_ID, tags, Image)
						VALUES(:zname, :zdesc, :zprice, :zstatus, now(), :zcat, :zmember, :ztags, :zImage)");

					$stmt->execute(array(
						'zname'		=> $name,
						'zdesc'		=> $desc,
						'zprice'	=> $price,
						'zstatus'	=> $status,
						'zcat'		=> $cat,
						'zmember'	=> $member,
						'ztags'		=> $tags,
						'zImage'  	=> $avatar
					));

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


	    } elseif ($do == 'setimg') { ?>

	    	
			<h1 class="text-center">upload Image for item</h1>
			<div class="container">
				<!-- Start form-img Field -->
				<form id="setImgForitem-form" class="form-horizontal" enctype="multipart/form-data">

					<progress id="progressBar" style="width: 100%;height: 50px;color: #f90;" value="0" max="100" ></progress>
					<h3 class="stltx" id="stltx"></h3>
					<p id="loading_n_total"></p>

					<!-- Start post-img Field -->
					<div class="form-group form-group-lg">
						<div class="col-sm-10 col-md-6">
							<input type="hidden" name="itemid" class="form-control" value="<?php if (isset($_GET["itemid"])) { echo $_GET["itemid"];} ?>" autocomplete="off" />
						</div>
					</div>
					<!-- END post-img Field -->
					
					<!-- Start post-img Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Image</label>
						<div class="col-sm-10 col-md-6">
							<input type="file" name="postImg" class="form-control newitemImg" autocomplete="off" />
						</div>
					</div>
					<!-- END post-img Field -->
					<!-- Start submit Field -->
					<div class="form-group form-group-lg">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="submit" value="Upload" class="btn btn-primary btn-lg" />
						</div>
					</div>
					<!-- END submit Field -->
				</form>
				<!-- END form-img Field -->
			</div>
      	


<?php   } elseif ($do == 'removeimg') {


			echo '<h1 class="text-center">Delete Item Image</h1>';
      		echo '<div class="container">';

      		$itemofid = $_GET['itemid'];

	  		$getAny = $con->prepare("SELECT * FROM items WHERE Item_ID = ?");
			
			$getAny->execute(array($itemofid));
			
			$lnks = $getAny->fetchAll();

      		foreach ($lnks as $lnk) {
      			
      		?>

      		<div class="message ms-delimg"></div>
			<!-- Start form-img Field -->
			<form id="del-item-image-form" class="form-horizontal" enctype="multipart/form-data">
				<!-- Start post-img Field -->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Image Address</label>
					<div class="col-sm-10 col-md-6">
						<input id="delitemImageAddress" type="text" value="<?php echo $lnk['Image']; ?>" name="deladdresImg" class="form-control" autocomplete="off" />
					</div>
				</div>
				<!-- END post-img Field -->
				<!-- Start submit Field -->
				<div class="form-group form-group-lg">
					<div class="col-sm-offset-2 col-sm-10">
						<input id="subdeliImage" type="submit" value="Delete" class="btn btn-primary btn-lg" />
					</div>
				</div>
				<!-- END submit Field -->
			</form>
			<!-- END form-img Field -->
 
		<?php }  echo "</div>";

		






		} elseif ($do == 'Edit') {

			// Check If Get Request item Is Numberic & Get The Integer Value of it.

			$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

			// Select All Data Depend on This ID
			$stmt = $con->prepare("SELECT * FROM items WHERE Item_ID = ?");
			$stmt->execute(array($itemid));
			$item = $stmt->fetch();
			$count = $stmt->rowCount();

			// If There\s Such ID Show The Form


			if($count > 0) { ?>

				<h1 class="text-center">Edit Item</h1>
				<div class="container">
					<form class="form-horizontal" action="?do=Update" method="POST">
						<input type="hidden" name="itemid" value="<?php echo $itemid ?>" />
						<!-- Start Name Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Name</label>
							<div class="col-sm-10 col-md-6">
								<input 
									type="text" 
									name="name" 
									class="form-control"
									required="required" 
									placeholder="Name of The Item"
									value="<?php echo $item['Name'] ?>" />
							</div>
						</div>
						<!-- END Name Field -->
						<!-- Start Description Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Description</label>
							<div class="col-sm-10 col-md-6">
								<input 
									type="text" 
									name="description" 
									class="form-control" 
									required="required" 
									placeholder="Description of The Item"
									value="<?php echo $item['Description'] ?>" />
							</div>
						</div>
						<!-- END Description Field -->
						<!-- Start Price Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Price</label>
							<div class="col-sm-10 col-md-6">
								<input 
									type="text" 
									name="price" 
									class="form-control" 
									required="required" 
									placeholder="Price of The Item"
									value="<?php echo $item['Price'] ?>" />
							</div>
						</div>
						<!-- END Price Field -->
						<!-- Start Status Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Status</label>
							<div class="col-sm-10 col-md-6">
								<select name="status">
									<option value="1" <?php if ($item['Status'] == 1) { echo 'selected'; } ?>>New</option>
									<option value="2" <?php if ($item['Status'] == 2) { echo 'selected'; } ?>>Like New</option>
									<option value="3" <?php if ($item['Status'] == 3) { echo 'selected'; } ?>>Used</option>
									<option value="4" <?php if ($item['Status'] == 4) { echo 'selected'; } ?>>Very Old</option>
								</select>
							</div>
						</div>
						<!-- END Status Field -->
						<!-- Start Members Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Member</label>
							<div class="col-sm-10 col-md-6">
								<select name="member">
									<?php 
										$stmt = $con->prepare("SELECT * FROM users ");
										$stmt->execute();
										$users = $stmt->fetchAll();
										foreach ($users as $user) {
											echo "<option value='" . $user['UserID'] . "'"; 
											if ($item['Member_ID'] == $user['UserID']) { echo 'selected'; } 
											echo ">" . $user['Username'] . "</option>";
										}
									?>
								</select>
							</div>
						</div>
						<!-- END Members Field -->
						<!-- Start Categories Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Category</label>
							<div class="col-sm-10 col-md-6">
								<select name="category">
									<?php 
										$stmt2 = $con->prepare("SELECT * FROM categories");
										$stmt2->execute();
										$cats = $stmt2->fetchAll();
										foreach ($cats as $cat) {
											echo "<option value='" . $cat['ID'] . "'";
											if ($item['Cat_ID'] == $cat['ID']) { echo 'selected'; }
											echo ">" . $cat['Name'] . "</option>";
										}
									?>
								</select>
							</div>
						</div>
						<!-- END Categories Field -->
						<!-- Start Tags Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Tags</label>
							<div class="col-sm-10 col-md-6">
								<input 
									type="text" 
									name="tags" 
									class="form-control"
									placeholder="Separate Tags With Comma (,)"
									value="<?php echo $item['tags'] ?>" />
							</div>
						</div>
						<!-- END Tags Field -->
						<!-- Start submit Field -->
						<div class="form-group form-group-lg">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="submit" value="Save Item" class="btn btn-primary btn-sm">
								<a class="btn btn-primary btn-sm" href="items.php">back <i class="fa fa-chevron-right fa-xs"></i></a>
							</div>
						</div>
						<!-- END submit Field -->
					</form>

					<?php

					// Select All Users Except Admin

					$stmt = $con->prepare("SELECT 
												comments.*, users.Username AS Member
											FROM 
												comments
											INNER JOIN
												users
											ON
												users.UserID = comments.user_id
											WHERE item_id = ?");
					$stmt->execute(array($itemid));
					$rows = $stmt->fetchAll();

					if (! empty($rows)) {

					?>

						<h1 class="text-center">Manage [ <?php echo $item['Name'] ?> ] Comments</h1>
						<div class="table-responsive">
							<table class="main-table text-center table table-bordered">
								<tr>
									<td>Comment</td>
									<td>User Name</td>
									<td>Added Date</td>
									<td>Control</td>
								</tr>

								<?php
									foreach ($rows as $row) {
										echo "<tr>";
											echo "<td>" . $row['comment'] . "</td>";
											echo "<td>" . $row['Member'] . "</td>";
											echo "<td>" . $row['comment_date'] . "</td>";
											echo "<td>
													<a href='comments.php?do=Edit&comid=" . $row['c_id'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edite</a>
													<a href='comments.php?do=Delete&comid=" . $row['c_id'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete</a>";
													if ($row['status'] == 0) {
														echo "<a href='comments.php?do=Approve&comid=" . $row['c_id'] . "' class='btn btn-info activate'><i class='fa fa-check'></i> Approve</a>";
													}
											echo "</td>";
										echo "</tr>";
									}
								?>

							</table>
						</div>
						<?php } ?>	
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

	    	echo '<h1 class="text-center">Update item</h1>';
      		echo '<div class="container">';

      		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      			// Get Variables From The Form

      			$id 		= $_POST['itemid'];
      			$name 		= $_POST['name'];
      			$desc 		= $_POST['description'];
      			$price 		= $_POST['price'];
      			$status 	= $_POST['status'];
      			$cat 		= $_POST['category'];
      			$member 	= $_POST['member'];
      			$tags 		= $_POST['tags'];

      			// Validate The Form

      			$formErrors = array();

      			if (empty($name)) { $formErrors[] = 'Name Can\'t be <strong>Empty</strong>'; }
				if (empty($desc)) { $formErrors[] = 'Description Can\'t be <strong>Empty</strong>'; }
      			if (empty($price)) { $formErrors[] = 'Price Can\'t be <strong>Empty</strong>'; }
				if ($status == 0) { $formErrors[] = 'You Must Choose The <strong>Status</strong>'; }
				if ($member == 0) { $formErrors[] = 'You Must Choose The <strong>Member</strong>'; }
				if ($cat == 0) { $formErrors[] = 'You Must Choose The <strong>Category</strong>'; }

      			// Loop Into Errors Array And Echo It
      			foreach($formErrors as $error) {
      				echo '<div class="alert alert-danger">' . $error . '</div>';
      			}

      			// Check If There's No Error Proceed The Update Operation
      			if (empty($formErrors)) {

	      			// Update The Database With This Info
	      			$stmt = $con->prepare("UPDATE items SET 
	      								   		Name = ?,
	      								   		Description = ?, 
	      								   		Price = ?,
	      								   		Status = ?,
	      								   		Cat_ID = ?,
	      								   		Member_ID = ?,
	      								   		tags = ?
	      								   WHERE 
	      								   		Item_ID = ?");

	      			$stmt->execute(array($name, $desc, $price, $status, $cat, $member, $tags, $id));

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

			echo '<h1 class="text-center">Delete Item</h1>';
      		echo '<div class="container">';

	      		// Check If Get Request itemid Is Numberic & Get The Integer Value of it.

				$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

				// Select All Data Depend on This ID

				$check = checkItem('Item_ID', 'items', $itemid);

				// If There's Such ID Show The Form

				if ($check > 0) {

					$stmt = $con->prepare("DELETE FROM items WHERE Item_ID = :zid");

					$stmt->bindParam(":zid", $itemid);

					$stmt->execute();

					$theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Record Deleted</div>';

					redirectHome($theMsg, 'back');

				} else {

					$theMsg = '<div class="alert alert-danger">This ID Is Not Exist</div>';

					redirectHome($theMsg);

				}

			echo '</div>';

		} elseif ($do == 'Approve') {

      		echo '<h1 class="text-center">Approve Item</h1>';
      		echo '<div class="container">';

	      		// Check If Get Request itemid Is Numberic & Get The Integer Value of it.

				$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

				// Select All Data Depend on This ID

				$check = checkItem('Item_ID', 'items', $itemid);

				// If There's Such ID Show The Form

				if($check > 0) {

					$stmt = $con->prepare("UPDATE items SET Approve = 1 WHERE Item_ID = ?");

					$stmt->execute(array($itemid));

					$theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Record Updated</div>';

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