<?php
require_once 'db.php';


function dd($var, $die = true) { //функция для выявления ошибок аналог vardump
    echo '<pre>' . print_r($var, true) . '</pre>';
    if ($die) die;
}

function getComments($pdo) {//функция вывода комментариев

    //Объединяю таблицы для вывода имени аторизованного пользователя, текста и даты комментария 
    $comments = $pdo->query('SELECT form.*, users.name, users.image FROM form LEFT JOIN
     users ON form.user_id = users.id ORDER BY form.id DESC')->fetchAll();

     return $comments;
}

function getMessage() {//функция вывода сообщений
    $message = false;
    
    if (   isset($_SESSION['alert']) || isset($_SESSION['text'])
        || isset($_SESSION['success']) || isset($_SESSION['emailErr'])
        || isset($_SESSION['passErr']) || isset($_SESSION['passSucces'])
        || isset($_SESSION['errImg']) || isset($_SESSION['successName']) 
        || isset($_SESSION['nameErr']) || isset($_SESSION['loginErr'])) {

            $message = true;

            return $message;
    }
}

function textMessage()
    {
        $text = false;
        if (isset($_SESSION['alert'])){
            echo $_SESSION['alert'];
            unset($_SESSION['alert']);
            $text = true;
        }
        $text = false;
        if (isset($_SESSION['text'])){
            echo $_SESSION['text'];
            unset($_SESSION['text']);
            $text = true;
        }
        $text = false;
        if (isset($_SESSION['success'])){
            echo $_SESSION['success'];
            unset($_SESSION['success']);
            $text = true;
        }
        $text = false;
        if (isset($_SESSION['emailErr'])){
            echo $_SESSION['emailErr'];
            unset($_SESSION['emailErr']);
            $text = true;
        }
        $text = false;
        if (isset($_SESSION['passErr'])){
            echo $_SESSION['passErr'];
            unset($_SESSION['passErr']);
            $text = true;
        }
        $text = false;
        if (isset($_SESSION['passSucces'])){
            echo $_SESSION['passSucces'];
            unset($_SESSION['passSucces']);
            $text = true;
        }
        $text = false;
        if (isset($_SESSION['errImg'])){
            echo $_SESSION['errImg'];
            unset($_SESSION['errImg']);
            $text = true;
        }
        $text = false;
        if (isset($_SESSION['successName'])){
            echo $_SESSION['successName'];
            unset($_SESSION['successName']);
            $text = true;
        }
        $text = false;
        if (isset($_SESSION['nameErr'])){
            echo $_SESSION['nameErr'];
            unset($_SESSION['nameErr']);
            $text = true;
        }
        $text = false;
        if (isset($_SESSION['loginErr'])){
            echo $_SESSION['loginErr'];
            unset($_SESSION['loginErr']);
            $text = true;
        }
    }