$(document).ready(function () {
    table = $('#adminTableList').DataTable({
        processing: true,
        serverSide: true,
        displayStart: $('#page').val(),

        ajax: {
            url: base_url + "/admin/listLeads",
            type: "POST",
            complete: function () {
                $('.ti-marker-alt').click(function () {
                    id = $(this).data('id');
                    $.ajax({
                        type: "POST",
                        url: base_url + "/admin/getLeads",
                        data: {
                            slm_id: id
                        },
                        success: function (response) {
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
                $('.ti-trash').click(function () {
                    id = $(this).data('id');
                    duDialog('Confirm', 'Are You Sure You Want To Remove This Data?', {
                        init: true,
                        dark: false,
                        buttons: duDialog.OK_CANCEL,
                        okText: 'Yes',
                        cancelText: 'No',
                        callbacks: {
                            okClick: function (e) {
                                this.hide()
                                $.ajax({
                                    type: "POST",
                                    url: base_url + "/admin/deleteLeads",
                                    data: {
                                        lead_id: id
                                    },
                                    success: function (response) {
                                        deleteLead = $.parseJSON(response);
                                        if (deleteLead.status) {
                                            $.toast({
                                                heading: deleteLead.message,
                                                position: 'top-right',
                                                loaderBg: '#ff6849',
                                                icon: 'error',
                                                hideAfter: 3500,
                                                stack: 6
                                            }); 
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

    // $('#leads').click(function(e) {
    //     $('#addLeads').iziModal('open')
    //     e.preventDefault();
    // });
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
                url: base_url + '/admin/addLeads' + ($("#ssm_id").val() ? '/' + $('#ssm_id').val() : ''),
                type: 'post',
                data: formFile,
                cache: false,
                contentType: false,
                processData: false,
                success: function (result) {
                    var response = $.parseJSON(result);
                    if (response.status) {
                        $("#errorReturn").show().text(response.message).addClass('text-success');
                        setTimeout(function () {
                            table.ajax.reload();
                        }, 300);
                        $('#addLeads').iziModal('close');
                    } else {

                    }
                }
            });
        }
    });



});

$(document).ready(function () {

        $("#exiting_1").hide();
        $("#exiting_2").hide();
        $("#exiting_3").hide();

    

    $("#exiting_customer").change(function () {
        var id = $("#exiting_customer").val();

        if (id == 2) {
            $("#exiting_1").hide();
            $("#exiting_2").hide();
            $("#exiting_3").show();

        }
        else {
            $("#exiting_1").show();
            $("#exiting_2").show();
            $("#exiting_3").hide();
        }


    })
})

$(document).ready(function () {

    $("#selcustomer").select2({

        ajax: {
            url: base_url + "/admin/getcustomer",
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    searchTerm: params.term // search term
                };
            },
            processResults: function (response) {
                return {

                    results: response
                };
            },
            cache: true
        }
    });
    $(".js-example-theme-single").select2({
        theme: "classic"
    });
});


$.validator.addMethod("uniqueEmail",
    function (value, element) {
        if (value) {
            $.ajax({
                url: base_url + '/admin/CustomerEmail' + ($("#customer_email").val() ? '/' + $('#customer_email').val() : ''),
                type: 'post',
                data: 'val=' + value,
                success: function (result) {
                    var email = $.parseJSON(result);
                    isSuccess = email.status;
                }
            });
        }
        return this.optional(element) || isSuccess;
    },
    "Email Already Exists."
);

$(function () {
    $("#exiting_customer").change(function () {
        var id = $("#exiting_customer").val();

        if(id == 2){
            $("#customer_name").addClass('ignore')
            $("#customer_email").addClass('ignore')
            $("#customer_phone").addClass('ignore')
            $("#customer_address").addClass('ignore')
            $("#customer_city").addClass('ignore')

            $("#customer_state").addClass('ignore')
            $("#customer_zipcode").addClass('ignore')

            $("#customer_country").addClass('ignore')

        }
    })

        $("#add_lead").validate({
            errorElement: "small",
            errorClass: "text-danger",
            ignore: '.ignore',



            rules: {
                exiting_customer:'required',
                customer_name: "required",
                customer_email: {
                    required: true,
                    email: true,
                    uniqueEmail: true
                },
                customer_phone: "required",
                customer_address: "required",
                customer_city: "required",
                customer_state: "required",
                customer_zipcode: "required",
                customer_country: "required",

                lead_maincat_name: "required",

                lead_subcat_name: "required",

                lead_assign_id: "required",

                lead_value: "required",

                lead_commission: "required",


                lead_source_id: "required",

                lead_description: "required"


            },
            messages: {
                exiting_customer:'Customer Must Require',

                customer_name: "Name Required",
                customer_email: {
                    required: "Email Is Required.",
                    email: "Email Is Not Valid.",
                },
                customer_phone: "Phone Number Required",
                customer_address: "Address Required",
                customer_city: "City Required",
                customer_state: "State Required",
                customer_zipcode: "ZipCode Required",
                customer_country: "Country Required",



                lead_maincat_name: "Main Services Require",

                lead_subcat_name: "Sub Services Require",

                lead_assign_id: "Vendor Selection Require",

                lead_value: "Lead Value Require",

                lead_commission: "Lead Value Require",

                lead_source_id: "Lead Source Require",

                lead_description: "Please enter some data"
            },
            highlight: function (element) {
                $(element).addClass("is-invalid").removeClass('is-valid');
            },
            unhighlight: function (element) {
                $(element).addClass("is-valid").removeClass("is-invalid");
            },
            
        })


    


    $("#subBtn").on("click", function () {


        if ($("#add_lead").valid()) {
            //alert("success");
            var id = $("#exiting_customer").val();
            var lead_id = $("#lead_id").val();
            var lead_customer_id = $("#selcustomer").val();
            var lead_maincat_name = $('select[name="lead_maincat_name"]').val();
            var lead_subcat_name = $('select[name="lead_subcat_name"]').val();
            var lead_assign_id = $('select[name="lead_assign_id"]').val();
            var lead_value = $("#lead_value").val();
            var lead_commission = $("#lead_commission").val();

            var lead_source_id = $('select[name="lead_source_id"]').val();
            var lead_description = $("#lead_description").val();

            // customer
            var customer_name = $("#customer_name").val();
            var customer_company = $("#customer_company").val();
            var customer_email = $("#customer_email").val();
            var customer_phone = $("#customer_phone").val();
            var customer_address = $("#customer_address").val();
            var customer_city = $("#city").val();
            var customer_state = $("#state").val();
            var customer_zipcode = $("#customer_zipcode").val();
            var customer_country = $("#country").val();



            $.ajax({
                url: base_url + '/admin/addLeads',
                type: 'post',

                data: { exiting_customer: id, lead_id: lead_id, lead_customer_id: lead_customer_id, lead_maincat_name: lead_maincat_name, lead_subcat_name: lead_subcat_name, lead_assign_id: lead_assign_id, lead_value: lead_value, lead_source_id: lead_source_id, customer_name: customer_name, customer_company: customer_company, customer_email: customer_email, customer_phone: customer_phone, customer_address: customer_address, customer_city: customer_city, customer_state: customer_state, customer_zipcode: customer_zipcode, customer_country: customer_country, lead_description: lead_description,lead_commission:lead_commission },
                success: function (result) {
                    var Success = $.parseJSON(result);
                    if (Success.status == true) {
                        $.toast({
                            heading: Success.message,
                            position: 'top-right',
                            loaderBg: '#ff6849',
                            icon: 'success',
                            hideAfter: 3500,
                            stack: 6
                        });
                        table.ajax.reload();
                        $("#add_leads").modal('hide');
                    } else {
                        $.toast({
                            heading: Success.message,
                            position: 'top-right',
                            loaderBg: '#ff6849',
                            icon: 'error',
                            hideAfter: 3500,
                            stack: 6
                        });
                        table.ajax.reload();
                        $("#add_leads").modal('hide');
                    }
                }

            });

        } else {
            //alert("Values are not entered");
            //whatever you want to do when values are not entered
        }
        return false;
    });
})

$('#add_leads').on('hidden.bs.modal', function (e) {

    $('#add_lead').find("input[type=text], textarea").val("");
    $('#add_lead').find("input[type=hidden], textarea").val("");
    $('#add_lead').find("input[type=email], textarea").val("");
    $('#add_lead').find("input[type=number], textarea").val("");
    $('#add_lead').find("select, textarea").val("");
    $('#selcustomer').val(null).trigger('change');

    $('#lead_assign_id').val(null).trigger('change');

    removeError()
});
function removeError() {
    $("#lead_customer_id").removeClass("is-valid is-invalid");
    $("#lead_maincat_name").removeClass("is-valid is-invalid");
    $("#lead_subcat_name").removeClass("is-valid is-invalid");
    $("#lead_assign_id").removeClass("is-valid is-invalid");
    $("#lead_value").removeClass("is-valid is-invalid");

    $("#lead_commission").removeClass("is-valid is-invalid");
    $("#lead_source_id").removeClass("is-valid is-invalid");
    $("#lead_description").removeClass("is-valid is-invalid");
    $("#exiting_customer").removeClass("is-valid is-invalid");

    
    $("#lead_customer_id-error").remove();
    $("#lead_maincat_name-error").remove();
    $("#lead_subcat_name-error").remove();
    $("#lead_assign_id-error").remove();
    $("#lead_value-error").remove();
    $("#lead_commission-error").remove();
    $("#lead_source_id-error").remove();
    $("#lead_description-error").remove();
    $("#exiting_customer-error").remove();


    
}

$(document).ready(function () {
    $('select[name="lead_maincat_name"]').on('change', function () {
        let lead_main_cat = $(this).val();

        $.ajax({
            url: base_url + '/admin/getSubcategories',
            method: "POST",
            data: { selected: lead_main_cat },
            success: function (data) {
                $('#lead_subcat_name').html(data);

            }
        })
        $('select[name="lead_subcat_name"]').on('change', function () {

            var lead_maincat_name = $("#lead_maincat_name").val();

            var lead_subcat_name = $("#lead_subcat_name").val();
            $.ajax({
                url: base_url + "/admin/getvendor",
                type: 'post',
                data: { lead_maincat_name: lead_maincat_name, lead_subcat_name: lead_subcat_name },
                success: function (result) {

                    $('#lead_assign_id').html(result);

                }
            })
        })



    })

 

})


