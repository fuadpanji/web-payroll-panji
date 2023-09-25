/**
 * File Upload
 */

'use strict';

(function () {
  // previewTemplate: Updated Dropzone default previewTemplate
  // ! Don't change it unless you really know what you are doing
  const previewTemplate = `<div class="dz-preview dz-file-preview">
<div class="dz-details">
  <div class="dz-thumbnail">
    <img data-dz-thumbnail>
    <span class="dz-nopreview">No preview</span>
    <div class="dz-success-mark"></div>
    <div class="dz-error-mark"></div>
    <div class="dz-error-message"><span data-dz-errormessage></span></div>
    <div class="progress">
      <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuemin="0" aria-valuemax="100" data-dz-uploadprogress></div>
    </div>
  </div>
  <div class="dz-filename" data-dz-name></div>
  <div class="dz-size" data-dz-size></div>
</div>
</div>`;

  // ? Start your code from here

  // Basic Dropzone
  // --------------------------------------------------------------------
  
  Dropzone.options.fileUpload = {
        url: "/Account/Create",
        autoProcessQueue: false,
        parallelUploads: 1,
        maxFilesize: 5,
        addRemoveLinks: true,
        maxFiles: 1,
        acceptedFiles: "image/*,application/pdf",
        
    
        init: function () {
    
            var submitButton = document.querySelector("#submit-all");
            var wrapperThis = this;
    
            submitButton.addEventListener("click", function () {
                wrapperThis.processQueue();
            });
    
            this.on("addedfile", function (file) {
    
                // Create the remove button
                var removeButton = Dropzone.createElement("<button class='btn btn-lg dark'>Remove File</button>");
    
                // Listen to the click event
                removeButton.addEventListener("click", function (e) {
                    // Make sure the button click doesn't submit the form:
                    e.preventDefault();
                    e.stopPropagation();
    
                    // Remove the file preview.
                    wrapperThis.removeFile(file);
                    // If you want to the delete the file on the server as well,
                    // you can do the AJAX request here.
                });
    
                // Add the button to the file preview element.
                file.previewElement.appendChild(removeButton);
            });
    
            this.on('sendingmultiple', function (data, xhr, formData) {
                formData.append("Username", $("#Username").val());
            });
        }
    };

  const myDropzone = new Dropzone('#dropzone-basic', {
    url: "/",
    autoProcessQueue: true,
    previewTemplate: previewTemplate,
    parallelUploads: 1,
    maxFilesize: 3,
    // addRemoveLinks: true,
    maxFiles: 1,
    acceptedFiles: "image/*",
    
    init: function () {
    
        let wrapperThis = this;

        this.on("addedfile", function (file) {
            // Create the remove button
            let removeButton = Dropzone.createElement("<a class='dz-remove' style='cursor: pointer;'>Hapus File</a>");
            // Listen to the click event
            removeButton.addEventListener("click", function (e) {
                // Make sure the button click doesn't submit the form:
                e.preventDefault();
                e.stopPropagation();
                
                // Remove the file preview.
                wrapperThis.removeFile(file);
            });
            // these image appends are getting dropzones instances
            // setTimeout(function() {
                
            // Add the button to the file preview element.
            file.previewElement.appendChild(removeButton);
        });

    }
  });

  // Multiple Dropzone
  // --------------------------------------------------------------------
//   const dropzoneMulti = new Dropzone('#dropzone-multi', {
//     previewTemplate: previewTemplate,
//     parallelUploads: 1,
//     maxFilesize: 5,
//     addRemoveLinks: true
//   });
})();
