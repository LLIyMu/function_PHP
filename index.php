<?php require_once('header.php'); ?>
<?php
//вывод комментариев

//Объединяю таблицы для вывода имени аторизованного пользователя, текста и даты комментария  
$comments = $pdo->query('SELECT form.*, users.name, users.image FROM form LEFT JOIN users ON form.user_id = users.id ORDER BY form.id DESC')->fetchAll();

?>
<main class="py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Комментарии</h3>
                    </div>

                    <div class="card-body">        <!-- Если сессия пустая добавляю класс d-none для скрытия этого флеш сообщения -->
                        <div class="alert alert-success <? if (empty($_SESSION['alert'])) : echo 'd-none' ?><? endif; ?>" role="alert">
                            <? //Добавляю сообщение о добавлении комментария
                            if (isset($_SESSION['alert'])) { //Если сессия существует вывожу сообщение
                                echo $_SESSION['alert'];     //Вывод сообщения
                                unset($_SESSION['alert']);   //Закрываю сессию
                            }
                            ?>
                        </div>

                        <?php foreach ($comments as $comment) :  if ($comment['skip'] !== 1): ?>
                            <div class="media">
                                <img src="img/<?= $comment['image'] ?>" class="mr-3" alt="..." width="64" height="64">
                                <div class="media-body">
                                    <h5 class="mt-0"><?= $comment['name'] ?></h5>
                                    <span><small><?= date('d/m/Y', strtotime($comment['date'])) ?></small></span>
                                    <p>
                                        <?= $comment['text'] ?>
                                    </p>
                                </div>
                            </div>
                            <?php endif;  endforeach; ?>
                            
                            
                    </div>
                </div>
            </div>

            <div class="col-md-12" style="margin-top: 20px;">
                <?php if (isset($_SESSION['email'])) : ?>
                    <div class="card">
                        <div class="card-header">
                            <h3>Оставить комментарий</h3>
                        </div>


                        <div class="card-body">
                            <form action="store.php" method="post">

                                <div class="form-group">
                                    <input name="user_id" type="hidden" value="<?= $user_id ?>">
                                    <label for="exampleFormControlTextarea2">Сообщение</label>
                                    <textarea name="text" class="form-control" id="exampleFormControlTextarea2" rows="3"></textarea>
                                    <div class="alert alert-danger <? if (empty($_SESSION['text'])) : echo 'd-none' ?><? endif; ?> " role="alert">
                                        <? //Add alert message user
                                            if (isset($_SESSION['text'])) {
                                                echo $_SESSION['text'];
                                                unset($_SESSION['text']);
                                            }
                                        ?>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success">Отправить</button>
                            </form>
                        </div>
                    </div>
                <?php else : ?>

                    <div class="alert alert-danger">
                        Чтобы оставить комментарий, <a href="register.php">зарегистрируйтесь</a> или <a href="login.php">авторизуйтесь</a>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</main>
</div>
</body>
<? dd($_SESSION['role']); ?>
</html>