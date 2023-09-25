/**
 * Account Settings - Security
 */

"use strict";

document.addEventListener("DOMContentLoaded", function (e) {
  (function () {
    const formChangePass = document.querySelector("#formAccountSettings"),
      formApiKey = document.querySelector("#formAccountSettingsApiKey");
    const submitButton = formChangePass.querySelector('[type="submit"]');

    // Form validation for Change password
    if (formChangePass) {
      const fv = FormValidation.formValidation(formChangePass, {
        fields: {
          currentPassword: {
            validators: {
              notEmpty: {
                message: "Harap masukkan password sekarang",
              },
            },
          },
          newPassword: {
          validators: {
            notEmpty: {
              message: "Harap masukkan password anda",
            },
            stringLength: {
              min: 5,
              message: "Password harus lebih dari 5 karakter",
            },
          },
        },
          confirmPassword: {
            validators: {
              notEmpty: {
                message: "Harap masukkan konfirmasi password baru",
              },
              identical: {
                compare: function () {
                  return formChangePass.querySelector('[name="newPassword"]')
                    .value;
                },
                message: "Konfirmasi password tidak sama",
              },
            },
          },
        },
        plugins: {
          trigger: new FormValidation.plugins.Trigger(),
          bootstrap5: new FormValidation.plugins.Bootstrap5({
            eleValidClass: "",
            rowSelector: ".col-md-6",
          }),
          submitButton: new FormValidation.plugins.SubmitButton(),
          // Submit the form when all fields are valid
          // defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
          autoFocus: new FormValidation.plugins.AutoFocus(),
          fieldStatus: new FormValidation.plugins.FieldStatus({
            onStatusChanged: function (areFieldsValid) {
              areFieldsValid
                ? // Enable the submit button
                  // so user has a chance to submit the form again
                  submitButton.removeAttribute("disabled")
                : // Disable the submit button
                  submitButton.setAttribute("disabled", "disabled");
            },
          }),
        },
        init: (instance) => {
          instance.on("plugins.message.placed", function (e) {
            if (e.element.parentElement.classList.contains("input-group")) {
              e.element.parentElement.insertAdjacentElement(
                "afterend",
                e.messageElement
              );
            }
          });
        },
      }).on("core.form.valid", function (e) {
        changePassword();
        // formAuthentication.querySelector('button').removeAttribute("disabled");
      });
    }

    // Update/reset user image of account page
    let accountUserImage = document.getElementById("uploadedAvatar");
    const fileInput = document.querySelector(".account-file-input"),
      resetFileInput = document.querySelector(".account-image-reset");

    if (accountUserImage) {
      const resetImage = accountUserImage.src;
      fileInput.onchange = () => {
        if (fileInput.files[0]) {
          accountUserImage.src = window.URL.createObjectURL(fileInput.files[0]);
        }
      };
      resetFileInput.onclick = () => {
        fileInput.value = "";
        accountUserImage.src = resetImage;
      };
    }
  })();
});

// Select2 (jquery)
$(function () {
  var select2 = $(".select2");

  // Select2
  if (select2.length) {
    select2.each(function () {
      var $this = $(this);
      $this.wrap('<div class="position-relative"></div>');
      $this.select2({
        dropdownParent: $this.parent(),
      });
    });
  }
});

$(document).on("select2:open", () => {
  document
    .querySelector(".select2-container--open .select2-search__field")
    .focus();
});

let csrfName = $(".csrf_security").attr("name");

