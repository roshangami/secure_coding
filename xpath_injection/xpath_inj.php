<form method="POST" action="xpath_inj.php">
	<input name="username" type="text" placeholder="Enter username" />
	<input name="password" type="password" placeholder="Enter password" />
	<input name="submit" type="submit" value="submit" />
</form>

<?php

# Prevention mechanism is to filterout the input and replace it with the white space character

function filter_xpath($input){
	$special_chars = array("*", "'", "(", ")", ";", ":", "[", "]", "{", "}", "$", "@");
	foreach($special_chars as $special){
		$input = str_replace($special, "", $input);
	}
	return $input;
}


if (isset($_POST["username"]) && isset($_POST["password"])){
	$username = filter_xpath($_POST["username"]);
	$password = filter_xpath($_POST["password"]);
	
	echo "Processing data: $username and $password <br>";
	$xml = simplexml_load_file("./xpath_data.xml");
	echo "XML file loaded successfully";
	$result = $xml->xpath("/heroes/hero[login='" . $username . "' and password='" . $password .  "']");

	if ($result){
		$message = "<p>Hello " . $result[0]->login . "!! Welcome to world of Hacking. Your words " . $result[0]->text . "</p>";
	} else {
		$message = "<p>Incorrect credentials</p>";
	}
	echo $message;
}
?>
