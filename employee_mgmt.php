
<?php
ob_start();
session_start();
//var_dump($_SESSION);
if ($_SESSION['auth'] != 'wdfdfggfgfgfg'){
	header ("Location: login.php");
}


echo '<div id="top"> Welcome, <b>'.$_SESSION['username'].'</b>';
echo '<a href="logout.php">Log Out</a><br><br></div>';

//INSERT data from registration form into database

//Connect to database

$dbh = new PDO("mysql:host=localhost:8889;dbname=webd166", 'root', 'root');
//echo 'connected to webd166<br>';

$status = 'Register';
if (isset($_GET['deleteid'])) {
	$deleteid = $_GET['deleteid'];
}
if (isset($_GET['editid'])) {
	$editid = $_GET['editid'];}

if (isset($deleteid)) {
    $delsql = $dbh->prepare("delete from tbemployees where id = '$deleteid';");
	$delsql->execute();
	//echo "<h4>Record Deleted for employeeid = $deleteid.</h4>";
}
if (isset($_GET['viewid'])) {
	$viewid = $_GET['viewid'];
	// select a particular user by id
    $viewsql = $dbh->prepare("SELECT * FROM tbemployees WHERE id = '$viewid';");
    $viewsql->execute();
	$viewrow = $viewsql->fetch();
	$disfullname = $viewrow[1];
	$disgender = $viewrow[2];
	$disemptitle = $viewrow[3];
	$dishiredate = $viewrow[4];
	$discomments = $viewrow[5];
	//echo "$disfullname - $disgender - $dishiredate - $discomments";


	}
if (isset($_POST['submit']) && $_POST['submit'] == 'Register'){
	//get the data and insert it!!!
	$fullname = $_POST['fullname'];
	$gender = $_POST['gender'];
	$emptitle = $_POST['emptitle'];
	$hiredate = $_POST['year'].'-'. $_POST['month'].'-'.$_POST['day'];
	$comments = $_POST['comments'];

	//tbemployees is a table name created in phpMyAdmin for databases webd166

	$insert = $dbh->prepare("insert into tbemployees (
	fullname,gender,title,hire_date,comments) values (
	'$fullname','$gender','$emptitle','$hiredate','$comments')");

	$insert->execute();
	//print_r($insert->errorInfo());
	echo "<h4>Record added for employee $fullname !</h4>";
}

if (isset($_POST['submit']) && $_POST['submit'] == 'Update'){
	//get the data and insert it!!!
	$fullname = $_POST['fullname'];
	$gender = $_POST['gender'];
	$emptitle = $_POST['emptitle'];
	$month = sprintf("%02d", $_POST['month']);
	$day = sprintf("%02d", $_POST['day']);
	$hiredate = $_POST['year'].'-'. $month.'-'.$day;
	$comments = $_POST['comments'];

	//tbemployees is a table in phpMyAdmin for databases webd166

	$updatesql = $dbh->prepare("UPDATE tbemployees SET fullname = '$fullname', gender = '$gender', title = '$emptitle', hire_date = '$hiredate', comments = '$comments!' WHERE id = '$editid';");

	$updatesql->execute();
	//print_r($updatesql->errorInfo());
	echo "<h4> Record Updated for $fullname!</h4>";
}

