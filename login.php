<?php require_once('header.php'); ?>
<?php require_once 'function.php' ?>
        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">Login</div>

                            <div class="card-body">
                                <form method="POST" action="login_hand.php">

                                    <div class="form-group row">
                                        <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                                        <div class="col-md-6">
                                            <input id="email" type="text" class="form-control
                                             <? if (isset($_SESSION['emailErr'])) : ?>is-invalid<? endif; ?>" name="email" autocomplete="email" autofocus>
                                            <?php if (isset($_SESSION['emailErr'])) : ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>
                                                        <?= $_SESSION['emailErr']; ?>
                                                    </strong>
                                                </span>
                                            <?php unset($_SESSION['emailErr']);
                                            endif;
                                            ?>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control
                                             <? if (isset($_SESSION['passErr'])) : ?>is-invalid<? endif; ?>" name="password" autocomplete="current-password">
                                            <?php if (isset($_SESSION['passErr'])) : ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>
                                                        <?= $_SESSION['passErr']; ?>
                                                    </strong>
                                                </span>
                                            <?php unset($_SESSION['passErr']);
                                            endif;
                                            ?>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-6 offset-md-4">
                                            <div class="form-check">
                                                <input class="" type="hidden" name="remember" value="0">
                                                <input class="form-check-input" type="checkbox" name="remember" id="remember" value="1">

                                                <label class="form-check-label" for="remember">
                                                    Remember Me
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-md-8 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                Login
                                            </button>
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
</html>