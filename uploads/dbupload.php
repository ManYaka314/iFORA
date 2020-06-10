<?php
include "./../core/connection.php";
$link = mysqli_connect($host, $uname, $pass, $database);

$query1 = mysqli_query($link, "SELECT * FROM feedbacks");
$myrow = mysqli_fetch_array($query1);

require_once './../PHPExcel/Classes/PHPExcel.php';

$phpexcel = new PHPExcel();
$page = $phpexcel->setActiveSheetIndex(0);
$page->setCellValue("A1", "id");
$page->setCellValue("B1", "name");
$page->setCellValue("C1", "email");
$page->setCellValue("D1", "date");
$page->setCellValue("E1", "time");

$s = 2;
while ($row = mysqli_fetch_array($query1)) {
    $s++;
    $page->setCellValue("A$s", $row['id']);
    $page->setCellValue("B$s", $row['name']);
    $page->setCellValue("C$s", $row['email']);
    $page->setCellValue("D$s", $row['date']);
    $page->setCellValue("E$s", $row['time']);

}
$page->setTitle("Записи");
$objWriter = PHPExcel_IOFactory::createWriter($phpexcel, 'Excel2007');
$objWriter->save("записи.xlsx");
echo "Сохранено в папку uploads!";
