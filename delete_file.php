<?php
	require("forced.php");

	if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
		die("Method not allowed");
	}

	session_start();
	if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
		die("Invalid CSRF token");
	}

	$file = basename($_POST["file"]);
	if (!preg_match('/^[a-zA-Z0-9._-]+$/', $file)) {
		die("Nom de fichier invalide");
	}

	$filepath = "/var/www/html/files/".$__connected["USERNAME"]."/".$file;

	if (file_exists($filepath)) {
		unlink($filepath);
		unlink($filepath.".alexdescfile");
	}

	header("Location: /");
?>
