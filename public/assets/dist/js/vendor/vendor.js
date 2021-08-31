$(document).ready(function () {
    table = $('#adminTableList').DataTable({
        processing: true,
        serverSide: true,
        displayStart: $('#page').val(),

        ajax: {
            url: base_url + "/vendor/listLeads",
            type: "POST",
            complete: function () {

            }
        }
    })
})



$(document).ready(function () {
    $("#comment").on("click", function(){
        var comments = $("#comment_msg").val();
        var lead_m_id = $("#lead_m_id").val();


        $.ajax({
            url: base_url + "/vendor/add_comments",
            type: 'post',
            data: {comments:comments ,lead_m_id:lead_m_id},
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
        window.setTimeout(function(){location.reload()},300)
    } else {
        $.toast({
            heading: Success.message,
            position: 'top-right',
            loaderBg: '#ff6849',
            icon: 'error',
            hideAfter: 3500,
            stack: 6
        });
        window.setTimeout(function(){location.reload()},300)
    }
            }
        })
    
    });
});

function change_status(id) {
    $('#status_modal').modal('show');
    $("#status_button").on("click", function(){
        var change_value = $("#change_value").val();
        var lead_id = $("#lead_id").val();


        $.ajax({
            url: base_url + "/admin/change_status",
            type: 'post',
            data: { lead_id: lead_id, lead_status: change_value },
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
        $("#status_modal").modal('hide');
        window.setTimeout(function(){location.reload()},1500)

    } else {
        $.toast({
            heading: Success.message,
            position: 'top-right',
            loaderBg: '#ff6849',
            icon: 'error',
            hideAfter: 3500,
            stack: 6
        });
        $("#status_modal").modal('hide');
        window.setTimeout(function(){location.reload()},1500)

    }
            }
        })
    
    });

}


function accept_lead(id) {
        let lead_id = $("#lead_id").val();


        $.ajax({
            url: base_url + "/vendor/accept_lead",
            type: 'post',
            data: {lead_id: lead_id},
            success: function (result) {
                                      
    let Success = $.parseJSON(result);
    if (Success.status == true) {
        $.toast({
            heading: Success.message,
            position: 'top-right',
            loaderBg: '#ff6849',
            icon: 'success',
            hideAfter: 3500,
            stack: 6
        });
        $("#status_modal").modal('hide');
        window.setTimeout(function(){location.reload()},1500)

    } else {
        $.toast({
            heading: Success.message,
            position: 'top-right',
            loaderBg: '#ff6849',
            icon: 'error',
            hideAfter: 3500,
            stack: 6
        });
        $("#status_modal").modal('hide');
        window.setTimeout(function(){location.reload()},1500)

    }
            }
        })
    

}
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
            url: base_url + "/vendor/getcustomer",
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
                url: base_url + '/vendor/CustomerEmail' + ($("#customer_email").val() ? '/' + $('#customer_email').val() : ''),
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
        let id = $("#exiting_customer").val();

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
            let id = $("#exiting_customer").val();
            let lead_id = $("#lead_id").val();
            let lead_customer_id = $("#selcustomer").val();
            let lead_maincat_name = $('select[name="lead_maincat_name"]').val();
            let lead_subcat_name = $('select[name="lead_subcat_name"]').val();
            let lead_assign_id = $('select[name="lead_assign_id"]').val();
            let lead_value = $("#lead_value").val();
            let lead_commission = $("#lead_commission").val();
            let self_assign = $("#self_assign").val();

            let lead_source_id = $('select[name="lead_source_id"]').val();
            let lead_description = $("#lead_description").val();

            // customer
            let customer_name = $("#customer_name").val();
            let customer_company = $("#customer_company").val();
            let customer_email = $("#customer_email").val();
            let customer_phone = $("#customer_phone").val();
            let customer_address = $("#customer_address").val();
            let customer_city = $("#customer_city").val();
            let customer_state = $("#customer_state").val();
            let customer_zipcode = $("#customer_zipcode").val();
            let customer_country = $("#customer_country").val();



            $.ajax({
                url: base_url + '/vendor/addLeads',
                type: 'post',

                data: { exiting_customer: id, lead_id: lead_id, lead_customer_id: lead_customer_id, lead_maincat_name: lead_maincat_name, lead_subcat_name: lead_subcat_name,self_assign: self_assign, lead_assign_id: lead_assign_id, lead_value: lead_value, lead_source_id: lead_source_id, customer_name: customer_name, customer_company: customer_company, customer_email: customer_email, customer_phone: customer_phone, customer_address: customer_address, customer_city: customer_city, customer_state: customer_state, customer_zipcode: customer_zipcode, customer_country: customer_country, lead_description: lead_description,lead_commission:lead_commission },
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
    $('#lead_maincat_name').on('change', function () {
        var lead_main_cat = $(this).val();

        $.ajax({
            url: base_url + '/vendor/getSubcategories',
            method: "POST",
            data: { selected: lead_main_cat },
            success: function (data) {
                $('#lead_subcat_name').html(data);

            }
        })
       



    })

    $("#forgetButton").click(function(e) {
        const vendor_email = $('#vendor_email').val();


        $.ajax({
            url: base_url + '/vendor/password/forgetPassword',
            type: 'post',
            data: { vendor_email: vendor_email },
            success: function (data) {
                const Success = $.parseJSON(data);
                if(Success.status == true) {
                    $.toast({
                        heading: Success.message,
                        position: 'top-right',
                        loaderBg: '#ff6849',
                        icon: 'success',
                        hideAfter: 3500,
                        stack: 6
                    });
                                    } else {
                    $.toast({
                        heading: Success.message,
                        position: 'top-right',
                        loaderBg: '#ff6849',
                        icon: 'error',
                        hideAfter: 3500,
                        stack: 6
                    });

                }

            }
        })
        e.preventDefault()

    });


});
