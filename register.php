<?php
require_once('header.php');
?>
        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">Register</div>

                            <div class="card-body">
                                <form method="POST" action="reg_hand.php">

                                    <div class="form-group row">
                                        <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                                        <div class="col-md-6">
                                            <input id="name" type="text" class="form-control
                                             <? if (isset($_SESSION['name_err'])) : ?>is-invalid<? endif; ?>" name="name" autofocus required>

                                            <? if (isset($_SESSION['name_err'])) : ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>
                                                        <?= $_SESSION['name_err']; ?>
                                                    </strong>
                                                </span>
                                            <? unset($_SESSION['name_err']);
                                            endif;
                                            ?>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                                        <div class="col-md-6">
                                            <input id="email" type="email" class="form-control
                                              <? if (isset($_SESSION['email_err'])) : ?>is-invalid<? endif; ?>" name="email" required>


                                            <? if (isset($_SESSION['email_err'])) : ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>
                                                        <?= $_SESSION['email_err']; ?>
                                                    </strong>
                                                </span>
                                            <? unset($_SESSION['email_err']);
                                            endif;
                                            ?>

                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control 
                                             <? if (isset($_SESSION['pass_err'])) : ?>is-invalid<? endif; ?>" name="password" autocomplete="new-password" required>

                                            <? if (isset($_SESSION['pass_err'])) : ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>
                                                        <?= $_SESSION['pass_err']; ?>
                                                    </strong>
                                                </span>
                                            <? unset($_SESSION['pass_err']);
                                            endif;
                                            ?>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>

                                        <div class="col-md-6">
                                            <input id="password-confirm" type="password" class="form-control
                                             <? if (isset($_SESSION['pass_err'])) : ?>is-invalid<? endif; ?>" name="pass_confirm" autocomplete="new-password" required>
                                            <? if (isset($_SESSION['pass_err'])) : ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>
                                                        <?= $_SESSION['pass_err']; ?>
                                                    </strong>
                                                </span>
                                            <? unset($_SESSION['pass_err']);
                                            endif;
                                            ?>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                Register
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