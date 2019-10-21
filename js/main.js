// PAGE INFO

// This page contains any generic JS code that will be used throughout the website

// PAGE INFO

// This page contains JS code specific to the password checker

$(function () {

    let timeout = null;
    let uname = false;

    $('#sign-up-submit').prop('disabled', true);

    $('#username').on('keyup', function () {

        clearTimeout(timeout);

        // Make a new timeout set to go off in 800ms
        timeout = setTimeout(function () {
            $.post("src/username-checker.php", {
                usercheck: true,
                username: $('#username').val()
            }, function (data) {
                if ($('#username').val().length > 0) {
                    if (data == "true") {
                        $('#user-exists').html('Available');
                        uname = true;
                        if ($('#sign-up-password').val() == $('#sign-up-password-check').val() && !$('#sign-up-password').val() == "") {
                            $('#sign-up-submit').prop('disabled', false);
                        } else{
                            $('#sign-up-submit').prop('disabled', true);
                        } 
                    } else {
                        uname = false;
                        $('#user-exists').html('Username Taken');
                    }
                } else {
                    uname = false;
                    $('#sign-up-submit').prop('disabled', true);
                    $('#user-exists').html('');
                }

            }, "text");
        }, 500);
    })


    $('#sign-up-password-check').on('keyup', function () {
        if ($('#sign-up-password').val() == $('#sign-up-password-check').val() && !$('#sign-up-password').val() == "") {
            if (uname == true) {
                $('#sign-up-submit').prop('disabled', false);
            }
            $('#pass-match').html('Passwords match!');
            $('#pass-match').addClass('text-success');
            $('#pass-match').removeClass('text-danger');
        } else {
            $('#sign-up-submit').prop('disabled', true);
            $('#pass-match').html('Passwords do not match!');
            $('#pass-match').removeClass('text-success');
            $('#pass-match').addClass('text-danger');
        }
    })


});