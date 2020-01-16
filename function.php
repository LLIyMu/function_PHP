<?php
require_once 'db.php';


function dd($var, $die = true) { //функция для выявления ошибок аналог vardump
    echo '<pre>' . print_r($var, true) . '</pre>';
    if ($die) die;
}

function get_comments($pdo) {//функция вывода комментариев

    //Объединяю таблицы для вывода имени аторизованного пользователя, текста и даты комментария 
    $comments = $pdo->query('SELECT form.*, users.name, users.image FROM form LEFT JOIN
     users ON form.user_id = users.id ORDER BY form.id DESC')->fetchAll();

     return $comments;
}

function get_message() {//функция вывода сообщений
    $message = false;
    
    if (   isset($_SESSION['alert']) || isset($_SESSION['text']) || isset($_SESSION['success'])
        || isset($_SESSION['emailErr'])|| isset($_SESSION['passErr']) || isset($_SESSION['passSucces'])
        || isset($_SESSION['errImg']) ||
           isset($_SESSION['successName']) || isset($_SESSION['nameErr']) || isset($_SESSION['loginErr'])) {

            $message = true;

            return $message;
    }
}