<?php
error_reporting(-1);//Вывод сообщений о всех возможных ошибках
require_once 'db.php';
require_once 'function.php';


$email = $_SESSION['email'];
$user_id = $_SESSION['user_id'];

//dd(requestData($_POST));
//вызываю функцию которая обрабатывает массив $_POST применяется htmlentities и trim,
// туда попадает старый пароль , новый пароль, хешируется новый пароль 
extract(requestData($_POST));


$validate = 1; // переменная состояния валидации

require_once 'validation/checkUser.php';
//Проверяю поля формы на пустоту
if (!empty($passCur) && !empty($password) && !empty($passConfirm)) {

    
    $result_user = check_user($pdo, $email); //Передаю параметры функции, что бы получить существующего пользователя

    //Если введённый пароль совпадает с паролем из сессии
    if ($result_pass = password_verify($passCur, $result_user['password'])) {

        //Проверка пароля на количество символов
        if (strlen($password) < 6) {

            $_SESSION['passErr'] = 'Пароль меньше 6 символов';// Сообщение об ощибке
            redirect('profile.php');                 //Редирект обратно
        } 

        if ($password !== $passConfirm) {

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
