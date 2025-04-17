<?php

session_start();
if (!isset($_SESSION["initialized"])) {
	session_regenerate_id(true);
	$_SESSION["initialized"] = true;
}

$__connected = array(
    "USERNAME" => $_SESSION["username"] ?? null,
    "ADMIN" => $_SESSION["admin"] ?? 0
);

if (! $__connected["USERNAME"]) {
    if (! isset($LOGIN_PAGE)) {
        header("Location: /login.php");
        die();
    }
}

?>