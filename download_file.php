<?php
	require("forced.php");

	if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
		die("Méthode non autorisée");
	}

	if (!isset($_GET["file"])) {
		die("Fichier non spécifié");
	}

	$file = basename($_GET["file"]);
	if (!preg_match('/^[a-zA-Z0-9._-]+$/', $file)) {
		die("Nom de fichier invalide");
	}

	$filepath = "/var/www/html/files/".$__connected["USERNAME"]."/".$file;

	if (file_exists($filepath)) {
		header("Content-Description: File Transfer");
		header("Content-Type: application/octet-stream");
		header("Content-Disposition: attachment; filename=".$file);
		header("Content-Length: ".filesize($filepath));

		flush();
		readfile($filepath);
		exit();
	}

	die("Fichier introuvable");
?>
