// PAGE INFO

// This page contains any generic JS code that will be used throughout the website

// PAGE INFO

// This page contains JS code specific to the password checker

$(function () {

    $('.gallery').magnificPopup({
        delegate: 'a', // child items selector, by clicking on it popup will open
        type: 'image'
        // other options
      });

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
            if (uname == true || $('#change-pass').val() == "true") {
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
                    window.location.replace("index.php?dash=forum");
                });
        })
    })

    //jQuery plugin
   
    $.fn.uploader = function( options ) {
      var settings = $.extend({
        MessageAreaText: "No files selected.",
        MessageAreaTextWithFiles: "File List:",
        DefaultErrorMessage: "Unable to open this file.",
        BadTypeErrorMessage: "We cannot accept this file type at this time.",
        acceptedFileTypes: ['pdf', 'jpg', 'gif', 'jpeg', 'bmp', 'tif', 'tiff', 'png', 'xps', 'doc', 'docx',
         'fax', 'wmp', 'ico', 'txt', 'cs', 'rtf', 'xls', 'xlsx']
      }, options );
   
      var uploadId = 1;
      //update the messaging 
       $('.file-uploader__message-area p').text(options.MessageAreaText || settings.MessageAreaText);
      
      //create and add the file list and the hidden input list
      var fileList = $('<ul class="file-list"></ul>');
      var hiddenInputs = $('<div class="hidden-inputs hidden"></div>');
      $('.file-uploader__message-area').after(fileList);
      $('.file-list').after(hiddenInputs);
      
     //when choosing a file, add the name to the list and copy the file input into the hidden inputs
      $('.file-chooser__input').on('change', function(){
         var file = $('.file-chooser__input').val();
         var fileName = (file.match(/([^\\\/]+)$/)[0]);
 
        //clear any error condition
        $('.file-chooser').removeClass('error');
        $('.error-message').remove();
        
        //validate the file
        var check = checkFile(fileName);
        if(check === "valid") {
          
          // move the 'real' one to hidden list 
          $('.hidden-inputs').append($('.file-chooser__input')); 
        
          //insert a clone after the hiddens (copy the event handlers too)
          $('.file-chooser').append($('.file-chooser__input').clone({ withDataAndEvents: true})); 
        
          //add the name and a remove button to the file-list
          $('.file-list').append('<li style="display: none;"><span class="file-list__name">' + fileName + '</span><button class="removal-button" data-uploadid="'+ uploadId +'"></button></li>');
          $('.file-list').find("li:last").show(800);
         
          //removal button handler
          $('.removal-button').on('click', function(e){
            e.preventDefault();
          
            //remove the corresponding hidden input
            $('.hidden-inputs input[data-uploadid="'+ $(this).data('uploadid') +'"]').remove(); 
          
            //remove the name from file-list that corresponds to the button clicked
            $(this).parent().hide("puff").delay(10).queue(function(){$(this).remove();});
            
            //if the list is now empty, change the text back 
            if($('.file-list li').length === 0) {
              $('.file-uploader__message-area').text(options.MessageAreaText || settings.MessageAreaText);
            }
          });
        
          //so the event handler works on the new "real" one
          $('.hidden-inputs .file-chooser__input').removeClass('file-chooser__input').attr('data-uploadId', uploadId); 
        
          //update the message area
          $('.file-uploader__message-area').text(options.MessageAreaTextWithFiles || settings.MessageAreaTextWithFiles);
          
          uploadId++;
          
        } else {
          //indicate that the file is not ok
          $('.file-chooser').addClass("error");
          var errorText = options.DefaultErrorMessage || settings.DefaultErrorMessage;
          
          if(check === "badFileName") {
            errorText = options.BadTypeErrorMessage || settings.BadTypeErrorMessage;
          }
          
          $('.file-chooser__input').after('<p class="error-message">'+ errorText +'</p>');
        }
      });
      
      var checkFile = function(fileName) {
        var accepted          = "invalid",
            acceptedFileTypes = this.acceptedFileTypes || settings.acceptedFileTypes,
            regex;
 
        for ( var i = 0; i < acceptedFileTypes.length; i++ ) {
          regex = new RegExp("\\." + acceptedFileTypes[i] + "$", "i");
 
          if ( regex.test(fileName) ) {
            accepted = "valid";
            break;
          } else {
            accepted = "badFileName";
          }
        }
 
        return accepted;
     };
   }; 
 }( jQuery ));
 
 //init 
 $(document).ready(function(){
   $('.fileUploader').uploader({
     MessageAreaText: "No files selected. Please select a file."
   });


});