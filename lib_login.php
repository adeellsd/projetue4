<?php
	function get_db_infos()
	{
		return array(
			"srv" => "localhost",
			"usr" => "root",
			"pwd" => "",
			"db" => "alexcloud"
		);
	}

	function search_user($username)
	{
		$dbi = get_db_infos();
		$conn = new mysqli($dbi["srv"], $dbi["usr"], $dbi["pwd"], $dbi["db"]);
		if (! $conn->connect_error) {
			$sql = "SELECT * FROM `users` WHERE USERNAME = ?";
			$stmt = $conn->prepare($sql);
			$stmt->bind_param("s", $username);
			$stmt->execute();
			$result = $stmt->get_result();

			if ($result->num_rows == 1) {
				$row = $result->fetch_assoc();
				return $row;
			}
		}

		return false;
	}

	function create_user($username, $hashed_password, $description)
	{
		if(! search_user($username))
		{
			$dbi = get_db_infos();
			$conn = new mysqli($dbi["srv"], $dbi["usr"], $dbi["pwd"], $dbi["db"]);
			if(! $conn->connect_error)
			{
				$sql = "INSERT INTO users (USERNAME, PASSWORD, DESCRIPTION, admin) VALUES (?, ?, ?, 0)";
				$stmt = $conn->prepare($sql);
				$stmt->bind_param("sss", $username, $hashed_password, $description);
				$stmt->execute();
	
				$pcontent = file_get_contents("./p/template.php");
				$towrite = str_replace("####USERNAME####", $username, $pcontent);
	
				file_put_contents("./p/".$username.".php", $towrite);
				mkdir("./files/".$username);
	
				return true;
			}
		}
	
		return false;
	}
	

	function delete_user($username)
	{
		if (search_user($username)) {
			$dbi = get_db_infos();
			$conn = new mysqli($dbi["srv"], $dbi["usr"], $dbi["pwd"], $dbi["db"]);
			if (! $conn->connect_error) {
				$sql = "DELETE FROM `users` WHERE USERNAME = ?";
				$stmt = $conn->prepare($sql);
				$stmt->bind_param("s", $username);
				$stmt->execute();

				return true;
			}
		}

		return false;
	}

	function login_user($username, $password)
	{
		if ($user = search_user($username)) {
			if (password_verify($password, $user["PASSWORD"])) {
				session_start();
				$_SESSION["username"] = $user["USERNAME"];
				$_SESSION["admin"] = $user["admin"];
				return true;
			}
		}

		return false;
	}


	function logout_user()
	{
		session_start();
		session_unset();
		session_destroy();
	}

	function set_admin($username, $value)
	{
		if(search_user($username))
		{
			$dbi = get_db_infos();
			$conn = new mysqli($dbi["srv"], $dbi["usr"], $dbi["pwd"], $dbi["db"]);
			if(! $conn->connect_error)
			{
				$sql = "UPDATE `users` SET admin = ".$value." WHERE USERNAME = '".$username."';";
				$result = $conn->query($sql);

				return true;
			}
		}

		return false;
	}



























































































?>
