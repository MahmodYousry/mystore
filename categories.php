<?php
	ob_start();
	session_start();
	include 'init.php';
?>

<div class="container">
	<h1 class="text-center">Show Category Items</h1>
	<div class="row">
		<?php
		if (isset($_GET['pageid']) && is_numeric($_GET['pageid'])) {
			$category = intval($_GET['pageid']);
			$allItems = getAllFrom("*", "items", "where Cat_ID = {$category}", "AND Approve = 1", "Item_ID", "ASC");
			foreach ($allItems as $item) {
				echo '<div class="col-sm-6 col-md-3">';
					echo '<div class="thumbnail item-box">';
						echo '<span class="price-tag">$' . $item['Price'] . '</span>';
						echo '<a href="items.php?itemid=' . $item['Item_ID'] . '"><img class="img-responsive product-img" src="products/' . $item['Image'] . '" alt="" /></a>';
						echo '<div class="caption">';
							echo '<h3 class="text-center"><a href="items.php?itemid=' . $item['Item_ID'] . '">' . $item['Name'] . '</a></h3>';
							echo '<p class="text-center">' . $item['Description'] . '</p>';
							echo '<div class="date">' . $item['Add_Date'] . '</div>';
						echo '</div>';
					echo '</div>';
				echo '</div>';
			}
		} else {
			echo 'You Must Add Page ID';
		}

		?>
	</div>
</div>

<?php 
	include $tpl . 'footer.php';
	ob_end_flush();
?>