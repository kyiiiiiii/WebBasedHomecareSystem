/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*********************************!*\
  !*** ./resources/js/cropper.js ***!
  \*********************************/
$(document).ready(function () {
  var cropper;
  var image = document.getElementById('image');

  // Change Event Listener for File Input
  $('#fileUpload').on('change', function (e) {
    console.log("File input changed");
    var files = e.target.files;
    var done = function done(url) {
      console.log("Image URL: ", url);
      image.src = url;
      $('#cropImageModal').modal('show'); // Trigger Modal Display
    };
    var reader;
    var file;
    var url;
    if (files && files.length > 0) {
      file = files[0];
      if (URL) {
        done(URL.createObjectURL(file));
      } else if (FileReader) {
        reader = new FileReader();
        reader.onload = function (e) {
          done(reader.result);
        };
        reader.readAsDataURL(file);
      }
    }
  });
  $('#cropImageModal').on('shown.bs.modal', function () {
    console.log("Modal shown");
    cropper = new Cropper(image, {
      aspectRatio: 1,
      viewMode: 3,
      ready: function ready() {
        var cropBoxData = cropper.getCropBoxData();
        var cropBoxSize = Math.min(cropBoxData.width, cropBoxData.height);
        cropper.setCropBoxData({
          left: (cropBoxData.width - cropBoxSize) / 2,
          top: (cropBoxData.height - cropBoxSize) / 2,
          width: cropBoxSize,
          height: cropBoxSize
        });
      },
      cropmove: function cropmove(event) {
        var cropBoxData = cropper.getCropBoxData();
        var cropBoxSize = Math.min(cropBoxData.width, cropBoxData.height);
        cropper.setCropBoxData({
          width: cropBoxSize,
          height: cropBoxSize
        });
      },
      cropend: function cropend(event) {
        var cropBoxData = cropper.getCropBoxData();
        var cropBoxSize = Math.min(cropBoxData.width, cropBoxData.height);
        cropper.setCropBoxData({
          width: cropBoxSize,
          height: cropBoxSize
        });
      }
    });
  }).on('hidden.bs.modal', function () {
    console.log("Modal hidden");
    cropper.destroy();
    cropper = null;
  });

  // Crop Button Click Event Listener
  $('#cropButton').on('click', function () {
    console.log("Crop button clicked");
    var canvas;
    if (cropper) {
      canvas = cropper.getCroppedCanvas({
        width: 200,
        height: 200,
        imageSmoothingEnabled: false,
        imageSmoothingQuality: 'high'
      });
      console.log("Canvas created:", canvas);
      canvas.toBlob(function (blob) {
        console.log("Blob created:", blob);
        var reader = new FileReader();
        reader.readAsDataURL(blob);
        reader.onloadend = function () {
          var base64data = reader.result;
          console.log("Base64 data:", base64data);

          // Remove the existing file input field
          $('#fileUpload').remove();

          // Append the base64 data as a hidden input field
          $('<input>').attr({
            type: 'hidden',
            name: 'profile_image',
            value: base64data
          }).appendTo('#profile-form');
          console.log("Form data prepared, submitting form");

          // Submit the form
          $('#profile-form').submit();
          $('#cropImageModal').modal('hide');
        };
      }, 'image/jpeg');
    } else {
      console.error("Cropper not initialized");
    }
  });
});
$(document).ready(function () {
  var cropper;
  var image = document.getElementById('image');

  // Change Event Listener for File Input
  $('#newFileUpload').on('change', function (e) {
    console.log("File input changed");
    var files = e.target.files;
    var done = function done(url) {
      console.log("Image URL: ", url);
      image.src = url;
      $('#newCropImageModal').modal('show'); // Trigger Modal Display
    };
    var reader;
    var file;
    var url;
    if (files && files.length > 0) {
      file = files[0];
      if (URL) {
        done(URL.createObjectURL(file));
      } else if (FileReader) {
        reader = new FileReader();
        reader.onload = function (e) {
          done(reader.result);
        };
        reader.readAsDataURL(file);
      }
    }
  });
  $('#newCropImageModal').on('shown.bs.modal', function () {
    console.log("Modal shown");
    cropper = new Cropper(image, {
      aspectRatio: 1,
      viewMode: 3,
      ready: function ready() {
        var cropBoxData = cropper.getCropBoxData();
        var cropBoxSize = Math.min(cropBoxData.width, cropBoxData.height);
        cropper.setCropBoxData({
          left: (cropBoxData.width - cropBoxSize) / 2,
          top: (cropBoxData.height - cropBoxSize) / 2,
          width: cropBoxSize,
          height: cropBoxSize
        });
      },
      cropmove: function cropmove(event) {
        var cropBoxData = cropper.getCropBoxData();
        var cropBoxSize = Math.min(cropBoxData.width, cropBoxData.height);
        cropper.setCropBoxData({
          width: cropBoxSize,
          height: cropBoxSize
        });
      },
      cropend: function cropend(event) {
        var cropBoxData = cropper.getCropBoxData();
        var cropBoxSize = Math.min(cropBoxData.width, cropBoxData.height);
        cropper.setCropBoxData({
          width: cropBoxSize,
          height: cropBoxSize
        });
      }
    });
  }).on('hidden.bs.modal', function () {
    console.log("Modal hidden");
    cropper.destroy();
    cropper = null;
  });

  // Crop Button Click Event Listener
  $('#cropButton').on('click', function () {
    console.log("Crop button clicked");
    var canvas;
    if (cropper) {
      canvas = cropper.getCroppedCanvas({
        width: 200,
        height: 200,
        imageSmoothingEnabled: false,
        imageSmoothingQuality: 'high'
      });
      console.log("Canvas created:", canvas);
      canvas.toBlob(function (blob) {
        console.log("Blob created:", blob);
        var reader = new FileReader();
        reader.readAsDataURL(blob);
        reader.onloadend = function () {
          var base64data = reader.result;
          console.log("Base64 data:", base64data);

          // Remove the existing file input field
          $('#newFileUpload').remove();

          // Append the base64 data as a hidden input field
          $('<input>').attr({
            type: 'hidden',
            name: 'profile_image',
            value: base64data
          }).appendTo('#new-profile-form');
          console.log("Form data prepared, submitting form");

          // Submit the form
          $('#new-profile-form').submit();
          $('#newCropImageModal').modal('hide');
        };
      }, 'image/jpeg');
    } else {
      console.error("Cropper not initialized");
    }
  });
});
$(document).ready(function () {
  var cropper;
  var image = document.getElementById('image');

  // Change Event Listener for File Input
  $('#patientFileUpload').on('change', function (e) {
    console.log("File input changed");
    var files = e.target.files;
    var done = function done(url) {
      console.log("Image URL: ", url);
      image.src = url;
      $('#patientCropImageModal').modal('show'); // Trigger Modal Display
    };
    var reader;
    var file;
    if (files && files.length > 0) {
      file = files[0];
      if (URL) {
        done(URL.createObjectURL(file));
      } else if (FileReader) {
        reader = new FileReader();
        reader.onload = function (e) {
          done(reader.result);
        };
        reader.readAsDataURL(file);
      }
    }
  });
  $('#patientCropImageModal').on('shown.bs.modal', function () {
    console.log("Modal shown");
    cropper = new Cropper(image, {
      aspectRatio: 1,
      viewMode: 3,
      ready: function ready() {
        var cropBoxData = cropper.getCropBoxData();
        var cropBoxSize = Math.min(cropBoxData.width, cropBoxData.height);
        cropper.setCropBoxData({
          left: (cropBoxData.width - cropBoxSize) / 2,
          top: (cropBoxData.height - cropBoxSize) / 2,
          width: cropBoxSize,
          height: cropBoxSize
        });
      },
      cropmove: function cropmove(event) {
        var cropBoxData = cropper.getCropBoxData();
        var cropBoxSize = Math.min(cropBoxData.width, cropBoxData.height);
        cropper.setCropBoxData({
          width: cropBoxSize,
          height: cropBoxSize
        });
      },
      cropend: function cropend(event) {
        var cropBoxData = cropper.getCropBoxData();
        var cropBoxSize = Math.min(cropBoxData.width, cropBoxData.height);
        cropper.setCropBoxData({
          width: cropBoxSize,
          height: cropBoxSize
        });
      }
    });
  }).on('hidden.bs.modal', function () {
    console.log("Modal hidden");
    cropper.destroy();
    cropper = null;
  });

  // Crop Button Click Event Listener
  $('#cropButton').on('click', function () {
    console.log("Crop button clicked");
    var canvas;
    if (cropper) {
      canvas = cropper.getCroppedCanvas({
        width: 200,
        height: 200,
        imageSmoothingEnabled: false,
        imageSmoothingQuality: 'high'
      });
      console.log("Canvas created:", canvas);
      canvas.toBlob(function (blob) {
        console.log("Blob created:", blob);
        var reader = new FileReader();
        reader.readAsDataURL(blob);
        reader.onloadend = function () {
          var base64data = reader.result;
          console.log("Base64 data:", base64data);

          // Remove the existing file input field
          $('#patientFileUpload').remove();

          // Append the base64 data as a hidden input field
          $('<input>').attr({
            type: 'hidden',
            name: 'profile_image',
            value: base64data
          }).appendTo('#patient-profile-form');
          console.log("Form data prepared, submitting form");

          // Submit the form
          $('#patient-profile-form').submit();
          $('#patientCropImageModal').modal('hide');
        };
      }, 'image/jpeg');
    } else {
      console.error("Cropper not initialized");
    }
  });
});
/******/ })()
;