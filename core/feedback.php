<?php
include "connection.php";

$name = trim($_POST['name']);
$email = trim($_POST['email']);
$date = trim($_POST['date']);
$time = trim($_POST['time']);

$fbObj = new FeedbackRec;

$fbObj->feedbackGen($name, $email, $date, $time, $host, $uname, $pass, $database);

class FeedbackRec
{
    // php dockblocker перестал нормально работать, прошу извинить.

    // функция получает переданные через POST имя, email, дату и время, а также
    // данные для подключения к БД. Проводит проверку на существование, вызывает
    // функции setFeedback и letterGenerator, проверяет их выполнение.
    public function feedbackGen($name, $email, $date, $time, $host, $uname, $pass, $database)
    {
        if (($name && $email && $date && $time) == true) {

            $result = $this->setFeedback($name, $email, $date, $time, $host, $uname, $pass, $database);
            $success = $this->letterGenerator($name, $email, $date, $time);

            if ($result && $success == true) {
                echo "Готово!";
            } else {
                die("Что-то не так!");
            }
        } else {
            die("Недостаточно параметров!");
        }
    }

    // функция получает переданные через POST имя, email, дату и время, а также
    // данные для подключения к БД. Производит подготовку запросов к БД и выполняет их. Возвращает true в случае
    // успешного выполнения запроса
    private function setFeedback($name, $email, $date, $time, $host, $uname, $pass, $database)
    {

        try {
            $pdo = new PDO('mysql:host=' . $host . ';' . 'dbname=' . $database, $uname, $pass);
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage();
            die();
        }

        $query = "INSERT INTO feedbacks VALUES (NULL, :name, :email, :date, :time)";
        $params = [
            ':name' => $name,
            ':email' => $email,
            ':date' => $date,
            ':time' => $time,
        ];
        $stmt = $pdo->prepare($query);
        $result = $stmt->execute($params);
        return $result;
    }

    // функция получает переданные через POST имя, email, дату и время,
    // производит формирование и отправку письма пользователю с указанным электронным адресом
    // возвращает true в случае успешной отправки письма
    private function letterGenerator($name, $email, $date, $time)
    {
        $message = $name . " - " . $email . " - " . $date . " - " . $time;

        $subject = "=?utf-8?B?" . base64_encode("Обратная связь iFORA") . "?=";
        $headers = "From: $email\r\nReply-to: $email\r\nContent-type: text/html; charset=utf-8\r\n";

        $success = mail("sergeyrakov_93@mail.ru", $subject, $message, $headers);
        return $success;
    }
}
