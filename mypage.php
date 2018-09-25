</body>
</html>

<!DOCTYPE html>
<html>
<body>
<h1>query</h1>
<form action="mypage.php" method="post">
Enter Department Name <input type="text" name="deptname">
<input type="submit" name="submit">
</form>
<?php
	$a = 5;
	//print_r(get_loaded_extensions());
	//echo extension_loaded("mongodb") ? "loaded\n" : "not loaded\n";
	//phpinfo();
	//$mng = new MongoClient();
	//$mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");
	//$stats = new MongoDB\Driver\Command(["dbstats" => 1]);
	//$res = $mng->executeCommand("employees", $stats);
	//$query = new MongoDB\Driver\Query([]);
	//$rows = $mng->executeQuery("employees.employees", $query);
	//$stats = current($res->toArray());

    	//print_r($stats);
	$servername = "localhost";
	$username = "root";
	$password = "momnaninana";
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
		while($row = $result->fetch_assoc()) {
			echo $row["dept_name"],"\n";
		}
	} else {
		echo "0 results";
	}
	echo "Connected successfully";
	echo "I AM ECHO";
	if(isset($_POST["submit"])){
		echo "u submitted",$_POST["deptname"] ;
		$sql = 'SELECT dept_no FROM departments WHERE dept_name="' . $_POST["deptname"] . '"';
		echo $sql;
		$result = $conn->query($sql);
		//echo $result->fetch_assoc()["dept_no"];
		$x = $result->fetch_assoc()["dept_no"];
		echo $x;
		if ($result->num_rows > 0) {
			$sql = 'SELECT * FROM employees WHERE emp_no IN (SELECT emp_no FROM dept_emp WHERE dept_no="'. $x .'") ORDER BY hire_date'; 
			//$sql = 'SELECT * FROM dept_emp WHERE dept_no="'. $x . '" ORDER BY from_date';
			echo $sql;
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
	
	$conn->close();
?>


</body>
</html>
