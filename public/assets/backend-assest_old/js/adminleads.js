$(document).ready(function() {
    table = $('#adminTableList').DataTable({
        processing: true,
        serverSide: true,
        displayStart: $('#page').val(),
        ajax: {
            url: base_url + "/admin/listLeads",
            type: "POST",
            complete: function() {
                $('.ti-marker-alt').click(function() {
                    id = $(this).data('id');
                    $.ajax({
                        type: "POST",
                        url: base_url + "/admin/getLeads",
                        data: {
                            slm_id: id
                        },
                        success: function(response) {
                            console.log('here');
                            leadData = $.parseJSON(response);
                            if (leadData.status) {
                                console.log('if');
                                $('#slm_id').val(leadData.data.slm_id);
                                $('#sum_id').val(leadData.data.sum_id);
                                $('#uName').val(leadData.data.sum_user_name);
                                $('#email').val(leadData.data.sum_user_email);
                                $('#mobileNo').val(leadData.data.sum_user_phone);
                                $('#position').val(leadData.data.sum_user_position);
                                $('#company').val(leadData.data.sum_user_company);
                                $('#address').val(leadData.data.sum_user_address.address);
                                $('#city').val(leadData.data.sum_user_address.city);
                                $('#zipCode').val(leadData.data.sum_user_address.zipCode);
                                $('#state').val(leadData.data.sum_user_address.state);
                                $('#country').val(leadData.data.sum_user_address.country);
                                $('#leadsValue').val(leadData.data.slm_leads_value);
                                $('#leadsDescription').val(leadData.data.slm_leads_description);
                                $('#oldFile').val(leadData.data.slm_leads_document);
                                $('#source option[value=' + leadData.data.slm_source_id + ']').prop('selected', true);
                                $('#addLeads').iziModal('open')
                            }
                        }
                    });
                });
                $('.ti-trash').click(function() {
                    id = $(this).data('id');
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
                                    type: "POST",
                                    url: base_url + "/admin/deleteLeads",
                                    data: {
                                        slm_id: id
                                    },
                                    success: function(response) {
                                        deleteLead = $.parseJSON(response);
                                        if (deleteLead.status) {
                                            $("#errorReturn").show().text(response.message).addClass('text-success');
                                            table.ajax.reload();
                                        }
                                    }
                                });
                            }
                        }
                    }).show()
                })
            }
        }
    });
    $('#addLeads').iziModal({
        title: 'Add Leads',
        width: 900,
        headerColor: '#007bff',
        radius: 10,
    });
    $('#leads').click(function(e) {
        $('#addLeads').iziModal('open')
        e.preventDefault();
    });
    $("#adminData").validate({
        errorElement: "small",
        errorClass: "text-danger",
        ignore: '.ignore',
        rules: {
            uName: "required",
            email: {
                required: true,
                email: true,
            },
            mobileNo: {
                required: true,
                number: true,
                rangelength: [10, 10],
            },
            position: 'required',
            company: 'required',
            address: 'required',
            city: 'required',
            zipCode: {
                required: true,
                number: true,
            },
            state: 'required',
            country: 'required',
            leadsValue: {
                required: true,
                number: true,
            },
            leadsDescription: {
                required: true,
                rangelength: [50, 200]
            }
        },
        messages: {
            uName: "User Name Is Required.",
            email: {
                required: "email Address Is Required.",
                email: 'Email Address Is Not Valid',
            },
            mobileNo: {
                required: "Mobile Number Is Required.",
                number: 'Only Numbers Allow.',
                rangelength: "Maximum 10 Number Valid.",
            },
            position: 'Position Is Required.',
            company: 'Company Name Is Required.',
            address: 'Addredd Field Is Required.',
            city: 'City Name Is Required.',
            zipCode: {
                required: "Zip Code Is Required.",
                number: 'Only Number Valid In Zip Code.',
            },
            state: 'State Name Is Requited.',
            country: 'Country Name Is Required.',
            leadsValue: {
                required: 'Lead Value Required',
                number: true,
            },
            leadsDescription: {
                required: 'Description Required.',
                rangelength: 'you Have To Enter minmum 50 or max 200 charactures.'
            }
        },
        highlight: function(element) {
            $(element).addClass("is-invalid").removeClass('is-valid');
        },
        unhighlight: function(element) {
            $(element).addClass("is-valid").removeClass("is-invalid");
        },
        submitHandler: function(form) {
            var formFile = new FormData(form);
            console.log(formFile);
            $.ajax({
                url: base_url + '/admin/addLeads' + ($("#ssm_id").val() ? '/' + $('#ssm_id').val() : ''),
                type: 'post',
                data: formFile,
                cache: false,
                contentType: false,
                processData: false,
                success: function(result) {
                    var response = $.parseJSON(result);
                    if (response.status) {
                        $("#errorReturn").show().text(response.message).addClass('text-success');
                        setTimeout(function() {
                            table.ajax.reload();
                        }, 300);
                        $('#addLeads').iziModal('close');
                    } else {

                    }
                }
            });
        }
    });
})