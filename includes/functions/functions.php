<?php

	/*
	**	Get All Function v2.0
	**	Function To get All Records From Any Database Table
	*/

	function getAllFrom($field, $table, string $where = NULL, string $and = NULL, $orderfield, $ordering = "DESC") {

		global $con;

		$getAll = $con->prepare("SELECT $field FROM $table $where $and ORDER BY $orderfield $ordering");

		$getAll->execute();

		$all = $getAll->fetchAll();

		return $all;

	}

	/*
	**	Check If User Is Not Activated
	**	Function To Check RegStatus Of The User
	*/

	function checkUserStatus($user) {

		global $con;

		$stmtx = $con->prepare("SELECT
		                        	Username, RegStatus 
		                        FROM 
		                            users 
		                        WHERE
		                            Username = ? 
		                        AND 
		                            RegStatus = 0");

		$stmtx->execute(array($user));

		$status = $stmtx->rowCount();

		return $status;

	}

	/* 
	** Check Items Function v1.0
	** Function To Check Item In Database [ Function Accept Parameters ]
	** $select = The Item To Select [ Example: user, item, category ]
	** $from = The Table To Select From [ Example: users, items, categories ]
	** $Value = The Value Of Select [ Example: Osama, Box, Electronics ]
	*/

	function checkItem($select, $from, $value) {

		global $con;

		$statement = $con->prepare("SELECT $select FROM $from WHERE $select = ?");

		$statement->execute(array($value));

		$count = $statement->rowCount();

		return $count;

	}

















	

	/*
	** Title Function v1.0
	** Title Function That Echo The Page Title In Case The Page
	** Has The Variable $pageTitle And Echo Default Title For Other Pages
	*/

	function getTitle() {

		global $pageTitle;

		if (isset($pageTitle)) {

			echo $pageTitle;

		} else {

			echo 'Default';

		}

	}


	/*
	** Home Redirect Function v2.0
	** This Function Accept Parameters.
	** $theMsg = Echo The Message [ Error | Success | Warning ].
	** $url = Link That You Want to Redirect To.
	** $seconds = Seconds Before Redirecting.
	*/

	function redirectHome($theMsg, $url = null, $seconds = 3) {

		if ($url === null) {

			$url = 'index.php';

			$link = 'Homepage';

		} else {

			if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {

				$url = $_SERVER['HTTP_REFERER'];

				$link = 'Previous Page';

			} else {

				$url = 'index.php';

				$link = 'Homepage';

			}

		}

		echo $theMsg;

		echo "<div class='alert alert-info'>You Will Be Redirected To $link After $seconds Seconds.</div>";

		header("refresh:$seconds;url=$url");

		exit();

	}


	/*
	**	Get AD Items Function v2.0
	**	Function To Get Items From Database
	*/

	function getItems($where, $value, $approve = NULL) {

		global $con;

		$sgl = $approve == NULL ? $sgl = 'AND Approve = 1' : '';

		$getItems = $con->prepare("SELECT * FROM items WHERE $where = ? $sgl ORDER BY Item_ID DESC");

		$getItems->execute(array($value));

		$items = $getItems->fetchAll();

		return $items;

	}

	/*
	**	Count Number Of Items Function v1.0
	**	Function To Count Number Of Items Rows.
	**	$item = The Item To Count.
	**	$table = The Table To Choose From.
	**
	*/

	function countItems($item, $table) {

		global $con;

		$stmt2 = $con->prepare("SELECT COUNT($item) FROM $table");

     	$stmt2->execute();

     	return $stmt2->fetchColumn();

	}



	/*
	**	Get Latest Records Function v1.0
	**	Function To get Latest items from database [ Users, Items, Comments ]
	**	$select = Field To Select.
	**	$table = The Tabke To Choose From.
	**  $order = the DESC ordering.
	**	$limit = number of records to get.
	*/


	function getLatest($select, $table, $order, $limit = 5) {

		global $con;

		$getStmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC limit $limit");

		$getStmt->execute();

		$rows = $getStmt->fetchAll();

		return $rows;

	}


	