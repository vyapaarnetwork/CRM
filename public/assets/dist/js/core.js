$(document).ready(function () {
    $('select[name="country"]').on('change', function () {
        let customer_country = $(this).val();

        $.ajax({
            url: base_url + '/get/state',
            method: "POST",
            data: { country_id: customer_country },
            success: function (data) {
                $('#state').html(data);

            }
        })
        $('select[name="state"]').on('change', function () {

            let customer_state = $("#state").val();

            $.ajax({
                url: base_url + "/get/city",
                type: 'post',
                data: { customer_state: customer_state},
                success: function (result) {

                    $('#city').html(result);

                }
            })
        })



    })



})
// Assign Lead
function assign_lead(id) {
    $('#assign_lead').modal('show');
    $('#assign_label').text('Edit Categories');
    $.ajax({
        url: base_url + "/admin/getvendor",
        type: 'post',
        data: "id=" + id,
        success: function (result) {

            $('#get_vendor').html(result);

        }
    })
    $.ajax({
        url: base_url + "/admin/reflead",
        type: 'post',
        data: "id=" + id,
        success: function (result) {

            $('#ref_com').html(result);

        }
    })
    $('#get_vendor').on('change', function () {


        let id = $(this).val();
        $.ajax({
            url: base_url + "/admin/getcomm",
            type: 'post',
            data: "getcomm=" + id,
            success: function(result) {
                let edit = $.parseJSON(result);
                if (edit.status) {
                    $("#assign_com").val(edit.data[0].vendor_commission)


                } else {
                    $("#errorReturn").show().text(edit.message);
                }
            }
        })

    });
    $("#assign_button").on("click", function () {
        let assign_id = $("#get_vendor").val();
        let lead_commission = $("#lead_commission").val();
        let lead_v_commission = $('#lead_v_commission').val();

        $.ajax({
            url: base_url + "/admin/assign_lead",
            type: 'post',
            data: { lead_id: id, lead_assign_id: assign_id,lead_commission:lead_commission,lead_v_commission:lead_v_commission },
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
                    $("#assign_lead").modal('hide');
                } else {
                    $.toast({
                        heading: Success.message,
                        position: 'top-right',
                        loaderBg: '#ff6849',
                        icon: 'error',
                        hideAfter: 3500,
                        stack: 6
                    });
                    $("#assign_lead").modal('hide');
                }
                setTimeout(function(){ location.reload(); }, 4000);

            }
        })

    });

}
$('#lead_assign_id').select2()

$('select[name="lead_assign_id"]').on('change', function () {
    let id = $(this).val();
    $.ajax({
        url: base_url + "/admin/getcomm",
        type: 'post',
        data: "getcomm=" + id,
        success: function(result) {
            let edit = $.parseJSON(result);
            if (edit.status) {
                $("#lead_commission").val(edit.data[0].vendor_commission)


            } else {
                $("#errorReturn").show().text(edit.message);
            }
        }
    })

});