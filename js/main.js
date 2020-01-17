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
                        } else {
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

    $('.forum-posts .edit-post').on('click', function () {
        // alert('this is clicked');
        let clickedBtnID = $(this).attr('id');
        let editText = $(`#${clickedBtnID}`).val();
        let originalPost = $(this).parent().html();
        $(this).parent().html(`
        <form action="../src/verify.php" method="post">
        <input type="hidden" name="post-id" value="${clickedBtnID}"/>
        <textarea name="edit-post" cols='400' row='100'>${$(this).siblings('p').children('.post-body').text()}</textarea><br><button type="submit">Submit</button>
        </form>
        <button id="cancel-edit-post">Cancel</button>
        `);
        $('#cancel-edit-post').on('click', function () {

            location.reload();
        });
    })

    $('.forum-posts-comments .edit-post').on('click', function () {
        // alert('this is clicked');
        let clickedBtnID = $(this).attr('id');
        let clickedBtnClass = $(this).attr('class');
        let editText = $(`#${clickedBtnID}`).val();
        let originalPost = $(this).parent().html();
        $(this).parent().html(`
        <form action="../src/verify.php" method="post">
        <input type="hidden" name="comment-id" value="${clickedBtnID}"/>
        <input type="hidden" name="post-id" value="${clickedBtnClass}"/>
        <textarea name="edit-comment" cols='400' row='100'>${$(this).siblings('p').children('.comment-body').text()}</textarea><br><button type="submit">Submit</button>
        </form>
        <button id="cancel-edit-post">Cancel</button>
        `);
        $('#cancel-edit-post').on('click', function () {

            location.reload();
        });
    })

    $('.forum-posts-comments .delete-comment').on('click', function () {
        let clickedBtnID = $(this).attr('id');
        let clickedBtnClass = $(this).attr('class');
        $('#myModal').modal('toggle');
        $('#confirm-delete').on('click', function () {
            console.log("this part worked post");
            $.post("../src/verify.php", {
                    delete_comment: true,
                    comment_id: clickedBtnID,
                    post_id: clickedBtnClass
                })
                .done(function (data) {
                    location.reload();
                });
        })
    })

    $('.forum-posts .delete-post').on('click', function () {
        let clickedBtnID = $(this).attr('id');
        let clickedBtnClass = $(this).attr('class');
        $('#myModal').modal('toggle');
        $('#confirm-delete').on('click', function () {
            console.log("this part worked post");

            $.post("../src/verify.php", {
                    delete_post: true,
                    post_id: clickedBtnID
                })
                .done(function (data) {
                    window.location.replace("index?dash=forum");
                });
        })
    })


});