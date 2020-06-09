<?php 

	$today_date = date("Y-m-d");
	$end_date = strtotime($today_date);

	$conn = mysqli_connect("localhost", "root", "", "databaseproject");

	if(isset($_POST["searchtext"])){
		$value = $_POST["searchtext"];
		$sql = "SELECT name, email, phone, bloodgroup, address, donatedate FROM donorinfo WHERE CONCAT(name, email, phone, bloodgroup, address, donatedate) LIKE '%".$value."%'";
		$result = mysqli_query($conn, $sql);
	}else{
		$sql = "SELECT name, email, phone, bloodgroup, address, donatedate FROM donorinfo";
		$result = mysqli_query($conn, $sql);
	}

	function statusInfo($start_date, $end_date){
		global $status;

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

		body{
			font-size: 120%;
		}
		h1.a{
			color: red;
		}

		input[type=submit]{
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


					td:last-child {
			  font-weight: bold;
			  text-align: center;
			  color: black;
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

			.active {
			    background-color: #4CAF50;
			}

	</style>
	<title>Find Blood Donor</title>
</head>
<body>

	<h1 align="center" class="a">Find Blood Donor</h1>

	<ul>
  <li><a class="active" href="index.php">Home</a></li>
  <li><a href="signup.php">Register Now</a></li>
  <li><a href="login.php">Log In</a></li>
  <li><a href="about.php">About</a></li>
</ul><br><br>

	<center>
		<form action="<?php $_SERVER["PHP_SELF"]; ?>" method = "post">
		<input type="text" name="searchtext" placeholder="Enter Blood Group">
		<input type="submit" name="search" value="Search">
	</form>
		
	</center>

	<h1 align="center">Donor Information</h1>

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
		echo "<script> window.location.assign('index.php'); </script>";
	}
	?>

</TABLE>
	
</body>
</html>