if (isset($editid)) {
    $editsql = $dbh->prepare("select fullname, gender, title, hire_date, comments from tbemployees where id = '$editid'");
	$editsql->execute();
	$editrow = $editsql->fetch();
	$upfullname = $editrow[0];
	$upgender = $editrow[1];
	$upemptitle = $editrow[2];
	$upyear = substr($editrow[3],0,4);
	$upmonth = substr($editrow[3],5,2);
	$upday = substr($editrow[3],8,2);
	$upcomments = $editrow[4];
	$status = 'Update';
	//print_r($editsql->errorInfo());
	echo '<br><a href="employee_mgmt.php"> Click to go back to add mode</a>';
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Employee Management</title>
	<link rel="stylesheet" href="css/main.css">
</head>
<body>
<h1>List of Employees</h1>
<section id="listEmps">
<?php
//display records ... just the name

$display = $dbh->prepare("SELECT id, fullname FROM tbemployees ORDER BY id DESC");
$display->execute();
while ($row = $display->fetch()){
	//$fullname = $row['fullname']; or
	$id = $row[0];
	$fullname = $row[1];
	$details = '';

	if (isset($viewid) && $fullname == $disfullname) {
		$details = $disgender.', '.$disemptitle.', '.$dishiredate.', '.$discomments;
	}
	echo '<span class="employeeName">'.$fullname.'</span>
	<a href="employee_mgmt.php?viewid='.$id. '">View</a> '.
	'<a href="employee_mgmt.php?deleteid='.$id. '">Delete</a> '.
	'<a href="employee_mgmt.php?editid='.$id. '">Edit</a><br>';
	if ($details != '') echo '<div class="record">'.$details.'</div><br>';

}
?>

</section>

<!--need to prepopulate the inputs with the selected record if edit is clicked. -->
<h1>
	<?php
		if (empty($editid)) {
			echo 'Add new employee';
		} else {
			echo 'Edit selected employee';
		}
	?>
</h1>
<form action ="employee_mgmt.php?
<?php
	echo $_SERVER['QUERY_STRING']; //it is $editid if edit
?>" method="POST">
	<fieldset><legend>Employee Registration form</legend>
		<label for="fullname">Name:</label>
		<input type="text" name="fullname" id="fullname" value="<?php if (isset($upfullname)) {echo $upfullname;} ?>" required>


	  <fieldset><legend>Gender:</legend> <ul>
	   		  <!--<li>
	   		  	<p>Gender:</p>
	   		  </li>	-->
	   			  <li>
	   	   			<label for="male"> Male
	   			<input type="radio" name="gender" id="male" value="Male" <?php
	   			   			if (isset($upgender) && $upgender == 'Male') {
	   							echo ' checked="checked" ';} ?>></label>
	   			  </li>
	   			  <li>
	   			   	<label for="female">Female <input type="radio" name="gender" value="Female" <?php
	   					if (isset($upgender) && $upgender == 'Female') {
	   					 echo ' checked="checked" ';} ?>></label>
	   			  </li>
	   			</ul>	</fieldset>

		<label for="emptitle">Title:</label>
		<input type="text" name="emptitle" id="emptitle" value="<?php if (isset($upemptitle)) {echo $upemptitle;} ?>" required>

		<fieldset><legend>Hire Date:</legend>
		<!--<input type="text" name="hiredate" id="hiredate" value="<?php if (isset($upfullname)) {echo $uphiredate;} ?>" required>-->
	<?php
		 $month = [
			1 =>'January',
				'February',
				'March',
				'April',
				'May',
				'June',
				'July',
				'August',
				'September',
				'October',
				'November',
				'December'
				];
		$days = range(1,31);
		$years = range(date('Y'), 1900);

		echo '<ul>';
			echo '<li>
					<label for="month">Month</label>
					<select name="month" id="month">';
					foreach ($month as $key => $value) {
						echo "<option value=\"$key\"";
					    if (isset($upmonth) && $upmonth == sprintf("%02d", $key) ) {echo "  selected=\"selected\"";};
						echo ">$value</option>";
					}

			echo '</select></li>';


			echo '<li>
					<label for="day">Day</label>
					<select name="day" id="day">';
					foreach ($days as $value) {
						echo "<option value=\"$value\"";
					    if (isset($upday) && $upday == $value) {echo "  selected=\"selected\"";};
						echo ">$value</option>";
					}

			echo '</select></li>';


			echo '<li>
					<label for="month">Year</label>
					<select name="year" id="year">';
					foreach ($years as $value) {
						echo "<option value=\"$value\"";
					    if (isset($upyear) && $upyear == $value) {echo "  selected=\"selected\"";};
						echo ">$value</option>";
					}
			echo '</select></li>';
		echo '</ul>';
	?>
	</fieldset>

		<label for="comments">Comments:</label>
		<textarea name="comments" id="comments"><?php if (isset($upcomments)) {echo $upcomments;} ?></textarea>

		<input type="submit" name ="submit" value="<?php echo $status;?>">
	</fieldset>

</form>
</body>
</html>
