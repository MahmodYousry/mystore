<?php
	ob_start();
	session_start();

    $pageTitle = 'Homepage';
	include 'init.php';

?>

<div class="container">
	<div class="row">
		<?php 
			// get item info with no image
			$stmt = $con->prepare("SELECT * FROM items
									JOIN `status` ON `status`.stat_id = items.Status
									WHERE Approve = 1 ORDER BY Item_ID DESC");
			$stmt->execute();
			$allItems = $stmt->fetchAll();


			

			foreach ($allItems as $item) {

				// get item images by item id
				$stmtimg = $con->prepare("SELECT * FROM item_imgs WHERE item_ID  = ?");
				$stmtimg->execute([$item['Item_ID']]);
				$itemImgs = $stmtimg->fetch();

				echo '<div class="col-sm-6 col-md-3">';
					echo '<div class="thumbnail item-box">';
						echo '<span class="price-tag">جنيه ' . $item['Price'] . '</span>';
						echo '<a href="items.php?itemid=' . $item['Item_ID'] . '"><img class="img-responsive product-img" src="products/' . $itemImgs[1] . '" alt="" /></a>';
						echo '<div class="caption">';
							echo '<h3 class="text-center"><a href="items.php?itemid=' . $item['Item_ID'] . '">' . $item['Name'] . '</a></h3>';
							echo '<p class="text-center">' . $item['Description'] . '</p>';
							echo '<p class="text-center">' . $item['stat_name'] . '</p>';
							echo '<div class="date">' . $item['Add_Date'] . '</div>';
						echo '</div>';
					echo '</div>';
				echo '</div>';
			}
		?>
	</div>
</div>

<?php	
	include $tpl . 'footer.php'; 
	ob_end_flush();
?>