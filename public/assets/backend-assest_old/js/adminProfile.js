$(document).ready(function() {
    $(".file-upload").on('change', function() {
        $('#UserImage').hide()
        $('#load').show();
        if (this.files.length > 0) {
            var formData = new FormData();
            formData.append("imageFile", this.files[0]);
            $.ajax({
                type: "POST",
                url: base_url + "/admin/profileImage/" + $('#admin_id').val(),
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    result = $.parseJSON(response)
                    if (result.status) {
                        $('#UserImage').attr('src', result.data);
                        $('#profileError').show().text(result.message).addClass('text-success');
                    } else {
                        $('#profileError').show().text(result.message).addClass('text-danger');
                    }
                    $("#load").hide();
                    $('#UserImage').show()
                }
            });
        } else {
            $("#profileError").text('No File Selected.')
        }
    });
    $(".upload-button").on('click', function() {
        $(".file-upload").click();
    });
    $('.custom-control-input').on('change', function() {
        var change = null;
        if ($(this).prop("checked") == true) {
            change = $(this).val() + ',true';
        } else if ($(this).prop("checked") == false) {
            change = $(this).val() + ',false';
        }
        console.log(change);
        $.ajax({
            type: "POST",
            url: base_url + "/admin/userAccess",
            data: {
                user_id: $('#admin_id').val(),
                value: change
            },
            success: function(response) {
                result = $.parseJSON(response);
                if (result.status) {
                    $('#accessMessage').addClass('text-success').text(result.message);
                } else {
                    $('#accessMessage').addClass('text-danger').text(result.message);
                }
            }
        });
    })
});