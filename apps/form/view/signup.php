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
<nav class="navbar navbar-inverse p-0">
    <div class="container">
        <div class="navbar-header">
            <a href="/"><img class="brand_img" src="" width="303" height="75" alt=""></a>
        </div>
    </div>
</nav>
<div class="container">
    <div class="row justify-content-center pt-5">
        <div class="col-xl-7 col-lg-7 col-md-7 col-sm-7 align-self-center">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Зареєструватись в системі</h4>
                    <p class="text-right"><a href="/form/sign/">До входу</a></p>
                </div>
                <div class="modal-body">
                    <form class="form-group">
                        <label for="login" class="text-center">Логін</label>
                        <input class="form-control btn-block" id="login" name="login" required maxlength="10">
                        <p class="text-danger text-center"><small id="login_error"></small></p>
                        <label for="email" class="text-center">Електронна адреса</label>
                        <input class="form-control btn-block" id="email" type="email" name="email" required>
                        <p class="text-danger text-center"><small id="email_error"></small></p>
                        <label for="password" class="text-center">Пароль</label>
                        <input class="form-control btn-block" id="password" type="password" name="password" required minlength="6" maxlength="20">
                        <p class="text-danger text-center"><small id="password_error"></small></p>
                        <label for="confirm" class="text-center">Повторіть пароль</label>
                        <input class="form-control btn-block" id="confirm" type="password" name="confirm" required>
                        <p class="text-danger text-center"><small id="confirm_error"></small></p>
                        <p for="agreement">Погоджуюсь з правилами користування</p>
                        <input id="agreement" type="checkbox" name="agreement" required></p>
                        <p class="text-danger text-center"><small id="agreement_error"></small></p>
                        <p class="text-danger text-center"><small id="error"></small></p>
                        <hr>
                        <button class="btn btn-danger btn-md btn-block mt-3" id="submit" type="submit">Зареєструватись</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/public/js/validate.js"></script>
<script>
    let submit      = $('#submit');
    let login       = $('#login');
    let email       = $('#email');
    let password    = $('#password');
    let confirm     = $('#confirm');
    let agreement   = $('#agreement');

    let error           = $('#error');
    let login_error     = $('#login_error');
    let email_error     = $('#email_error');
    let password_error  = $('#password_error');
    let confirm_error   = $('#confirm_error');
    let agreement_error = $('#agreement_error');

    let validate_password_len = function(val) {
       return val.length >= 6 && val.length <= 20;
    }

    let validate_password_sym = function(val) {
        let re = /^[a-z0-9]+$/i; 
        return re.test(String(val));
    }

    let validate_password_con = function(val1, val2) {
        return val1 === val2;
    }

    $('#agreement_open').on('click', () => {
        $('#agreement_modal').modal('toggle');
    });

    submit.on('click', function() {

        let login_val     = login.val();
        let email_val     = email.val();
        let password_val  = password.val();
        let confirm_val   = confirm.val();

        let values = [
        {val: login_val,     input: login,      error: login_error},
        {val: email_val,     input: email,      error: email_error},
        {val: password_val,  input: password,   error: password_error}];

        let b_error = false;
        if (validate_empty(login.val())) {
            set_error_msg (login, login_error, 'Введіть логін');
            b_error = true;
        }

        if (validate_not_email(email_val)) {
            set_error_msg (email, email_error, 'Введіть пошту правильно');
            b_error = true;
        }

        if (!validate_password_len(password_val)) {
            set_error_msg (password, password_error, 'Пароль має бути довжиною від 6 до 20 символів');
            b_error = true;
        }

        if (!validate_password_sym(password_val)) {
            set_error_msg (password, password_error, 'Пароль має складатися лише з цифр та / або латинських букв');
            b_error = true;
        }

        if(validate_not_empty(confirm_val) && !validate_password_con(password_val, confirm_val)) {
            set_error_msg (confirm, confirm_error, 'Паролі мають співпадати');
            b_error = true;
        }

        if(validate_empty(confirm_val) && validate_password_len(password_val) && validate_password_sym(password_val)) {
            set_error_msg (confirm, confirm_error, 'Повторіть пароль');
            b_error = true;
        }

        if (validate_not_checked(agreement)) {
            set_error_msg (agreement, agreement_error, 'Підтвердіть згоду');
            b_error = true;
        }

        values.forEach(function(el) { 
            if (validate_empty(el['val'])) {
                set_error_msg(el['input'], el['error'], '');
                b_error = true;
            }
        });

        if (!b_error) {
            if (validate_not_empty(login_val) && validate_not_empty(password_val)) {
            $.post( "/form/sign/register", 
            { login: login_val, password: password_val }, 
            () => {
               location.href = '/form/sign/confirm';
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

                if (validate_not_empty(errors['agreement'])) {
                    set_error_msg(agreement, agreement_error, errors['agreement']);
                }
            });
        }
        }

        return false;
    });

    change_update_error_msg(login, login_error, 
    () => { return validate_edrpou(login.val()) || validate_ipn(login.val()); });

    change_update_error_msg(email, email_error,
    () => { return validate_email(email.val()); });

    change_update_error_msg(password, password_error,
    () => { return validate_password_len(password.val()) && validate_password_sym(password.val()); },
    () => { return false; }, 
    () => { confirm.trigger('change'); });

    change_update_error_msg(confirm, confirm_error,
    () => { return validate_password_con(password.val(), confirm.val()) && validate_password_len(confirm.val()) && validate_password_sym(confirm.val()); },
    () => { return validate_empty(confirm.val()) || (validate_empty(confirm.val()) && validate_password_len(password.val()) && validate_password_sym(password.val())); });

    change_update_error_msg(agreement, agreement_error, 
    () => { return validate_checked(agreement); });

</script>
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
</body>
</html>