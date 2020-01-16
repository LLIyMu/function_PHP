<?php
error_reporting(-1);
require_once 'db.php';
require_once 'function.php';


$name = htmlentities(trim($_POST['name'])); //Имя пользователя
$email = htmlentities(trim($_POST['email'])); //Получаем email, избавляемся от пробелов с его концов, предотвращаем возможность скриптовой атаки
$password = htmlentities(trim($_POST['password'])); //Получаю пароль.
$passHash = password_hash($password, PASSWORD_DEFAULT); //Хэширую пароль.
$pass_conf = htmlentities(trim($_POST['pass_confirm']));
$image = 'no-user.jpg'; //Присваиваю переменной картинку по умолчанию (заглушка)
$role = '0';

if (!empty($name) && !empty($email) && !empty($passHash) && !empty($pass_conf)) {
    
    //Запрос к БД на существующий email
    $sql_check = 'SELECT EXISTS( SELECT email FROM users WHERE email = :email )';
    $stmt_check = $pdo->prepare($sql_check);
    $stmt_check->execute([':email' => $email]);

    

        if(strLen($name) < 5) { // проверка на минимальное количество символов
        $_SESSION['nameErr'] = 'Не меньше 5 символов';
        header('location:/register.php');
        
        exit;
    
    }   // проверяю ввод email на допустимые символы
        elseif (!preg_match('#^([a-z0-9_.-]{1,20}+)@([a-z0-9_.-]+)\.([a-z\.]{2,10})$#', $email)) {
         
        $_SESSION['emailErr'] = 'Укажите правильный email';
        header('location:/register.php');
        exit;
        
    } elseif ($stmt_check->fetchColumn()) { //проверяю email на уже существующий
        $_SESSION['emailErr'] = 'Такой email уже зарегистрирован ранее';
        header('location:/register.php');
        exit;
    } elseif (strLen($password) < 6) { // проверка на минимальное количество символов
        $_SESSION['passErr'] = 'Пароль меньше 6 символов';
        header('location:/register.php');
        exit;
    } elseif (strLen($pass_conf) < 6) { // проверка на минимальное количество символов
        $_SESSION['passErr'] = 'Пароль меньше 6 символов';
        header('location:/register.php');
        exit;
    } elseif ($password !== $pass_conf) { //проверяю совпадают ли пароли
        
        $_SESSION['passErr'] = 'Пароли не совпадают';
        header('location:/register.php');
        exit;
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
    $_SESSION['loginErr'] = 'Заполните обязательные поля';
    exit;
}
/* 1. Получаем данные из полей
1.1. Создаем переменную для состояния валидации и по умолчанию задаем ей значение 1 или true;
1.2. Создаем пустой массив для хранения сообщений (один массив для всех сообщений и ошибок и об успехе)
2. Валидируем полученные данные
2.1. Валидируем имя на пустоту, если пустое, присваиваем переменной статуса валидации 0 или false,
     а в массив сообщений записываем сообщение об ошибке
2.2. Валидируем email на уже существующий, если не прошла валидация, по аналогии с именем,
     присваиваем переменной валидации 0 и т.д...
2.3. Валидируем email на соответсвие формату, по аналогии с другими проверками, 
    проделываем те же операции и последующие валидации тоже, можно написать свою функцию для упрощения,
     чтобы не дублировать код
2.4. Валидируем на пустоту email
2.5. Валидируем минимальную длину пароля
2.6. Валидируем пароль на пустоту
2.7. Валидируем подтверждение пароля на пустоту
2.8. Валидируем, соответствуют ли пароли друг другу
2.9. И так далее, по аналогии можно добавлять свои правила валидации...
3. Если данные прошли валидацию (то есть значения валидационной переменной осталось равно true или 1)
3.1. Хэшируем пароль
3.2. Заносим данные в базу
3.3. Записываем в массив сообщений сообщение об успехе
3.4. Присваиваем сессии массив сообщений
3.5. Редиректим на логин
4. Иначе, если данные не прошли валидацию
4.1. Присваиваем сессии массив сообщений
4.2. Редиректим на регистрацию
Вот как-то так в общих чертах
Если что-то будет непонятно, пиши, постараюсь объяснить) */ 