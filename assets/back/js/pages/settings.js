/**
 * Setting
 */

"use strict";
let csrfName = $(".csrf_security").attr("name");

$(document).ready(function () {
  $(document).on("select2:open", () => {
    document
      .querySelector(".select2-container--open .select2-search__field")
      .focus();
  });
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

  // Update/reset user image of account page
  let imageFavion = document.getElementById("uploadedFavicon");
  let imageLogo1 = document.getElementById("uploadedLogo1");

  const fileInputFavicon = document.querySelector(
      ".account-file-input-favicon"
    ),
    resetFileInputFavicon = document.querySelector(
      ".account-image-reset-favicon"
    ),
    fileInputLogo1 = document.querySelector(".account-file-input-logo1"),
    resetFileInputLogo1 = document.querySelector(".account-image-reset-logo1")

  if (imageFavion) {
    const resetImageFavicon = imageFavion.src;
    fileInputFavicon.onchange = () => {
      if (fileInputFavicon.files[0]) {
        imageFavion.src = window.URL.createObjectURL(fileInputFavicon.files[0]);
      }
    };
    resetFileInputFavicon.onclick = () => {
      fileInputFavicon.value = "";
      imageFavion.src = resetImageFavicon;
    };
  }
  if (imageLogo1) {
    const resetImageLogo1 = imageLogo1.src;
    fileInputLogo1.onchange = () => {
      if (fileInputLogo1.files[0]) {
        imageLogo1.src = window.URL.createObjectURL(fileInputLogo1.files[0]);
      }
    };
    resetFileInputLogo1.onclick = () => {
      fileInputLogo1.value = "";
      imageLogo1.src = resetImageLogo1;
    };
  }

  $("#form-edit").on("submit", function (e) {
    $(".btnSubmit")
      .html('<span class="spinner-border me-1"></span> Menyimpan...')
      .attr("disabled", true);
    const formData = new FormData(document.getElementById("form-edit"));
    e.preventDefault();

    $.ajax({
      url: "settings/update_settings",
      type: "POST",
      data: formData,
      dataType: "JSON",
      contentType: false,
      cache: false,
      processData: false,
      beforeSend: function () {
        $("#err").fadeOut();
      },

      success: function (data) {
        if (data.status) {
          toastr["success"](data.message.text, data.message.title);
          setTimeout(function () {
            window.location.href = window.location.href;
          }, 3000);
        } else {
          $.each(data, function (key, value) {
            // console.log(key+": "+value)
            if (value != "") {
              $("#" + key).addClass("is-invalid");
              $("#" + key)
                .parent(".col-md-6")
                .find("#form-error")
                .html(value);
            }
          });
          toastr["error"](data.message.text, data.message.title);
        }
        $(".btnSubmit").text("Simpan").attr("disabled", false);
      },

      error: function (jqXHR, textStatus, errorThrown) {
        toastr["error"](data.message.text, data.message.title);
        $(".btnSubmit").text("Simpan").attr("disabled", false);
      },
    });
  });

  $("#form-edit input, #form-edit textarea").on("keyup", function () {
    if ($(this).val() == "") {
      $(this).removeClass("is-valid");
    } else {
      $(this).removeClass("is-invalid");
      $(this).parents(".col-md-6").find("#form-error").html(" ");
    }
  });
  $("#form-edit select").on("change", function () {
    if ($(this).val() == "") {
      $(this).removeClass("is-valid");
    } else {
      $(this).removeClass("is-invalid");
      $(this).parents(".col-md-6").find("#form-error").html(" ");
    }
  });
});
