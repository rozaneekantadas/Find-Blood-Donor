<?php
session_start();
?>


<!DOCTYPE html>
<html>
<head>
	<title>Log In</title>
	<style>
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

input[type=text], input[type=password]{
  background-color: white;
  background-position: 10px 10px;
  background-repeat: no-repeat;
  width: 250px;
  height:20px;
  font-size: 100%;
  padding-left: 10px;
}

body{
			font-size: 120%;
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


	</style>
</head>
<body>

	<?php

	$conn = mysqli_connect("localhost", "root", "", "databaseproject");

	if(!$conn){
		 die("Connection FailedL: ".mysqli_connect_error());
	}
	//else echo "Connected";

	$usernameError = $passwordError = "";
	$username = $password = "";

	if($_SERVER["REQUEST_METHOD"] == "POST"){

		if(empty($_POST["username"]) || empty($_POST["password"])){

				if(empty($_POST["username"])){
					$usernameError = "Username";
				}

				if(empty($_POST["password"])){
					$passwordError = "Password";
				}
		}
		else{
			$username = $_POST["username"];
			$password = $_POST["password"];

			$sql = "SELECT id, name, email, username, password FROM signupinfo";
			$result = mysqli_query($conn, $sql);

			if(mysqli_num_rows($result)>0){
				while($row = mysqli_fetch_assoc($result)){

					if($row["username"] == $username && $row["password"] == $password){
						$_SESSION["id"] = $row["id"];
						$_SESSION["name"] = $row["name"];
						$_SESSION["email"] = $row["email"];
						echo "<script> window.alert('Log In Successful'); </script>";
						echo "<script> window.location.assign('donnerpage.php'); </script>";
					} else{
						$msg = "Wrong Username or Password";
					}

				}
			}

			 mysqli_close($conn);

			 if(isset($msg)){
			 	echo "<script> window.alert('Wrong Username or Password'); </script>";
			 }
		}
		
	}

	?>

	<h1 align="center" class="a">Find Blood Donor</h1>

	<ul>
  <li><a href="index.php">Home</a></li>
  <li><a href="signup.php">Register Now</a></li>
  <li><a class="active" href="login.php">Log In</a></li>
  <li><a href="about.php">About</a></li>
</ul><br>

	<h2 align="center">Log In</h2><br>

	<center>
		<form action="<?php $_SERVER["PHP_SELF"]?>" method="post">
			<input type="text" name="username" placeholder="Username">
			<span class="error">* <?php echo $usernameError; ?><br><br>
			<input type="password" name="password" placeholder="Password">
			<span class="error">* <?php echo $passwordError; ?><br><br>
			<input type="submit" name="submit" value="Log In"><br><br>
		</form>
	</center>

</body>
</html>