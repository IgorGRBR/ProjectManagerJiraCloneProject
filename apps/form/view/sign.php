<!DOCTYPE html>
<html lang="uk">
<head>
    <title>Увійти</title>
    <link rel="stylesheet" href="/public/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/public/css/style.css" />
    <script src="/public/js/jquery.min.js"></script>
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
        <div class="col-xl-4 col-lg-5 col-md-6 col-sm-7 align-self-center">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Увійти в систему</h4>
                </div>
                <div class="modal-body">
                    <form class="form-group">
                        <p>Логін <small></small></p>
                        <input class="form-control btn-block" id="login" type="text" name="login" required>
                        <p class="text-danger text-center mb-4"><small id="login_error"></small></p>
                        <p>Пароль</p>
                        <input class="form-control btn-block" id="password" type="password" name="password" required>
                        <p class="text-danger text-center"><small id="password_error"></small></p>
                        <p class="text-danger text-center"><small id="error"></small></p>
                        <hr>
                        <button class="btn btn-danger btn-md btn-block mt-3" id="submit" type="submit">Увійти</button>
                        <br>
                        <p class="text-center"><a href="/form/sign/up">Зареєструватись</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/public/js/validate.js"></script>
<script>

    let submit          = $('#submit');
    let login           = $('#login');
    let password        = $('#password');
    let error           = $('#error');
    let login_error     = $('#login_error');
    let password_error  = $('#password_error');

    submit.on('click', function() {

        let login_val = login.val();
        let password_val  = password.val();

        let valid = true;

        if (!validate_login_len(login_val)) {
            valid = set_error_msg (login, login_error, 'Логін має бути довжиною від 6 до 20 символів');
        }

        if (!validate_login_syn(login_val)) {
            valid = set_error_msg (login, login_error, 'Логін має складатися лише з цифр та / або латинських букв');
        }

        if (validate_empty(login_val.replace(/\s/g,''))) {
            valid = set_error_msg(login, login_error, '');
        }

        if (!validate_password_len(password_val)) {
            valid = set_error_msg (password, password_error, 'Пароль має бути довжиною від 6 до 20 символів');
        }

        if (!validate_password_syn(password_val)) {
            valid =  set_error_msg (password, password_error, 'Пароль має складатися лише з цифр та / або латинських букв');
        }

        if (validate_empty(password_val.replace(/\s/g,''))) {
            valid = set_error_msg(password, password_error, '');
        }

        if (valid) {

            $.post( "/form/sign/in", 
            { login: login_val, password: password_val }, 
            function ()  {
                location.href = '/form';
            }).fail(function(errors){
                errors = JSON.parse(errors.responseText);
                error.text(errors['login']);
                login.removeClass('border-success');
                password.removeClass('border-success');
                password.addClass('border-danger');
                password.val('');
            });

        }
        return false;
    });

    change_update_error_msg(login, login_error, 
    () => { return validate_login_len(login.val()) && validate_login_syn(login.val()); });

    change_update_error_msg(password, password_error,
    () => { return validate_password_len(password.val()) && validate_password_syn(password.val()); },
    () => { return false; });

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