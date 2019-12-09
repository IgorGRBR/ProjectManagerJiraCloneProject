<!DOCTYPE html>
<html lang="uk">
<head>
    <title>Зареєструватись в системі</title>
    <link rel="stylesheet" href="/public/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/public/css/style.css" />
    <script src="/public/js/jquery.min.js"></script>
    <script src="/public/js/bootstrap.min.js"></script>
</head>
<body>
<!--Header-->
<header>
    <nav class="navbar navbar-inverse p-0">
        <div class="container">
            <div class="navbar-header">
                <a href="/"><img class="brand_img" src="" width="303" height="75" alt=""></a>
            </div>
        </div>
    </nav>
</header>
<!--Main-->
<main class="container">
    <div class="row justify-content-center pt-5">
        <div class="col-xl-7 col-lg-7 col-md-7 col-sm-7 align-self-center">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Зареєструватись в системі</h4>
                    <p class="text-right"><a href="/form/sign/">До входу</a></p>
                </div>
                <div class="modal-body">
                    <form class="form-group">
                        <!--Login-->
                        <label for="login" class="text-center">Логін</label>
                        <input class="form-control btn-block" id="login" name="login" required maxlength="10">
                        <p class="text-danger text-center"><small id="login_error"></small></p>
                        <!--Email-->
                        <label for="email" class="text-center">Електронна адреса</label>
                        <input class="form-control btn-block" id="email" type="email" name="email" required>
                        <p class="text-danger text-center"><small id="email_error"></small></p>
                        <!--Password-->
                        <label for="password" class="text-center">Пароль</label>
                        <input class="form-control btn-block" id="password" type="password" name="password" required minlength="6" maxlength="20">
                        <p class="text-danger text-center"><small id="password_error"></small></p>
                        <!--Password confirm-->
                        <label for="confirm" class="text-center">Повторіть пароль</label>
                        <input class="form-control btn-block" id="confirm" type="password" name="confirm" required>
                        <p class="text-danger text-center"><small id="confirm_error"></small></p>
                        <!--Submit-->
                        <hr>
                        <button class="btn btn-danger btn-md btn-block mt-3" id="submit" type="submit">Зареєструватись</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
<!--Footer-->
<footer class="bg-dark text-secondary footer">
    <div class="container">
        <div class="row">
            <div class="mt-12 col-12 text-center">
                <p class="mb-0">© 2019 JiraClone</p>
                <p>Розроблено HungryStudents</p>
            </div>
        </div>
    </div>
</footer>
<!--Scrpit-->
<script src="/public/js/validate.js"></script>
<script>
    let submit      = $('#submit');
    let login       = $('#login');
    let email       = $('#email');
    let password    = $('#password');
    let confirm     = $('#confirm');

    let login_error     = $('#login_error');
    let email_error     = $('#email_error');
    let password_error  = $('#password_error');
    let confirm_error   = $('#confirm_error');

    submit.on('click', function() {

        let login_val     = login.val();
        let email_val     = email.val();
        let password_val  = password.val();
        let confirm_val   = confirm.val();

        let values = [
        {val: login_val,     input: login,      error: login_error},
        {val: email_val,     input: email,      error: email_error},
        {val: password_val,  input: password,   error: password_error},
        {val: confirm_val,   input: confirm,    error: confirm_error}];

        let valid = true;
        if (!validate_login_len(login_val)) {
            set_error_msg (login, login_error, 'Логін має бути довжиною від 6 до 20 символів');
            valid = false;
        }

        if (!validate_login_syn(login_val)) {
            set_error_msg (login, login_error, 'Логін має складатися лише з цифр та / або латинських букв');
            valid = false;
        }

        if (validate_not_email(email_val)) {
            set_error_msg (email, email_error, 'Введіть пошту правильно');
            valid = false;
        }

        if (!validate_password_len(password_val)) {
            set_error_msg (password, password_error, 'Пароль має бути довжиною від 6 до 20 символів');
            valid = false;
        }

        if (!validate_password_syn(password_val)) {
            set_error_msg (password, password_error, 'Пароль має складатися лише з цифр та / або латинських букв');
            valid = false;
        }

        if(validate_not_empty(confirm_val) && !validate_password_con(password_val, confirm_val)) {
            set_error_msg (confirm, confirm_error, 'Паролі мають співпадати');
            valid = false;
        }

        values.forEach(function(el) { 
            if (validate_empty(el['val'])) {
                set_error_msg(el['input'], el['error'], '');
                valid = false;
            }
        });

        if(!validate_password_con(password_val, confirm_val) && validate_not_empty(password_val)) {
            set_error_msg (confirm, confirm_error, 'Неправильно повторено пароль');
            valid = false;
        }

        if (valid) {

            if (validate_not_empty(login_val) && validate_not_empty(password_val)) {
                $.post( "/form/sign/register", 
                { login: login_val, email: email_val, password: password_val, confirm: confirm_val }, 
                () => {
                    location.href = '/form/';
                }).fail(function (errors) {
                    errors = JSON.parse(errors.responseText);
                    if (validate_not_empty(errors['login'])) {
                        set_error_msg(login, login_error, errors['login']);
                    }

                    if (validate_not_empty(errors['email'])) {
                        set_error_msg(email, email_error, errors['email']);
                    }

                    if (validate_not_empty(errors['password'])) {
                        set_error_msg(password, password_error, errors['password']);
                    }

                    if (validate_not_empty(errors['confirm'])) {
                        set_error_msg(confirm, confirm_error, errors['confirm']);
                    }
                });
            }

        }

        return false;
    });

    change_update_error_msg(login, login_error, 
    () => { return validate_login_len(login.val()) || validate_login_syn(login.val()); });

    change_update_error_msg(email, email_error,
    () => { return validate_email(email.val()); });

    change_update_error_msg(password, password_error,
    () => { return validate_password_len(password.val()) && validate_password_syn(password.val()); },
    () => { return false; }, 
    () => { confirm.trigger('change'); });

    change_update_error_msg(confirm, confirm_error,
    () => { return validate_password_con(password.val(), confirm.val()) && validate_password_len(confirm.val()) && validate_password_syn(confirm.val()); },
    () => { return validate_empty(confirm.val()) || (validate_password_len(password.val()) && validate_password_syn(password.val())); });

</script>
</body>
</html>