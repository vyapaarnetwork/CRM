$(document).ready(function () {
    $('#leadStatusEdit').click(function () {
        $("html, body").animate({ scrollTop: $(document).height() }, 1000);
        $('#statusComment').slideToggle();
    })
    $("#statusComment").validate({
        errorElement: "small",
        errorClass: "text-danger",
        ignore: '.ignore',
        rules: {
            status: "required",
            comment: "required",
        },
        messages: {
            status: "Please! Select Any Status.",
            comment: "Please! Add Any Details Related With Status."
        },
        highlight: function (element) {
            $(element).addClass("is-invalid").removeClass('is-valid');
        },
        unhighlight: function (element) {
            $(element).addClass("is-valid").removeClass("is-invalid");
        },
        submitHandler: function (form) {
            var formFile = new FormData(form);
            $.ajax({
                url: base_url + '/admin/leadComment',
                type: 'post',
                data: formFile,
                cache: false,
                contentType: false,
                processData: false,
                success: function (result) {
                    var response = $.parseJSON(result);
                    if (response.status) {
                        $('#statusComment').slideToggle();
                        $("#errorReturn").show().text(response.message).addClass('text-success');
                        $('#newComment').html(response.data);
                        $('#leadstatus').text(response.commentStatus);
                    } else {
                        $("#errorReturn").show().text(response.message).addClass('text-danger');
                    }
                }
            });
        }
    });
    $('.btn-success').click(function () {
        var idcomment = $(this).data('id');
        var form =
            '<form id="addNewReplayComment' + idcomment + '" class="mt-2" method="POST">' +
            '<input type="hidden" name="slm_id" value="' + $('input[name=slm_id]').val() + '" />' +
            '<input type="hidden" name="slcm_id" value="' + idcomment + '" />' +
            '<div class="form-row">' +
            '<div class="col-md-10 col-sm-8 mb-4">' +
            '<input name="newReplayCommentAdd" class="form-control" id="newReplayCommentAdd" placeholder="Add Comment Replay"/>' +
            '</div>' +
            '<div class="col-md-2 col-sm-4 mb-4">' +
            '<button class="btn btn-primary" id="addAdmin" type="submit">Add</button>' +
            '</div>' +
            '</div>' +
            '</form>'
        $('#' + $(this).data('comment')).html(form);
        $("#addNewReplayComment" + idcomment).validate({
            errorElement: "small",
            errorClass: "text-danger",
            ignore: '.ignore',
            rules: {
                newReplayCommentAdd: "required",
            },
            messages: {
                newReplayCommentAdd: "Please! Enter Something in Comment."
            },
            highlight: function (element) {
                $(element).addClass("is-invalid").removeClass('is-valid');
            },
            unhighlight: function (element) {
                $(element).addClass("is-valid").removeClass("is-invalid");
            },
            submitHandler: function (form) {
                var formFile = new FormData(form);
                $.ajax({
                    url: base_url + '/admin/leadComment',
                    type: 'post',
                    data: formFile,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (result) {
                        var response = $.parseJSON(result);
                        if (response.status) {
                            $("#errorReturn").show().text(response.message).addClass('text-success');
                            $('#subcomment' + idcomment).html(response.data);
                            $('#addNewReplayComment' + idcomment).remove();
                        } else {
                            $("#errorReturn").show().text(response.message).addClass('text-danger');
                        }
                    }
                });
            }
        });
        count++;
    })
    function deleteComment() {
        $('.btn-danger').click(function () {
            var idDelete = $(this).data('id')
            $.ajax({
                url: base_url + '/admin/leadComment',
                type: 'post',
                data: {

                },
            });
        });
    }
    $('#leadAssign').click(function () {
        $('#assignLead').slideToggle();
    })
    $('#assignLead').validate({
        errorElement: "small",
        errorClass: "text-danger",
        ignore: '.ignore',
        rules: {
            assign: "required",
        },
        messages: {
            status: "Please! Select Any Vendor.",
        },
        highlight: function (element) {
            $(element).addClass("is-invalid").removeClass('is-valid');
        },
        unhighlight: function (element) {
            $(element).addClass("is-valid").removeClass("is-invalid");
        },
        submitHandler: function (form) {
            var formFile = new FormData(form);
            console.log(formFile);
            $.ajax({
                url: base_url + '/admin/leadAssign',
                type: 'post',
                data: formFile,
                cache: false,
                contentType: false,
                processData: false,
                success: function (result) {
                    var response = $.parseJSON(result);
                    if (response.status) {
                        $('#statusComment').slideToggle();
                        $("#errorReturn").show().text(response.message).addClass('text-success');
                    } else {
                        $("#errorReturn").show().text(response.message).addClass('text-danger');
                    }
                }
            });
        }
    });
});