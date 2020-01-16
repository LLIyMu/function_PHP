<?php
require_once 'db.php';
require_once 'function.php';


$data =[]; // подготавливаю переменную для динамического запроса к БД с пустым массивом
$id = $_SESSION['user_id']; // записываю id пользователя из сессии в переменную
$name = htmlentities(trim($_POST['name'])); // получаю имя из формы и защищаю от возможных hack атак
$email = htmlentities(trim($_POST['email'])); // получаю email из формы и защищаю от возможных hack атак
$image = $_FILES['image']; // записываю в переменную данные о полученной картинке
$image_user = $_SESSION['user_img'];

$validate = 1; // переменная состояния валидации

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

// Функция ззагрузки изображения, принимает $image = $_FILES, $image_user = $_SESSION['image']
function img_upload($image, $image_user, $validate) {
    //dd($image);
    if (!$validate) { // Если НЕ валидация
        return false; // Возвращаем false
    }
    if (!empty($image['name'])) {// Если существует $image

    $uploadDir = __DIR__ . '\\img\\'; // Создаю дерикторию файла
    
    $avialabelExtention = ['jpg', 'svg', 'png', 'gif']; // Массив с допустимыми расширениями

    $extention = pathinfo($image['name'], PATHINFO_EXTENSION); // Получаю расширение файла
    
    $filename = uniqid() . "." . $extention; // Задаю уникальное имя файла и присваиваю его переменной
    

    if ($_FILES['image']['error'] > 0 && $_FILES['image']['error'] != 4) {

        $_SESSION['errImg'] = 'При загрузке произошла ошибка';
        return false;
    } 

    if (!in_array($extention , $avialabelExtention)) {

        $_SESSION['errImg'] = 'Неверное расширение, для загрузки используйте: ' . implode(', ' , $avialabelExtention);
        return false;
    } 


    if ($image_user != 'no-user.jpg') {
            
        unlink($uploadDir . $image_user);    
    }
    move_uploaded_file($image['tmp_name'], 'img/' . $filename); 
    
    return $filename;
    }

    return $_SESSION['user_img'];

}

if (empty($name) || isset($_SESSION['name'])) { //если поле пустое ИЛИ есть сессия с именем пользователя
    
    $data['name'] = $_SESSION['name']; // записываю в переменную имя из сессии
}
if (empty($email) || isset($_SESSION['email'])) { //если поле пустое ИЛИ есть сессия с email пользователя
    
    $data['email'] = $_SESSION['email']; // записываю в переменную email из сессии
}
if (isset($name) && ($name != $_SESSION['name'])) {//Если имя в $_POST существует И  ИМЯ из $_POST не равно 
                                                   //ИМЕНИ из сессии
    $data['name'] = $name; // записываю в переменную $data имя полученное из POST
    
}

if (!empty($email) && ($email != $_SESSION['email'])) { //если поле email не пустое И емайл НЕ равен эмайлу из сессии

    $data['email'] = $email; // записываю в переменную $data, email полученный из POST
    
    //проверяю email на допустимые символы
    if (!preg_match('#^([a-z0-9_.-]{1,20}+)@([a-z0-9_.-]+)\.([a-z\.]{2,10})$#', $email)) {

        $_SESSION['emailErr'] = 'Неправильный формат email'; // записываю в сессию ошибку валидации
        $validate = 0; // валидация не пройдена (false)
    
  }
}

$result_email = check_email($pdo, $email); // передаю параметры в функцию и присваиваю полученные данные переменной
  
if ($result_email && isset($email)) { // если есть данные из переменной И существует введенный емайл через форму

    $_SESSION['emailErr'] = 'Такой email уже зарегестрирован'; //записываю сообщение в сессию
    $validate = 0; // валидация не пройдена (false)
}

if (!$img_data = img_upload($image, $image_user, $validate))  {
    
    $validate = 0;
} else {
    $data['image'] = $img_data;
}

if($validate == 1) { //если валидация пройдена (true)

    $set = ''; // Присваиваю переменной пустую строку
    foreach ($data as $key => $value) { // прогоняю $data через цикл, что бы получить данные в sql запрос
        $set = $set . $key . ' = :' . $key . ', '; // преобразую массив в строку и конкатинирую ключи и разделитель  
    }

    $set = rtrim($set, ", "); // обрезаю последнюю запятую и пробел из строки
    $data['id'] = $id; // присваиваю id пользователя в переменную data
    
    $sql = "UPDATE users SET $set  WHERE id = :id"; //подготавливаю запрос к БД и меняю name или email
    $stmt_up = $pdo->prepare($sql);                 //подготавливаю запрос (защита от sql-инъекций)
    $stmt_up->execute($data);                       //выполнение запроса

    
    $_SESSION['email'] = $email;           //перезаписываю новый емайл в сессию
    $_SESSION['name'] = $name;             //перезаписываю новый емайл в сессию
    $_SESSION['user_img'] = $data['image'];//перезаписываю в data полученное из БД название
                                           //картинки и расширение в место заглушки
    
    $_SESSION['successName'] = 'Профиль успешно изменен'; //сообщение о успешном изменении профиля

    if (isset($_COOKIE['email'])) { //Если существует кука с емайл из БД

        setcookie('email', $email, time() + 3600);           //записываю в куку емайл
        setcookie('name', $name, time() + 3600);             //записываю в куку имя пользователя
        setcookie('user_img', $data['image'], time() + 3600);//записываю в куку имя.расширение
                                                             //картинки полученное из БД   
    }
}
header('location: /profile.php'); // редирект 
exit;
