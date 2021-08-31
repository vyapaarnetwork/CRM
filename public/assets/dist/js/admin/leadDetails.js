$(document).ready(function () {
    $("#comment").on("click", function(){
        var comments = $("#comment_msg").val();
        var admin_m_id = $("#admin_m_id").val();
        var lead_m_id = $("#lead_m_id").val();


        $.ajax({
            url: base_url + "/admin/add_comments",
            type: 'post',
            data: { admin_m_id: admin_m_id, comments:comments ,lead_m_id:lead_m_id},
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



document.querySelector("#upload-button").addEventListener('click', async function() {
    let upload = await uploadFile();

    if(upload.error == 0) {
        $.toast({
            heading: 'File uploaded successfully',
            position: 'top-right',
            loaderBg: '#ff6849',
            icon: 'success',
            hideAfter: 3500,
            stack: 6
        });
        window.setTimeout(function(){location.reload()},2000);

    }
    else if(upload.error == 1)
        $.toast({
            heading: 'File uploading failed -'+upload.message,
            position: 'top-right',
            loaderBg: '#ff6849',
            icon: 'error',
            hideAfter: 3500,
            stack: 6
        });

});

// async function managing upload operation
async function uploadFile() {
    // function return value
    let return_data = { error: 0, message: '' };
    let leadID = $('#lead_m_id').val();

    try {
        // no file selected
        if(document.querySelector("#file-to-upload").files.length == 0) {
            throw new Error('No file selected');
        }
        else {
            // formdata
            let data = new FormData();
            data.append('lead_id', leadID);
            data.append('lead_documents', document.querySelector("#file-to-upload").files[0]);

            // send fetch along with cookies
            let response = await fetch(base_url + '/admin/leadFile', {
                method: 'POST',
                credentials: 'same-origin',
                body: data
            });

            // server responded with http response != 200
            if(response.status != 200)
                throw new Error('HTTP response code != 200');

            // read json response from server
            // success response example : {"error":0,"message":""}
            // error response example : {"error":1,"message":"File type not allowed"}
            let json_response = await response.json();
            if(json_response.error == 1)
                throw new Error(json_response.message);
        }
    }
    catch(e) {
        // catch rejected Promises and Error objects
        return_data = { error: 1, message: e.message };
    }

    return return_data;
}