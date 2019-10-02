$(function(){ 

    $('#sign-up-submit').prop('disabled', true);
    
    
    $('#sign-up-password-check').on('keyup', function() {
        if ($('#sign-up-password').val() == $('#sign-up-password-check').val() && !$('#sign-up-password').val() == "") {
            $('#sign-up-submit').prop('disabled', false);
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