$(document).ready(function () {
  $("#birth_date").flatpickr({
    altInput: true,
    altFormat: "j F Y",
    dateFormat: "Y-m-d",
    onChange: (selectedDates, dateStr, instance) => {
      $(".birth_date>.is-invalid").removeClass("is-invalid");
      $(".birth_date").find("#form-error").html("");
    },
  });

  getProvince();

  $(".datatables-log-login").DataTable({
    destroy: true,
    responsive: true,
    processing: true,
    serverSide: true,
    // "searching" : false,
    // "dom": 'Blfrtip',
    order: [],
    columnDefs: [
      {
        orderable: false,
        targets: [4, 5],
      },
      {
        targets: [2],
        visible: false,
      },
      {
        // For Responsive
        className: "control",
        orderable: false,
        searchable: false,
        responsivePriority: 0,
        targets: 0,
        render: function (data, type, full, meta) {
          return "";
        },
      },
    ],
    ajax: {
      url: "/back/users/datatable_log_login",
      data: {
        id: $("#id").text(),
      },
      type: "POST",
    },
    // language: {
    //     url: '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Indonesian.json'
    //   },
    displayLength: 5,
    lengthMenu: [5, 10, 25, 50, 75, 100],
    responsive: {
      details: {
        display: $.fn.dataTable.Responsive.display.modal({
          header: function (row) {
            var data = row.data();
            return "Detail dari " + data[2];
          },
        }),
        type: "column",
        renderer: function (api, rowIdx, columns) {
          var data = $.map(columns, function (col, i) {
            return col.title !== "" // ? Do not show row in modal popup if title is blank (for check box)
              ? '<tr data-dt-row="' +
                  col.rowIndex +
                  '" data-dt-column="' +
                  col.columnIndex +
                  '">' +
                  "<td>" +
                  col.title +
                  ":" +
                  "</td> " +
                  "<td>" +
                  col.data +
                  "</td>" +
                  "</tr>"
              : "";
          }).join("");

          return data
            ? $('<table class="table"/><tbody />').append(data)
            : false;
        },
      },
    },
  });

  $(".datatables-log-login2").DataTable({
    destroy: true,
    responsive: true,
    processing: true,
    serverSide: true,
    // "searching" : false,
    // "dom": 'Blfrtip',
    order: [],
    columnDefs: [
      {
        orderable: false,
        targets: [4, 5],
      },
      {
        targets: [],
        visible: false,
      },
      {
        // For Responsive
        className: "control",
        orderable: false,
        searchable: false,
        responsivePriority: 2,
        targets: 0,
        render: function (data, type, full, meta) {
          return "";
        },
      },
    ],
    ajax: {
      url: "/back/users/datatable_log_login",
      type: "POST",
    },
    // language: {
    //     url: '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Indonesian.json'
    //   },
    responsive: {
      details: {
        display: $.fn.dataTable.Responsive.display.modal({
          header: function (row) {
            var data = row.data();
            return "Detail dari " + data[2];
          },
        }),
        type: "column",
        renderer: function (api, rowIdx, columns) {
          var data = $.map(columns, function (col, i) {
            return col.title !== "" // ? Do not show row in modal popup if title is blank (for check box)
              ? '<tr data-dt-row="' +
                  col.rowIndex +
                  '" data-dt-column="' +
                  col.columnIndex +
                  '">' +
                  "<td>" +
                  col.title +
                  ":" +
                  "</td> " +
                  "<td>" +
                  col.data +
                  "</td>" +
                  "</tr>"
              : "";
          }).join("");

          return data
            ? $('<table class="table"/><tbody />').append(data)
            : false;
        },
      },
    },
  });

  $(".datatables-log-history").DataTable({
    destroy: true,
    responsive: true,
    processing: true,
    serverSide: true,
    // "searching" : false,
    // "dom": 'Blfrtip',
    order: [],
    columnDefs: [
      {
        orderable: false,
        targets: [],
      },
      {
        targets: [0, 2, 3],
        visible: false,
      },
    ],
    ajax: {
      url: "/back/users/datatable_log_history",
      data: {
        id: $("#id").text(),
      },
      type: "POST",
    },
    displayLength: 5,
    lengthMenu: [5, 10, 25, 50, 75, 100],
  });

  $(".datatables-log-history2").DataTable({
    destroy: true,
    responsive: true,
    processing: true,
    serverSide: true,
    // "searching" : false,
    // "dom": 'Blfrtip',
    order: [],
    columnDefs: [
      {
        orderable: false,
        targets: [],
      },
      {
        targets: [],
        visible: false,
      },
      {
        // For Responsive
        className: "control",
        orderable: false,
        searchable: false,
        responsivePriority: 2,
        targets: 0,
        render: function (data, type, full, meta) {
          return "";
        },
      },
    ],
    ajax: {
      url: "/back/users/datatable_log_history",
      type: "POST",
    },
    // language: {
    //     url: '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Indonesian.json'
    //   },
    responsive: {
      details: {
        display: $.fn.dataTable.Responsive.display.modal({
          header: function (row) {
            var data = row.data();
            return "Detail dari " + data[2];
          },
        }),
        type: "column",
        renderer: function (api, rowIdx, columns) {
          var data = $.map(columns, function (col, i) {
            return col.title !== "" // ? Do not show row in modal popup if title is blank (for check box)
              ? '<tr data-dt-row="' +
                  col.rowIndex +
                  '" data-dt-column="' +
                  col.columnIndex +
                  '">' +
                  "<td>" +
                  col.title +
                  ":" +
                  "</td> " +
                  "<td>" +
                  col.data +
                  "</td>" +
                  "</tr>"
              : "";
          }).join("");

          return data
            ? $('<table class="table"/><tbody />').append(data)
            : false;
        },
      },
    },
  });
});

$("#province").change(function () {
  getCity();
});
$("#city").change(function () {
  getDistrict();
});
$("#district").change(function () {
  getVillage();
});
$("#village").change(function () {
  getPostalCode();
});

$("#form-edit").on("submit", function (e) {
  $("#btnUpdate")
    .html('<span class="spinner-border me-1"></span> Menyimpan...')
    .attr("disabled", true);
  e.preventDefault();
  const formData = new FormData(document.getElementById("form-edit"));
  // if($('#dropzone-basic')[0].dropzone.files.length > 0 ) {
  //     formData.append('attachment', $('#dropzone-basic')[0].dropzone.getAcceptedFiles()[0]);
  // }
  // if (myDropzone.getQueuedFiles().length > 0)
  // formData.append('isActive', document.getElementById("status").checked)

  $.ajax({
    url: "/back/users/update_profile",
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
        $("#modal-edit").modal("hide");
        toastr["success"](data.message.text, data.message.title);
        setTimeout(function () {
          window.location.href = window.location.href;
        }, 1500);
      } else {
        $.each(data, function (key, value) {
          // console.log(key+": "+value)
          if (value != "") {
            key == "birth_date"
              ? $("#" + key)
                  .next()
                  .addClass("is-invalid")
              : "";
            $("#" + key).addClass("is-invalid");
            $("." + key)
              .find("#form-error")
              .html(value);
          }
        });
        toastr["error"](data.message.text, data.message.title);
      }
      $("#btnUpdate").text("Simpan").attr("disabled", false);
    },

    error: function (jqXHR, textStatus, errorThrown) {
      toastr["error"](errorThrown, "Error");
      $("#btnUpdate").text("Simpan").attr("disabled", false);
    },
  });
});

$("#form-edit input").on("keyup", function () {
  if ($(this).val() == "") {
    $(this).removeClass("is-valid");
  } else {
    $(this).removeClass("is-invalid");
    $(this).parents(".col-12").find("#form-error").html(" ");
  }
});
$(
  "#form-edit select, #form-edit input[type=date], #form-edit input[type=radio]"
).on("change", function () {
  if ($(this).val() == "") {
    $(this).removeClass("is-valid");
  } else {
    $(this).removeClass("is-invalid");
    $(this).parents(".col-12").find("#form-error").html(" ");
  }
});
