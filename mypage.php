</body>
</html>

<!DOCTYPE html>
<html>
<body>
<h1>Employees database</h1>
<?php
	$servername = "localhost";
	$username = "root";
	$password = "*******";
	$db = "employees";
	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $db);
	// Check connection
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	$sql = 'SELECT * FROM departments';
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		echo "The various departments are <ul>"; 
		while($row = $result->fetch_assoc()) {
			echo "<li>", $row["dept_name"],"</li>";
		}
		echo "</ul>";
	} else {
		echo "Connection to database failed";
	}
?>
<form action="mypage.php" method="post">
<h3> For getting information on employees in a department </h3>
Enter Department Name <input type="text" name="deptname">
<input type="submit" name="submit">
</form>
<form action="mypage.php" method="post">
<h3> For getting gender ratio of a department </h3>
Enter Department Name <input type="text" name="deptname">
<input type="submit" name="submit1">
</form>
<?php
	if(isset($_POST["submit"])){
		$sql = 'SELECT dept_no FROM departments WHERE dept_name="' . $_POST["deptname"] . '"';
		$result = $conn->query($sql);
		$x = $result->fetch_assoc()["dept_no"];
		if ($result->num_rows > 0) {
			$sql = 'SELECT * FROM employees WHERE emp_no IN (SELECT emp_no FROM dept_emp WHERE dept_no="'. $x .'") ORDER BY hire_date'; 
			$result = $conn->query($sql);
			echo "<table><tr><th>Employee ID</th><th>Name</th><th>Start Date</th></tr>";
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					echo "<tr><td>",$row["emp_no"],"</td><td>",$row[first_name]," ",$row[last_name],"</td><td>",$row["hire_date"],"</td></tr>";
				}
				echo "</table>";
			} else {
				echo "No employees in the department";
			}
		}else{
			echo "No such department";
		}
	}				
	if(isset($_POST["submit1"])){
		$sql = 'SELECT dept_no FROM departments WHERE dept_name="' . $_POST["deptname"] . '"';
		$result = $conn->query($sql);
		$x = $result->fetch_assoc()["dept_no"];
		if ($result->num_rows > 0) {
			$sql = 'SELECT count(*) AS males FROM employees WHERE emp_no IN (SELECT emp_no FROM dept_emp WHERE dept_no="'. $x .'") AND gender="M"'; 
			$sql1 = 'SELECT count(*) AS females FROM employees WHERE emp_no IN (SELECT emp_no FROM dept_emp WHERE dept_no="'. $x .'") AND gender="F"'; 
			$result = $conn->query($sql);
			$result1 = $conn->query($sql1);
			echo "<h4>",$_POST["deptname"],"</h4>";
			echo "<table><tr><th>Number of Males</th><th>Number of Females</th></tr>";
			echo "<tr><td>", $result->fetch_assoc()["males"],"</td><td>",$result1->fetch_assoc()["females"]."</td></tr>";
		}else{
			echo "No such department";
		}
	}	
	$conn->close();
?>


</body>
</html>
