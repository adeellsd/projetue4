<?php

session_start();
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