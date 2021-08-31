$(function () {
  'use strict';
  var spinnerfgp = new jQuerySpinner({
    parentId: 'vendorProfileImage'
  });
  $('#fileupload').fileupload({
    url: base_url + '/profilePicUpload',
    autoUpload: true,
    dataType: "json",
    submit:function () {
      spinnerfgp.show();
    },
    done: function (e, data) {
      spinnerfgp.hide();
      var response = data.result;
      if (response.status) {
        iziToast.show({
          theme: 'light',
          color: 'blue',
          position: 'bottomCenter',
          title: 'Success',
          transitionIn: 'flipInX',
          transitionOut: 'flipOutX',
          message: response.message,
        });
        $('#vendorProfileImage').attr("src",response.data);
      } else {
        iziToast.show({
          theme: 'light',
          color: 'red',
          position: 'bottomCenter',
          title: 'Error',
          transitionIn: 'flipInX',
          transitionOut: 'flipOutX',
          message: response.message,
        });
      }
    }
  });
});