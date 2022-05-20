<?php


require("lib/helpers.php");

$_SESSION["csrf_token"] = md5(uniqid(mt_rand(), true));

view("index");
