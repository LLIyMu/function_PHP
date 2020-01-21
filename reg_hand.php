<?php
error_reporting(-1);
require_once 'db.php';
require_once 'function.php';
require_once 'validation/checkUser.php';


//вызываю функцию которая обрабатывает массив $_POST, туда попадает имя пользователя $name, емайл  $email, 
// новый пароль $password, проверяется введённый пароль $passConfirm, хешируется новый пароль $passHash
extract(requestData($_POST));

$image = 'no-user.jpg'; //Присваиваю переменной картинку по умолчанию (заглушка)
$role = '0';

if (!empty($name) && !empty($email) && !empty($passHash) && !empty($passConfirm)) {
    //Если заполненые поля не пустые формируем запрос к БД
    
    //Присваиваю переменной результат функции где выполняется запрос к БД на существующий email
$resultEmail = checkUser($pdo, $email);
    
        if ($name == 'admin' || $name == 'ADMIN' || $name == 'moderator' || $name == 'MODERATOR') {
             // если пользователь захотел зарегатся под именем admin или другим которое может сбить с толку обычных юзеров 
            $_SESSION['nameErr'] = 'Недопустимое имя';
            //записываю сообщение об ошибке в сессию
            redirect('register.php');
        }
        if(strLen($name) < 5) { // проверка на минимальное количество символов
        $_SESSION['nameErr'] = 'Не меньше 5 символов';
        //записываю сообщение об ошибке в сессию
        redirect('register.php');
    }   // проверяю ввод email на допустимые символы
        elseif (!preg_match('#^([a-z0-9_.-]{1,20}+)@([a-z0-9_.-]+)\.([a-z\.]{2,10})$#', $email)) {
         
        $_SESSION['emailErr'] = 'Укажите правильный email';
        //записываю сообщение об ошибке в сессию
        redirect('register.php');

    } elseif ($resultEmail) { //проверяю email на уже существующий
        $_SESSION['emailErr'] = 'Такой email зарегистрирован ранее';
        //записываю сообщение об ошибке в сессию
        redirect('register.php');

    } elseif (strLen($password) < 6) { // проверка на минимальное количество символов
        $_SESSION['passErr'] = 'Пароль меньше 6 символов';
        //записываю сообщение об ошибке в сессию
        redirect('register.php');

    } elseif (strLen($passConfirm) < 6) { // проверка на минимальное количество символов
        $_SESSION['passErr'] = 'Пароль меньше 6 символов';
        //записываю сообщение об ошибке в сессию
        redirect('register.php');

    } elseif ($password !== $passConfirm) { //проверяю совпадают ли пароли
        
        $_SESSION['passErr'] = 'Пароли не совпадают';
        //записываю сообщение об ошибке в сессию
        redirect('register.php');
        
    } else {
        //Вставляем введенныую пользователем информацию в БД.
        $sql = 'INSERT INTO `users` (`name`, `email`, `password`, `image`, `role`) VALUES (:name, :email, :password, :image, :role)';
        $values = ['name' => $name, 'email' => $email, 'password' => $passHash, 'image' => $image, 'role' => $role];
        $statement = $pdo->prepare($sql);
        $statement->execute($values);
        header("Location:/login.php");
        exit;
    }
} else {
    $_SESSION['nameErr'] = 'Заполните обязательные поля';
    //записываю сообщение об ошибке в сессию
    redirect('register.php');
}