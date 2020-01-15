<?php
error_reporting(-1);//Вывод сообщений о всех возможных ошибках
require_once 'db.php';
require_once 'function.php';
$email = $_SESSION['email'];
$user_id = $_SESSION['user_id'];
$pass_cur = htmlentities(trim($_POST['pass_cur'])); //Получаю старый пароль пользователя.
$password = htmlentities(trim($_POST['password'])); //Получаю новый пароль.
$pass_conf = htmlentities(trim($_POST['pass_conf'])); //Подтверждаю новый пароль.
$passHash = password_hash($password, PASSWORD_DEFAULT); //Хэширую пароль.

$validate = 1; // переменная состояния валидации
//dd($user_id);
// функция проверки информации о пользователе из БД
function check_user($pdo, $email) {           
    $sql_get = 'SELECT * FROM users WHERE email = :email'; //Формирую запрос к БД
    $stmt_get = $pdo->prepare($sql_get);      //Подготавливаю запрос (защита от sql-инъекций), выполняем его 
    $stmt_get->execute([':email' => $email]); //связываю переменные
    $result = $stmt_get->fetch();             // присваиваю данные из БД переменной, получаю их в ввиде ассоц массива
    return $result;                           // возвращаю результат
}
//Проверяю поля формы на пустоту
if (!empty($pass_cur) && !empty($password) && !empty($pass_conf)) {

    
    $result_user = check_user($pdo, $email); //Передаю параметры функции, что бы получить существующего пользователя

    //Если введённый пароль совпадает с паролем из сесии
    if ($result_pass = password_verify($pass_cur, $result_user['password'])) {

        //Проверка пароля на количество символов
        if (strlen($password) < 6) {

            $_SESSION['pass_err'] = 'Пароль меньше 6 символов';// Сообщение об ощибке
            header('location: /profile.php');                 //Редирект обратно
        } 

        if ($password !== $pass_conf) {

            $_SESSION['pass_err'] = 'Пароли не совпадают';// Сообщение об ощибке
            header('location: /profile.php');            //Редирект обратно
        }
    } else {
        $_SESSION['pass_err'] = 'Вы ввели неверный пароль';// Сообщение о неверном пароле
        header('location: /profile.php');                 // Редирект на профиль
    }

   
    
    //Вставляем введенныую пользователем информацию в БД.
        $sql = 'UPDATE users SET password = :password WHERE id = :id'; //Подготавливаю SQL запрос с нужными колонками таблицы
        $values = [':password' => $passHash, ':id' => $user_id];       //Передаю полученные значения
        $stmt = $pdo->prepare($sql);                                   //Подготовленный запрос
        $stmt->execute($values);                                       //Получаю обновлённые значения

        $_SESSION['pass_succes'] = 'Пароль обновлён'; // Сообщение об успешном изменении пароля
        header("Location:/profile.php");              // Редирект обратно на профиль
        exit;
} else {
    $_SESSION['pass_err'] = 'Поля пустые, заполните их'; // Сообщение о неверном пароле
    header('location: /profile.php');
}
