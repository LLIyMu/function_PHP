<?php
require_once 'db.php';

$date = date("Y-m-d"); //Получаем текущую дату (Год, месяц, день)
$text = htmlentities(trim($_POST['text'])); //Получаем текст из комментария, избавляемся от пробелов с его концов, предотвращаем возможность скриптовой атаки
$user_id = (int) htmlentities(trim($_POST['user_id'])); //Получаю имя пользователя.
$skip = 0;

if (!empty($_POST['text'])) {

    //Вставляем введенныую пользователем информацию в БД.
    $sql = 'INSERT INTO `form` (`user_id`, `text`, `date`, `skip`) VALUES (:user_id, :text, :date, :skip)';
    $values = ['user_id' => $user_id, 'text' => $text, 'date' => $date, 'skip' => $skip];
    $statement = $pdo->prepare($sql);
    $statement->execute($values);
    //Добавление алерта, для комментария
    $_SESSION['alert'] = 'Комментарий успешно добавлен';
} else{
    $_SESSION['text'] = 'Введите ваше сообщение';
}
header("Location: /");//Перенаправление на index.php
exit;