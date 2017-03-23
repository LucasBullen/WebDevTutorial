<?php
	//used to print PHP errors
	error_reporting(E_ALL); ini_set('display_errors', '1');

	// used to connect to the database
	$host = "localhost";
	$db_name = "GuestBook";
	$username = "root";
	$password = "password";
	$cxn;

	try {
	    $cxn = new mysqli($host,$username,$password, $db_name);
	}

	// show error
	catch(Exception $exception){
	    echo "Connection error: " . $exception->getMessage();
	}
?>


<?php
	//	Notice how there are multiple different sections of php
	//	code, all of them share the same domain of variables


	// The $_POST variable stores all POSTed information
	if(isset($_POST['Submit']) && isset($_POST['name'])){

		//SQL query to submit the signature
		$query = "INSERT INTO guests (name, datetime) VALUES (?,'".date('Y-m-d H:i:s')."')";
        // prepare query for execution
        if($stmt = $cxn->prepare($query)){

	        // bind the parameters. This is the best way to prevent SQL injection hacks.
	        $stmt->bind_Param("s", $_POST['name']);

	        // Execute the query
			$stmt->execute();

		} else {
			echo "failed to prepare the SQL";
		}
	}
?>

<?php
	//The is the HTML that will be added to the page
	$tableHTML = "";

	//SQL query to submit the signature
	$query = "SELECT * FROM guests";
    // Execute the query
    if($stmt = $cxn->prepare($query)){
		$stmt->execute();

		/* resultset */
		$result = $stmt->get_result();

		// Get the number of rows returned
		$num = $result->num_rows;
		$names = array();
		$dates = array();
		if($num>0){
			// loop for each row returned, adding it to an array
			while ($row = $result->fetch_assoc()) {
				array_push($names, $row['name']);
				array_push($dates, $row['datetime']);
			}
			$tableHTML .= buildRows($names,$dates);
		}
	} else {
		echo "failed to prepare the SQL";
	}

	/*
		PHP Function for creating the HTML for each
		row in the guests table
	*/
	function buildRows($names,$dates){
		$tableHTMLToAdd = "";
		for ($i=0; $i < count($names); $i++) {
			$tableHTMLToAdd.= "<tr><td>";
			$tableHTMLToAdd.= $names[$i]."</td><td>";
			$tableHTMLToAdd.= $dates[$i]."</td><td>";
			$tableHTMLToAdd.= "</td></tr>";
		}
		return $tableHTMLToAdd;
	}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="styles.css">
	<script type="text/javascript" src="code.js"></script>
</head>
<body>
	<div class="section" id="welcome-section">
		<h1 id="title">My Website Guest Book</h1>
		<p class="text">
			Guests of my website are able to come in and sign their name so that
			they are forever remembered.
			<!--
				Notice how this new line did not change the style of the website
				that is because HTML ignores white space. If you wish to add a new
				line, then use the </br> tag or type in a new </p> tag.
			-->
		</p>
		<button onclick="changeColors()">Change Colors</button>
	</div>
	<div class="section" id="entry-section">
		<p class="text">Please enter your name below</p>
		<form action="/SameWithPHP.php" method="post">
			<input id="name-entry" type="text" name="name">
			</br>
			<input id="name-submit" type="submit" name="Submit" value="Sign">
		</form>
	</div>
	<div class="section" id="history-section">
		<!--***************************************************
			Above the table add a p tag of the current time
			date('H:i:s')
		***************************************************-->
		<table>
			<tr>
				<th>
					Name
				</th>
				<th>
					Time
				</th>
			</tr>
			<!--Here is where the added PHP output will be-->
			<?php echo $tableHTML ?>
		</table>
	</div>
</body>
</html>