let set_error_msg = function(input, input_error, text, callback = () => {}) {
    input.removeClass('border-success').addClass('border-danger');
    input_error.text(text);
    callback();
    return false;
};

let unset_error_msg = function(input, input_error, callback = () => {}) {
    input.removeClass('border-danger').addClass('border-success');
    input_error.text('');
    callback();
    return true;
};

let change_update_error_msg = function (input, input_error, validate_success = () => { return false }, validate_neutral = () => { return false }, callback = () => { }) {
    input.on('change paste keyup', function() {

        if (validate_success()) {
            input.removeClass('border-danger').addClass('border-success');
            input_error.text('');
        } else {
            input.removeClass('border-success');
        }

        if(validate_neutral()) {
            input.removeClass('border-danger');
            input_error.text('');
        }

        callback();
    });
};

let validate_empty = function(val) {
    return val === '';
}

let validate_not_empty = function(val) {
    return val !== '';
}

let validate_email = function(email_val) {
    let re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email_val).toLowerCase());
}

let validate_not_email = function(email_val) {
    return !validate_email(email_val);
}

let validate_checked = function(input) {
    return input.prop('checked');
}

let validate_not_checked = function(input) {
    return !input.prop('checked');
}

let validate_login_len = function(val) {
    return val.length >= 6 && val.length <= 20;
 }

let validate_login_syn = function(val) {
    let re = /^[a-z0-9]+$/i; 
    return re.test(String(val));
}

let validate_password_len = function(val) {
    return val.length >= 6 && val.length <= 20;
 }

 let validate_password_syn = function(val) {
     let re = /^[a-z0-9]+$/i; 
     return re.test(String(val));
 }

 let validate_password_con = function(val1, val2) {
     return val1 === val2;
 }