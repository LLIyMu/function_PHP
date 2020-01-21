<?php
error_reporting(-1);//Вывод сообщений о всех возможных ошибках
require_once 'db.php' ;
require_once 'function.php' ;
require_once 'validation/checkUser.php' ;

//вызываю функцию которая обрабатывает массив $_POST применяется htmlentities и trim,
// туда попадает емайл $email, и пароль $password 
//пароль $password, и чек-бокс запомнить меня $remeberMe
extract(requestData($_POST));

$validate = 1; // переменная состояния валидации

// Проверка email на допустимые символы
if (!preg_match('#^([a-z0-9_.-]{1,20}+)@([a-z0-9_.-]+)\.([a-z\.]{2,10})$#', $email)) {

    $_SESSION['emailErr'] = 'Укажите правильный email'; //зписываю сообщение об ошибке в сессию
    $validate = 0;                                      //валидация не пройдена(false)
} 
// Проверка email на пустоту
if (empty($email)) { // Если email пустой
    $_SESSION['emailErr'] = 'Введите email'; //зписываю сообщение об ошибке в сессию
    $validate = 0;                           //валидация не пройдена(false)
}
// Проверка пароля на количество символов
if (strLen($password) < 6) { //Пароль меньше шести символов
    $_SESSION['passErr'] = 'Пароль меньше 6 символов';
    $validate = 0;
} 
// Проверка пароля на пустоту
if (empty($password)) { // Пустой пароль
    $_SESSION['passErr'] = 'Введите пароль';
    $validate = 0;
}
// Если валидация прошла успешно, присваю результат переменной который вернула функция,
// а так же результат проверки пароля
if ($validate == 1) {  //Валидация true
    $result_user = checkUser($pdo, $email); //Передаю параметры функции 
    $result_pass = password_verify($password, $result_user['password']);

    //Если пользователь существует и введен верный пароль - записываю пользователя в сессию
    if ($result_user && $result_pass) {
        $_SESSION['success'] = 'Вы успешно авторизованы';//Сообщение об успешной авторизации
        $_SESSION['email'] = $result_user['email'];//Записываю в сессию полученный email из функции check_user
        $_SESSION['name'] = $result_user['name'];//Записываю в сессию полученное ИМЯ из функции check_user
        $_SESSION['user_id'] = $result_user['id']; //Записываю в сессию полученный ID из функции check_user
        $_SESSION['user_img'] = $result_user['image'];//Записываю в сессию полученное название image из функции check_use
        $_SESSION['role'] = $result_user['role'];//Записываю в сессию ROLE (админ или обычный пользователь)
        
        // Если нажат чек-бокс записываю данные в COOKIE
        if (isset($remeberMe)) {
            setcookie('email', $result_user['email'], time() + 3600);//Записываю в куки email если нажата кнопка запомнить меня
            setcookie('name', $result_user['name'], time() + 3600);//Записываю в куки ИМЯ если нажата кнопка запомнить меня
            setcookie('user_id', $result_user['id'], time() + 3600);//Записываю в куки ID если нажата кнопка запомнить меня
            setcookie('user_img', $result_user['image'], time() + 3600);//Записываю в куки ID если нажата кнопка запомнить меня
            setcookie('role', $result_user['role'], time() + 3600);//Записываю в куки ROLE(админ или обычныц пользователь)
                                                                    // если нажата кнопка запомнить меня
            
        }
        redirect('index.php');
    } 
    $_SESSION['emailErr'] = 'Неверный email или пароль';
    
}
redirect('login.php');
