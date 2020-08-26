<h3>Login</h3>
<form method="POST" action="sql_inj.php">
        <input name="username" type="text" placeholder="Enter username" requried/>
        <input name="password" type="password" placeholder="Enter password"  requried/>
        <input name="submit" type="submit" value="Login" />
</form>

<?php




function filter_inputs($input){
	$special_chars = ["'", ";", "{", ")"];  # list of characters which we need to filter out from the user input
	foreach($special_chars as $char){
		$input = str_replace($char, "", $input);
	}
    return $input;
}


$servername = "localhost";
$username = "admin";
$password = "admin!";
$db = "users";

// Create database connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";


// validate username and password
if (isset($_POST['username']) && isset($_POST['password'])){
#	$username = $_POST['username'];  # username without filter
#	$password = $_POST['password'];  # password without filter
	
	$username = filter_input($_POST['username']);
	$password = filter_input($_POST['password']);
	
	$qry = "select * from login where username='".$username."' and password='".$password."';";


	$result = $conn->query($qry);

	if($result->num_rows > 0){
		$details = $result->fetch_assoc();
		echo "<br>Login successful, Welcome <b>". $details['username']."</b>";
	} else {
		echo '<br>login failed';
	}

}

$conn->close();
?>
