// // PAGE INFO

// // This page contains JS code specific to the password checker

// $(function(){ 

//     $('#sign-up-submit').prop('disabled', true);

//     $('#username').on('keyup', function () {

//         // $.post("username-checker.php", {
//         //     usercheck: true,
//         //     username: $('#username').val()
//         // }).done(function(data) {
//         //     alert(data);
//         // })

//         $.post( "username-checker.php", {
//             usercheck: true,
//             username: $('#username').val()
//          }, function( data ) {
//             console.log( data); // John
//           }, "json");
//         $('#userExist').load();
//     })
    
    
//     $('#sign-up-password-check').on('keyup', function() {
//         if ($('#sign-up-password').val() == $('#sign-up-password-check').val() && !$('#sign-up-password').val() == "") {
//             $('#sign-up-submit').prop('disabled', false);
//             $('#pass-match').html('Passwords match!');
//             $('#pass-match').addClass('text-success');
//             $('#pass-match').removeClass('text-danger');
//         } else {
//             $('#sign-up-submit').prop('disabled', true);
//             $('#pass-match').html('Passwords do not match!');
//             $('#pass-match').removeClass('text-success');
//             $('#pass-match').addClass('text-danger');
//         }
//     })
    

// });