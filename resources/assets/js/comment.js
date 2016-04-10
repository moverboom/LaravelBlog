$(document).ready(function() {
    $('.editComment').on('click', function() {
        // if($(this).hasClass('active')) {
        //     $(this).removeClass('active');
        // } else {
        //     $(this).addClass('active');
        // }
        var orignalComment = $(this).parent().parent().children('.content').text();
        var originalId = $(this).siblings('.commentId').val();
        $(this).parent().parent().replaceWith(
            "<form class='form-inline' method='post' action='/comment/update/"+originalId+"'>" +
                '<input type=hidden name=_token value="'+window.csrfToken+'">' +
                "<div class='form-group'>" +
                    "<input type='text' name='content' value='"+orignalComment+"' class='form-control'/>" +
                "</div>" +
                "<button type='submit' class='btn btn-sm'>Save</button>" +
            "</form>"
        );
    });
});