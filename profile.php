<?php error_reporting(-1); ?>
<?php require_once('header.php'); ?>


<?php  ?>
<main class="py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Профиль пользователя</h3>
                    </div>

                    <div class="card-body">
                        <?php if(isset($_SESSION['success'])): ?>
                        <div class="alert alert-success" role="alert">
                            <?= $_SESSION['success']; ?>
                        </div>
                        <? unset($_SESSION['success']);
                        endif;
                        ?>

                        <form action="profile_hand.php" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">Новое имя</label>
                                        <input type="text" class="form-control <? if (isset($_SESSION['nameErr'])) : ?> is-invalid<? endif; ?>" name="name" id="exampleFormControlInput1" value="<?php echo $_SESSION['name']?>">

                                        <? if (isset($_SESSION['nameErr'])) : ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong>
                                                    <?= $_SESSION['nameErr']; ?>
                                                </strong>
                                            </span>
                                        <? unset($_SESSION['nameErr']);
                                        endif;
                                        ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">Изменить Email</label>
                                        <input type="text" class="form-control <? if (isset($_SESSION['emailErr'])) : ?>is-invalid<? endif; ?>" name="email" value="<?php echo $_SESSION['email']; ?>">


                                        <? if (isset($_SESSION['emailErr'])) : ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong>
                                                    <?= $_SESSION['emailErr']; ?>
                                                </strong>
                                            </span>
                                        <? unset($_SESSION['emailErr']);
                                        endif;
                                        ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">Добавить аватар</label>
                                        <input type="file" class="form-control" name="image" id="exampleFormControlInput1">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <img src="img/<?php echo $image_user; //$_SESSION['user_img']; ?>" alt="" class="img-fluid">
                                </div>

                                <div class="col-md-12">
                                    <button class="btn btn-warning">Изменить профиль</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-12" style="margin-top: 20px;">
                <div class="card">
                    <div class="card-header">
                        <h3>Безопасность</h3>
                    </div>

                    <div class="card-body">
                    <?php if(isset($_SESSION['pass_succes'])): ?>
                        <div class="alert alert-success" role="alert">
                            <?= $_SESSION['pass_succes']; ?>
                        </div>
                    <?php unset($_SESSION['pass_succes']);
                     endif;  ?>

                        <form action="profile_hand_password.php" method="post">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">Current password</label>
                                        <input type="password" name="pass_cur" class="form-control" id="exampleFormControlInput1">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">New password</label>
                                        <input type="password" name="password" class="form-control" id="exampleFormControlInput1">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">Password confirmation</label>
                                        <input type="password" name="pass_conf" class="form-control" id="exampleFormControlInput1">
                                    </div>

                                    <button class="btn btn-success">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
</div>
</body>
<?php unset($_SESSION['errImg']); ?>
</html>