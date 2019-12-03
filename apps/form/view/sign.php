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
                        <small class="text-center p-0 m-0"><a href="/form/sign/recover">Забули пароль ?</a></small>
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
        if (validate_empty(login_val.replace(/\s/g,''))) {
            valid = set_error_msg(login, login_error, 'Введіть логін', () => {error.text('')});
        }

        if (validate_empty(password_val.replace(/\s/g,''))) {
            valid = set_error_msg(password, password_error, 'Введіть пароль',  () => {error.text('')});
        }

        if (valid) {

            $.post( "/form/sign/in", 
            { login: login_val, password: password_val }, 
            () => {
               location.href = '/form';
            }).fail(() => {
                error.text('Невірний логін або пароль');
                login.removeClass('border-success');
                password.removeClass('border-success');
            });

        }
        return false;
    });

    change_update_error_msg(login, login_error,    
    () => { 
        return validate_not_empty(login.val().replace(/\s/g,''));
    });

    change_update_error_msg(password, password_error, () => { 
        return validate_not_empty(password.val().replace(/\s/g,''));
    });
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