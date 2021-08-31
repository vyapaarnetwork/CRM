$(document).ready(function () {
    var productLoader = new jQuerySpinner({
        parentId: 'Product'
    });
    table = $('#productTableList').DataTable({
        processing: true,
        serverSide: true,
        displayStart: $('#page').val(),
        ajax: {
            url: base_url + "/productList",
            type: "POST",
            complete: function () {
            }
        }
    });
    $('#Product').iziModal({
        title: 'Product Details',
        width: 900,
        headerColor: '#0063d1',
    });
    $('#ProductCatlog').iziModal({
        title: 'Product Catlog',
        width: 600,
        headerColor: '#0063d1',
    });
    $('#productAdd').click(function () {
        $('#Product').iziModal('open');
    });
    var productCatlog = new Dropzone(".dropzone", {
        url: base_url + "/productCatlogUpload",
        uploadMultiple: true,
        parallelUploads: 7,
        maxFiles: 7,
        resizeWidth: 640,
        resizeHeight: 420,
        resizeQuality: 0.5,
        acceptedFiles: 'image/jpg,image/png,image/gif,image/jpeg',
        addRemoveLinks: true,
        maxfilesexceeded: function (file) {
        },
        removedfile: function (file) {
            var id = file.serverID;
            var path = file.path;
            if (!file.status) {
                duDialog('Confirm', 'Are You Sure You Want To Remove This Image?', {
                    init: true,
                    dark: false,
                    buttons: duDialog.OK_CANCEL,
                    okText: 'Yes',
                    cancelText: 'No',
                    callbacks: {
                        okClick: function (e) {
                            this.hide()
                            $.ajax({
                                type: 'POST',
                                url: base_url + '/deleteCatlogImage',
                                data: { id: id, file: path },
                                success: function (result) {
                                    var Delete = $.parseJSON(result);
                                    if (Delete.status) {
                                        table.ajax.reload();
                                    }
                                }
                            });
                        }
                    }
                }).show()
                productCatlog.options.maxFiles = productCatlog.options.maxFiles + 1;
            }
        }
    });
    productCatlog.on('sending', function (file, xhr, formData) {
        formData.append('id', $('#spm_id').val());
    });
    $.validator.addMethod("lessThan",
        function (value, element, param) {
            var $otherElement = $(param);
            return parseInt(value, 10) < parseInt($otherElement.val(), 10);
        }
    );
    $("#productDetails").validate({
        errorElement: "small",
        errorClass: "text-danger",
        ignore: '.ignore',
        rules: {
            productName: "required",
            productImage: "required",
            productPrice: {
                required: true,
                number: true,
            },
            productSellPrice: {
                required: true,
                number: true,
                lessThan: '#productPrice'
            },
            productDescription: {
                required: true,
                minlength: 30,
                maxlength: 400
            },
        },
        messages: {
            productName: "Product Name Is Requider.",
            productImage: "Product Image Is Requider.",
            productPrice: {
                required: 'Product Price Is Requider.',
                number: 'Product Price Only In Numbers.',
            },
            productSellPrice: {
                required: 'Product Sell Price Is Requider.',
                number: 'Product Sell Price Only In Numbers.',
                lessThan: 'Product Sell Price Less Then Product Price.'
            },
            productDescription: {
                required: 'Product Description Is Requider.',
                minlength: 'Min Characters Allow 30 Only.',
                maxlength: 'Max Characters Allow 400 Only.'
            },
        },
        highlight: function (element) {
            $(element).addClass("is-invalid").removeClass('is-valid');
        },
        unhighlight: function (element) {
            $(element).addClass("is-valid").removeClass("is-invalid");
        },
        submitHandler: function (form) {
            var formData = new FormData(form);
            $.ajax({
                url: base_url + '/productDetails',
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                success: function (result) {
                    var response = $.parseJSON(result);
                    if (response.status) {
                        iziToast.show({
                            theme: 'light',
                            color: 'blue',
                            position: 'bottomCenter',
                            title: 'Success',
                            message: response.message
                        });
                        table.ajax.reload();
                        $('#spm_id').val(response.data);
                        $("#Product").iziModal('close');
                        $("#ProductCatlog").iziModal('open');
                    } else {
                        iziToast.show({
                            theme: 'light',
                            color: 'red',
                            position: 'bottomCenter',
                            title: 'Error',
                            message: response.message,
                        });
                    }
                }
            });
        }
    });
});
