<?php
$host = "localhost";
$uname = "root";
$pass = "";
$database = "ifora";
$connection = mysqli_connect($host, $uname, $pass)
or die("Database Connection Failed");

$result = mysqli_select_db($connection, $database)
or die("database cannot be selected");
