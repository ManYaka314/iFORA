<?php
include "./../core/connection.php";
header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="записи.csv";');

$conn = new mysqli($host, $uname, $pass, $database);

$sql = "SELECT * FROM feedbacks";
$result = $conn->query($sql);

$fp = fopen('php://output', 'w');

while ($row = $result->fetch_assoc()) {
    fputcsv($fp, $row, ";");
}

$conn->close();
