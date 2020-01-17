<?php
error_reporting(-1);//Вывод сообщений о всех возможных ошибках
require_once 'db.php';
require_once 'function.php';


$email = $_SESSION['email'];
$user_id = $_SESSION['user_id'];

//dd(requestData($_POST));
extract(requestData($_POST));

/* $pass_cur = htmlentities(trim($_POST['pass_cur'])); //Получаю старый пароль пользователя.
$password = htmlentities(trim($_POST['password'])); //Получаю новый пароль.
$pass_conf = htmlentities(trim($_POST['pass_conf'])); //Подтверждаю новый пароль. */
//$passHash = password_hash($password, PASSWORD_DEFAULT); //Хэширую пароль.

$validate = 1; // переменная состояния валидации

require_once 'validation/checkUser.php';
//Проверяю поля формы на пустоту
if (!empty($pass_cur) && !empty($password) && !empty($pass_conf)) {

    
    $result_user = check_user($pdo, $email); //Передаю параметры функции, что бы получить существующего пользователя

    //Если введённый пароль совпадает с паролем из сессии
    if ($result_pass = password_verify($pass_cur, $result_user['password'])) {

        //Проверка пароля на количество символов
        if (strlen($password) < 6) {

            $_SESSION['passErr'] = 'Пароль меньше 6 символов';// Сообщение об ощибке
            redirect('profile.php');                 //Редирект обратно
        } 

        if ($password !== $pass_conf) {

            $_SESSION['passErr'] = 'Пароли не совпадают';// Сообщение об ощибке
            redirect('profile.php');            //Редирект обратно
        }
    } else {
        $_SESSION['passErr'] = 'Вы ввели неверный пароль'; // Сообщение о неверном пароле
        redirect('profile.php');                 // Редирект на профиль
    }

   
    
    //Вставляем введенныую пользователем информацию в БД.
        $sql = 'UPDATE users SET password = :password WHERE id = :id'; //Подготавливаю SQL запрос с нужными колонками таблицы
        $values = [':password' => $passHash, ':id' => $user_id];       //Передаю полученные значения
        $stmt = $pdo->prepare($sql);                                   //Подготовленный запрос
        $stmt->execute($values);                                       //Получаю обновлённые значения

        $_SESSION['passSucces'] = 'Пароль обновлён'; // Сообщение об успешном изменении пароля
        redirect('profile.php');
} else {
    $_SESSION['passErr'] = 'Поля пустые, заполните их'; // Сообщение о неверном пароле
    redirect('profile.php');
}
