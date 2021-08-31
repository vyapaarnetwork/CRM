$(document).ready(function () {
    table = $('#leadTableList').DataTable({
        processing: true,
        serverSide: true,
        displayStart: $('#page').val(),
        ajax: {
            url: base_url + "/leadList",
            type: "POST",
            complete: function () {
            }
        }
    });
});