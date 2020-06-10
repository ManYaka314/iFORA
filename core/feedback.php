<?php
include "connection.php";
$name = $_POST['name'];
$email = $_POST['email'];
$date = $_POST['date'];
$time = $_POST['time'];

$message = $name . " - " . $email . " - " . $date . " - " . $time;

$subject = "=?utf-8?B?" . base64_encode("Обратная связь iFORA") . "?=";
$headers = "From: $email\r\nReply-to: $email\r\nContent-type: text/html; charset=utf-8\r\n";

$success = mail("sergeyrakov_93@mail.ru", $subject, $message, $headers);

if (($name && $email && $date && $time) == true) {
    $mysqli = new mysqli($host, $uname, $pass, $database);

    $result = $mysqli->query("INSERT INTO feedbacks VALUES (NULL,'$name','$email','$date','$time')");

    if ($result && $success == true) {
        echo "Done!";
    }
}
