<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Edit Info</title>
	<style>
				input[type=submit]{
  background-color: #4CAF50;
  border: none;
  color: white;
  padding: 16px 32px;
  text-decoration: blink;
  margin: 4px 2px;
  cursor: pointer;
  font-size: 88%;
}

input[type=text], input[type=password], input[type=date]{
  background-color: white;
  background-position: 10px 10px;
  background-repeat: no-repeat;
  width: 250px;
  height:20px;
  font-size: 100%;
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

.active {
    background-color: #4CAF50;
}

body{
			font-size: 120%;
		}


	</style>
</head>
<body>

	<h1 align="center" class="a">Find Blood Donor</h1>

	<ul>
  <li><a href="donnerpage.php">Profile</a></li>
  <li><a class="active" href="editinfo.php">Edit Info</a></li>
  <li><a href="about.php">About</a></li>
</ul><br><br>

	<h2 align="center">Edit Info</h2>

	<?php

	$conn = mysqli_connect("localhost", "root", "", "databaseproject");

	if(!$conn){
		 die("Connection FailedL: ".mysqli_connect_error());
	}
	//else echo "Connected";

	$nameError = $emailError = $phoneError = $bloodError = $addressError = $donateError = "";
	$phone = $blood = $address = $donatedate = "";

	$userid = $_SESSION["id"];
	$name = $_SESSION["name"];
	$email = $_SESSION["email"];
	$donorphone = $_SESSION["phone"];
	$donorblood = $_SESSION["bloodgroup"];
	$donoraddress = $_SESSION["address"];
	$donordonatedate = $_SESSION["donatedate"];

	if($_SERVER["REQUEST_METHOD"] == "POST"){

		if(empty($_POST["name"]) || empty($_POST["email"]) || empty($_POST["phone"]) || empty($_POST["blood"]) || empty($_POST["address"]) || empty($_POST["donatedate"])){

				if(empty($_POST["name"])){
					$nameError = "Name is required";
				}

				if(empty($_POST["email"])){
					$emailError = "Email is required";
				}

				if(empty($_POST["phone"])){
					$phoneError = "Contact is required";
				}

				if(empty($_POST["blood"])){
					$bloodError = "Blood Group is required";
				}

				if(empty($_POST["address"])){
					$addressError = "Address is required";
				}

				if(empty($_POST["donatedate"])){
					$donateError = "Last Donate Date is required";
				}
		}

		else{
		$name = $_POST["name"];
		$email = $_POST["email"];
		$phone = $_POST["phone"];
		$blood = $_POST["blood"];
		$address = $_POST["address"];
		$donatedate = $_POST["donatedate"];

		$sql = "UPDATE donorinfo SET name = '$name', email = '$email', phone = '$phone', bloodgroup = '$blood', address = '$address', donatedate = '$donatedate' WHERE id = '$userid'";

			 if(mysqli_query($conn, $sql)){
			 	echo "<script> window.alert('Data is Updated'); </script>";
				echo "<script> window.location.assign('donnerpage.php'); </script>";
			 } else{
			 	echo "Error: ".mysql_error($conn);
			 }

			 mysqli_close($conn);
	}

	}
	

	?>


	

	<center>
		<form action="<?php $_SERVER["PHP_SELF"]?>" method="post">

			<input type="text" name="name" placeholder="Name" value="<?php echo $name; ?>">
			<span class="error">* <?php echo $nameError; ?></span><br><br>

			<input type="text" name="email" placeholder="Email" value="<?php echo $email; ?>">
			<span class="error">* <?php echo $emailError; ?></span><br><br>


			<input type="text" name="phone" placeholder="Phone" value="<?php echo $donorphone; ?>">
			<span class="error">* <?php echo $phoneError; ?><br><br>


			<input type="text" name="blood" placeholder="Blood Group" value="<?php echo $donorblood; ?>">
			<span class="error">* <?php echo $bloodError; ?><br><br>


			<textarea name="address" placeholder="Address" rows="5" cols="35"><?php echo $donoraddress; ?></textarea>
			<span class="error">* <?php echo $addressError; ?><br><br>

			<label>Last Donate Date:</label><br><br>
			<input type="date" id="donatedate" name="donatedate" value="<?php echo $donordonatedate; ?>">
			<span class="error">* <?php echo $donateError; ?><br><br>

			<input type="submit" name="submit" value="Edit Info"><br><br>
		</form>
	 </center>

	 

</body>
</html>