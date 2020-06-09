<?php
session_start();
?>

<?php 

	$today_date = date("Y-m-d");
	$end_date = strtotime($today_date);

	$conn = mysqli_connect("localhost", "root", "", "databaseproject");

	if(isset($_GET["searchtext"])){
		$value = $_GET["searchtext"];
		$sql = "SELECT name, email, phone, bloodgroup, address, donatedate FROM donorinfo WHERE CONCAT(name, email, phone, bloodgroup, address, donatedate) LIKE '%".$value."%'";
		$result = mysqli_query($conn, $sql);
	}else{
		$sql = "SELECT name, email, phone, bloodgroup, address, donatedate FROM donorinfo";
		$result = mysqli_query($conn, $sql);
	}

	function statusInfo($start_date, $end_date){
		$cal = ($end_date - $start_date)/60/60/24;

		if($cal >= 120){
			$status = "Available";
		}else{
			$status = "Unavailable";
		}

		return $status;
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style>

		table{
			font-size: 100%;
		}
		table th{
			background-color: green;
			color: white;
		}
		table td{
			
		}
		input[type=submit]{
		  background-color: #333;
		  border: none;
		  color: white;
		  padding: 14px 16px;
		  text-decoration: blink;
		  cursor: pointer;
		  font-size: 93%;
		}

		input[type=submit].a{
		  background-color: #4CAF50;
		  border: none;
		  color: white;
		  padding: 16px 32px;
		  text-decoration: blink;
		  margin: 4px 2px;
		  cursor: pointer;
		  font-size: 95%;
		}

		input[type=text] {
		  background-color: white;
		  background-position: 10px 10px;
		  background-repeat: no-repeat;
		  width: 350px;
		  height:35px;
		  font-size: 110%;
		  padding-left: 10px;
		}

		h1.a{
					color: red;
				}

				ul {
		    list-style-type: none;
		    margin: 0;
		    padding: 0;
		    overflow: hidden;
		    background-color: #333;
		}

		li {
		    float: left;
		}

		li a {
		    display: block;
		    color: white;
		    text-align: center;
		    padding: 14px 16px;
		    text-decoration: none;
		}

		li a:hover:not(.active) {
		    background-color: #111;
		}

		li input:hover:not(.active) {
		    background-color: #111;
		}

		.active {
		    background-color: #4CAF50;
		}

		body{
					font-size: 120%;
				}

				td:last-child {
		  font-weight: bold;
		  text-align: center;
		}

	</style>
</head>
<body>

	<h1 align="center" class="a">Find Blood Donor</h1>

	<ul>
  <li><a class="active" href="donnerpage.php">Profile</a></li>

  <?php 
  $id = $_SESSION["id"];
  $connn = mysqli_connect("localhost", "root", "", "databaseproject");
  $sqll = "SELECT phone, bloodgroup, address, donatedate FROM donorinfo WHERE id = '$id'";
	$resultis = mysqli_query($connn, $sqll);

	if(mysqli_num_rows($resultis) == 0){
		echo "<li><a href='addinfo.php'>Add Info</a></li>";
	}
	else{
		echo "<li><a href='editinfo.php'>Edit Info</a></li>";
	}

  ?>
  <li><form action="<?php $_SERVER["PHP_SELF"]; ?>" method = "post">
		<input type="submit" name="logout" value="Log Out">
	</form></li>
  <li><a href="about.php">About</a></li>
</ul><br><br>

	<?php
	echo "<h3>Welcome, " .$_SESSION["name"]."</h3>";
	?>

	<h1 align="center">Donor Information</h1>

	<center>
		<form action="<?php $_SERVER["PHP_SELF"]; ?>" method = "get">
		<input type="text" name="searchtext" placeholder="Enter Blood Group">
		<input class="a" type="submit" name="search" value="Search">
	</form>
		
	</center><br>

	<TABLE border = '1' align = 'center' cellpadding="10">

		<tr>
			<th>Name</th>
			<th>Email</th>
			<th>Phone</th>
			<th>Blood Group</th>
			<th>Address</th>
			<th>Last Donate Date</th>
			<th>Status</th>
		</tr>


	<?php

	

	if(mysqli_num_rows($result)> 0){

		while($row  = mysqli_fetch_assoc($result)){

			$donatedate = $row["donatedate"];
			$start_date = strtotime($donatedate);
			$status = statusInfo($start_date, $end_date);

			if($status == "Available"){
				$color = 'green';
			}else{
				$color = 'red';
			}

			echo "<tr>
			<td>".$row["name"]."</td>
			<td>".$row["email"]."</td>
			<td>".$row["phone"]."</td>
			<td>".$row["bloodgroup"]."</td>
			<td>".$row["address"]."</td>
			<td>".$row["donatedate"]."</td>
			<td style='color: ".$color."'>".$status."</td>
			</tr>";
		}
	} else{
		echo "<script> window.alert('No Data Found'); </script>";
		echo "<script> window.location.assign('donnerpage.php'); </script>";
	}
	?>

</TABLE>

	<?php

	$conn = mysqli_connect("localhost", "root", "", "databaseproject");

	if(!$conn){
		 die("Connection Failed: ".mysqli_connect_error());
	}
	//else echo "Connected";

	$id = $_SESSION["id"];

	$sql = "SELECT phone, bloodgroup, address, donatedate FROM donorinfo WHERE id = '$id'";
	$result = mysqli_query($conn, $sql);

	if(mysqli_num_rows($result)>0){

		$row =  mysqli_fetch_assoc($result);
		$_SESSION["phone"] = $row["phone"];
		$_SESSION["bloodgroup"] = $row["bloodgroup"];
		$_SESSION["address"] = $row["address"];
		$_SESSION["donatedate"] = $row["donatedate"];
	}else{
		// echo "<script> window.alert('No Data Found'); </script>";
	}
	?>


	<?php

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		session_unset();
		session_destroy();

		echo "<script> window.alert('Log Out'); </script>";
		echo "<script> window.location.assign('login.php'); </script>";
	}
	?>


</body>
</html>