<?php
require_once 'db.php';
require_once 'function.php';
?>
<?php

//Если  не существует куки записываем в сессию данные
if (!isset($_COOKIE['email'])) {
    $email = $_SESSION['email'];     //Записываю в переменную почту из сессии
    $name = $_SESSION['name'];       //Записываю в переменную имя из сессии
    $user_id = $_SESSION['user_id']; //Записываю в переменную ID из сессии
    $image_user = $_SESSION['user_img']; //Записываю в переменную имя и расширение картинки полученное из БД
    $role = $_SESSION['role'];
} else { // Иначе записываю в куки
    $email = $_COOKIE['email'];
    $name = $_COOKIE['name'];
    $user_id = $_COOKIE['user_id'];
    $image_user = $_COOKIE['user_img'];
    $role = $_COOKIE['role'];
}
if (!isset($email) || (isset($email) && $role != 1)) {
    redirect('index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Comments</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Styles -->
    <link href="css/app.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="index.php">
                    Project
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <?php if (isset($email)) : ?>
                            <!-- если есть сессия то выводим вместо меню, имя пользователя -->
                            <div class="dropdown">
                                <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Привет, <?php echo $name ?>
                                </button>

                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="profile.php">Профиль</a>
                                    <!-- если в сессии есть админ, выводим для него вкладку -->
                                    <?php if ($_SESSION['role'] == 1) : ?>
                                        <a class="dropdown-item" href="admin.php">Админ панель</a>
                                    <?php endif; ?>
                                    <a class="dropdown-item" href="logout.php">Выход</a>
                                </div>
                            </div <?php else : ?> <!-- Иначе, вывожу меню для авторизации, регистрации -->
                            <li class="nav-item">
                                <a class="nav-link" href="login.php">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="register.php">Register</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3>Админ панель</h3>
                            </div>

                            <div class="card-body">

                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Аватар</th>
                                            <th>Имя</th>
                                            <th>Дата</th>
                                            <th>Комментарий</th>
                                            <th>Действия</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php $comments = getComments($pdo); //функция вывода коментариев?>

                                        <?php foreach ($comments as $comment) : //вывод коментариев?>

                                            <tr>
                                                <td>
                                                    <img src="img/<?= $comment['image'] ?>" alt="" class="img-fluid" width="64" height="64">
                                                </td>
                                                <td><?php echo $comment['name'] ?></td>
                                                <td><?= date('d/m/Y', strtotime($comment['date'])) ?></td>
                                                <td><?= $comment['text'] ?></td>
                                                <td>
                                                    <?php if ($comment['skip'] == 1) : ?>
                                                        <form action="admin_hand.php" method="post">
                                                            <button type="submit" name="show" value="<?php echo $comment['id']; ?>" class="btn btn-success">Разрешить</button>
                                                        </form>
                                                    <?php else : ?>
                                                        <form action="admin_hand.php" method="post">
                                                            <button type="submit" name="skip" value="<?php echo $comment['id']; ?>" class="btn btn-warning">Запретить</button>
                                                        </form>
                                                    <?php endif; ?>
                                                    <form action="admin_hand.php" method="post">
                                                        <button onclick="return confirm('are you sure?')" name="delete" value="<?php echo $comment['id']; ?>" class="btn btn-danger">
                                                            Удалить</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>