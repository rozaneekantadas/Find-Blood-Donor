<!DOCTYPE html>
<html>
<head>
	<title>Sign Up</title>

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

	$nameError = $emailError = $usernameError = $passwordError = "";
	$name = $email = $username = $password = "";

	if($_SERVER["REQUEST_METHOD"] == "POST"){

		if(empty($_POST["name"]) || empty($_POST["email"]) || empty($_POST["username"]) || empty($_POST["password"])){

				if(empty($_POST["name"])){
					$nameError = "Name is required";
				}

				if(empty($_POST["email"])){
					$emailError = "Email is required";
				}

				if(empty($_POST["username"])){
					$usernameError = "Username is required";
				}

				if(empty($_POST["password"])){
					$passwordError = "Password is required";
				}
		}
		else{
			$name = $_POST["name"];
			$email = $_POST["email"];
			$username = $_POST["username"];
			$password = $_POST["password"];

			$sql = "INSERT INTO signupinfo (name, email, username, password)
			 VALUES ('$name', '$email', '$username', '$password')";

			 if(mysqli_query($conn, $sql)){
			 	echo "<script> window.alert('Registration Successful'); </script>";
				echo "<script> window.location.assign('login.php'); </script>";
			 } else{
			 	echo "Error: ".mysql_error($conn);
			 }

			 mysqli_close($conn);
		}

		
	}

	?>

	<h1 align="center" class="a">Find Blood Donor</h1>

	<ul>
  <li><a href="index.php">Home</a></li>
  <li><a class="active" href="signup.php">Register Now</a></li>
  <li><a href="login.php">Log In</a></li>
  <li><a href="about.php">About</a></li>
</ul><br>


	<h2 align="center">Sign Up</h2><br>

	<center>
		<form action="<?php $_SERVER["PHP_SELF"]?>" method="post">
			<input type="text" name="name" placeholder="Name">
			<span class="error">* <?php echo $nameError; ?></span><br><br>
			<input type="text" name="email" placeholder="Email">
			<span class="error">* <?php echo $emailError; ?><br><br>
			<input type="text" name="username" placeholder="Username">
			<span class="error">* <?php echo $usernameError; ?><br><br>
			<input type="password" name="password" placeholder="Password">
			<span class="error">* <?php echo $passwordError; ?><br><br>
			<input type="submit" name="submit" value="Register"><br><br>
		</form>
	</center>


</body>
</html>