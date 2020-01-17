<?php

function check_user($pdo, $email)
{           // функция проверки информации о пользователе из БД
    $sql_get = 'SELECT * FROM users WHERE email = :email'; //Формирую запрос к БД
    $stmt_get = $pdo->prepare($sql_get);      //Подготавливаю запрос (защита от sql-инъекций), выполняем его 
    $stmt_get->execute([':email' => $email]); //связываю переменные
    $result = $stmt_get->fetch();             // присваиваю данные из БД переменной, получаю их в ввиде ассоц массива
    return $result;                           // возвращаю результат
}

function check_email($pdo, $email)           // функция проверки информации о пользователе из БД
{
    $sql_get = 'SELECT email FROM users'; //Формирую запрос к БД
    $stmt_get = $pdo->prepare($sql_get);      //Подготавливаю запрос (защита от sql-инъекций), выполняем его 
    $stmt_get->execute(); //связываю переменные
    while ($result = $stmt_get->fetch()) {
        if ($result['email'] == $email && $result['email'] != $_SESSION['email']) {
            return true;
        }
    }
    return false;                           // возвращаю результат
}