$(document).ready(function () {
    table = $('#adminTableList').DataTable({
        processing: true,
        serverSide: true,
        displayStart: $('#page').val(),
        
        dom: 'Bfrtip',
        buttons: [
            'csv', 'excel'
        ],

        ajax: {
            url: base_url + "/admin/export",
            type: "POST",
            complete: function () {}
        }
    })
})