var isSuccess = false;
$(document).ready(function() {
    $('#newSetting').iziModal({
        title: 'Add Setting',
        width: 900,
        headerColor: '#007bff',
        radius: 10,
    });
    $('#editData').click(function() {
        $('#newSetting').iziModal('open');
    });
    table = $('#adminTableList').DataTable({
        processing: true,
        serverSide: true,
        displayStart: $('#page').val(),
        ajax: {
            url: base_url + "/admin/Setting-list",
            type: "POST",
            complete: function() {
                $(".ti-marker-alt").click(function() {
                    $.ajax({
                        url: base_url + "/admin/getElement/" + $(this).data("id"),
                        type: 'post',
                        success: function(result) {
                            var edit = $.parseJSON(result);
                            console.log(edit);
                            if (edit.status) {
                                $('#ssm_id').val(edit.data.ssm_id);
                                $("#Name").val(edit.data.ssm_name);
                                $("#Key").val(edit.data.ssm_key);
                                $("#type option[value='" + edit.data.ssm_type + "']").prop('selected', true)
                                if (edit.data.ssm_type == 'Textbox') {
                                    $('#cBox').hide();
                                    $('#tArea').hide();
                                    $('#file').hide();
                                    $('#tBox').show();
                                    $('#tBoxName').text($('#Name').val())
                                    $('#tBoxValue').val(edit.data.ssm_value)
                                } else if (edit.data.ssm_type == 'Checkbox') {
                                    $('#tArea').hide();
                                    $('#file').hide();
                                    $('#tBox').hide();
                                    $('#cBox').show();
                                    $('#cBoxName').text($('#Name').val())
                                    if (edit.data.sam_value == 'true') {
                                        $('#cBoxValue').prop('checked', true);
                                    } else {
                                        $('#cBoxValue').prop('checked', false);
                                    }
                                } else if (edit.data.ssm_type == 'Textarea') {
                                    $('#cBox').hide();
                                    $('#file').hide();
                                    $('#tBox').hide();
                                    $('#tArea').show();
                                    $('#tAreaName').text($('#Name').val())
                                    $('#tAreaValue').val(edit.data.ssm_value)
                                } else if (edit.data.ssm_type == 'File') {
                                    $('#cBox').hide();
                                    $('#tArea').hide();
                                    $('#tBox').hide();
                                    $('#file').show();
                                    $('#fileName').text($('#Name').val())
                                    $('#oldFile').val(edit.data.ssm_value)
                                }
                                $("#editData")[0].click()
                            } else {
                                $("#errorReturn").show().text(edit.message);
                            }
                        }
                    })
                })
                $(".ti-trash").click(function() {
                    var delete_setting = $(this);
                    duDialog('Confirm', 'Are You Sure You Want To Remove This Data?', {
                        init: true,
                        dark: false,
                        buttons: duDialog.OK_CANCEL,
                        okText: 'Yes',
                        cancelText: 'No',
                        callbacks: {
                            okClick: function(e) {
                                this.hide()
                                $.ajax({
                                    url: base_url + '/admin/settingDelete',
                                    type: 'post',
                                    data: 'deleteSeting=' + delete_setting.data("id"),
                                    success: function(result) {
                                        var Delete = $.parseJSON(result);
                                        if (Delete.status) {
                                            table.ajax.reload();
                                        }
                                    }
                                });
                            }
                        }
                    }).show()
                });
            }
        },
    });
    $(document).on('closing', '#newSetting', function(e) {
        $('#tBox').hide();
        $('#cBox').hide();
        $('#tArea').hide();
        $('#file').hide();
        $('#settingData')[0].reset();
    });
    $("#settingData").validate({
        errorElement: "small",
        errorClass: "text-danger",
        ignore: '.ignore',
        rules: {
            Name: "required",
            Key: "required",
            type: "required"
        },
        messages: {
            Name: "Name Is Required.",
            Key: "Key Is Required.",
            type: "Type Is Required."
        },
        highlight: function(element) {
            $(element).addClass("is-invalid").removeClass('is-valid');
        },
        unhighlight: function(element) {
            $(element).addClass("is-valid").removeClass("is-invalid");
        },
        submitHandler: function(form) {
            form = new FormData(form)
            $.ajax({
                type: 'post',
                url: base_url + '/admin/Setting-add',
                data: form,
                cache: false,
                contentType: false,
                processData: false,
                success: function(result) {
                    var response = $.parseJSON(result);
                    if (response.status) {
                        $("#errorReturn").show().text(response.message).addClass('text-success');
                        table.ajax.reload();
                        $('#newSetting').iziModal('close');
                    } else {

                    }
                }
            });
        }
    });
    $('#type').change(function(e) {
        var select = $(this).val();
        if (select == 'Textbox') {
            $('#cBox').hide();
            $('#tArea').hide();
            $('#file').hide();
            $('#tBox').show();
            $('#tBoxName').text($('#Name').val())
        } else if (select == 'Checkbox') {
            $('#tArea').hide();
            $('#file').hide();
            $('#tBox').hide();
            $('#cBox').show();
            $('#cBoxName').text($('#Name').val())
        } else if (select == 'Textarea') {
            $('#cBox').hide();
            $('#file').hide();
            $('#tBox').hide();
            $('#tArea').show();
            $('#tAreaName').text($('#Name').val())
        } else if (select == 'File') {
            $('#cBox').hide();
            $('#tArea').hide();
            $('#tBox').hide();
            $('#file').show();
            $('#fileName').text($('#Name').val())
        }
    });
});