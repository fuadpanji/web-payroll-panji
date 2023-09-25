/**
 * DataTables Basic
 */

"use strict";
let csrfName = $(".csrf_security").attr("name");
let fv, offCanvasEl;
document.addEventListener("DOMContentLoaded", function (e) {
  (function () {
    const formAddNewRecord = document.getElementById("form-add-new-record");
    const submitButton = formAddNewRecord.querySelector('[type="submit"]');

    setTimeout(() => {
      const newRecord = document.querySelector(".create-new"),
        offCanvasElement = document.querySelector("#add-new-record");

      // To open offCanvas, to add new record
      if (newRecord) {
        newRecord.addEventListener("click", function () {
          offCanvasEl = new bootstrap.Offcanvas(offCanvasElement);
          // Empty fields on offCanvas open
            (offCanvasElement.querySelector(".dt-username").value = ""),
            (offCanvasElement.querySelector(".dt-email").value = ""),
            (offCanvasElement.querySelector(".dt-password").value = ""),
            (offCanvasElement.querySelector(".dt-confirm-password").value = "");
          // Open offCanvas with form
          offCanvasEl.show();
        });
      }
    }, 200);

    // Form validation for Add new record
    fv = FormValidation.formValidation(formAddNewRecord, {
      fields: {
        role: {
          validators: {
            notEmpty: {
              message: "Harap pilih role user",
            },
          },
        },
        username: {
          validators: {
            notEmpty: {
              message: "Harap masukkan username",
            },
            regexp: {
              regexp: /^(?=[a-zA-Z0-9._-]{5,30}$)(?!.*[-_.]{2})[^_.].*[^-.]$/i,
              // https://stackoverflow.com/questions/12018245/regular-expression-to-validate-username
              message:
                "username hanya menerima alfa numerik, titik(.), tanda hubung (-) dan garis bawah (_) dengan minimal 5 karakter",
            },
          },
        },
        email: {
          validators: {
            notEmpty: {
              message: "Harap masukkan email",
            },
            emailAddress: {
              message: "Masukkan alamat email yang valid",
            },
          },
        },
        password: {
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
              message: "Harap masukkan konfirmasi password anda",
            },
            identical: {
              compare: function () {
                return formAddNewRecord.querySelector('[name="password"]')
                  .value;
              },
              message: "Konfirmasi password tidak sama dengan password",
            },
            stringLength: {
              min: 5,
              message: "Password harus lebih dari 5 karakter",
            },
          },
        },
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          // Use this for enabling/changing valid/invalid class
          // eleInvalidClass: '',
          eleValidClass: "",
          rowSelector: ".col-sm-12",
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
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
      submitForm();
      // formAuthentication.querySelector('button').removeAttribute("disabled");
    });

    // Revalidate Select2 input. For more info, plase visit the official plugin site: https://select2.org/
    $(formAddNewRecord.querySelector('[name="role"]')).on(
      "change",
      function () {
        // Revalidate the field when an option is chosen
        fv.revalidateField("role");
      }
    );

    // FlatPickr Initialization & Validation
    // flatpickr(formAddNewRecord.querySelector('[name="basicDate"]'), {
    //   enableTime: false,
    //   // See https://flatpickr.js.org/formatting/
    //   dateFormat: 'm/d/Y',
    //   // After selecting a date, we need to revalidate the field
    //   onChange: function () {
    //     fv.revalidateField('basicDate');
    //   }
    // });
  })();
});

// datatable (jquery)
$(function () {
  var dt_basic_table = $(".datatables-basic"),
    base_url = "<?= base_url(); ?>",
    dt_basic,
    action;

  // DataTable with buttons
  // --------------------------------------------------------------------

  if (dt_basic_table.length) {
    dt_basic = dt_basic_table.DataTable({
      //   language: {
      //         url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json"
      //     },
      destroy: true,
      processing: true, //Feature control the processing indicator.
      serverSide: true, //Feature control DataTables' server-side processing mode.
      order: [], // to reset order by
      ajax: {
        url: "users/datatable_users",
        //     data: {
        // 	    [csrfName]: $('.csrf_security').val()
        // 	},
        type: "POST",
        // success: function(data) {
        //   console.log(data)
        //   $('.csrf_security').val(data[0].csrf_token);
        // }
      },
      //     language: {
      //     url: '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Indonesian.json'
      //   },
      columnDefs: [
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
        {
          // Actions
          targets: -1,
          title: "Actions",
          orderable: false,
          searchable: false,
          render: function (data, type, full, meta) {
              action =
                `<button href="javascript:;" onclick="edit_data('${full[0]}', '${full[3]}')" class="btn btn-md btn-icon item-edit" title="Ubah"><i class="text-primary ti ti-pencil fs-4"></i></button>` +
                `<button href="javascript:;" onclick="delete_data('${full[0]}', '${full[3]}')" class="btn btn-md btn-icon item-delete" title="Hapus"><i class="text-danger ti ti-trash fs-4"></i></button>`;
            return (
              '<div class="d-inline-block">' + action
            );
          },
        },
      ],
      //   order: [[2, 'desc']],
      dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
      lengthMenu: [10, 25, 50, 75, 100],
      buttons: [
        // {
        //   extend: 'collection',
        //   className: 'btn btn-label-primary dropdown-toggle me-2',
        //   text: '<i class="ti ti-file-export me-sm-1"></i> <span class="d-none d-sm-inline-block">Export</span>',
        //   buttons: [
        //     {
        //       extend: 'print',
        //       text: '<i class="ti ti-printer me-1" ></i>Print',
        //       className: 'dropdown-item',
        //       exportOptions: {
        //         columns: [3, 4, 5, 6, 7],
        //         // prevent avatar to be display
        //         format: {
        //           body: function (inner, coldex, rowdex) {
        //             if (inner.length <= 0) return inner;
        //             var el = $.parseHTML(inner);
        //             var result = '';
        //             $.each(el, function (index, item) {
        //               if (item.classList !== undefined && item.classList.contains('user-name')) {
        //                 result = result + item.lastChild.firstChild.textContent;
        //               } else if (item.innerText === undefined) {
        //                 result = result + item.textContent;
        //               } else result = result + item.innerText;
        //             });
        //             return result;
        //           }
        //         }
        //       },
        //       customize: function (win) {
        //         //customize print view for dark
        //         $(win.document.body)
        //           .css('color', config.colors.headingColor)
        //           .css('border-color', config.colors.borderColor)
        //           .css('background-color', config.colors.bodyBg);
        //         $(win.document.body)
        //           .find('table')
        //           .addClass('compact')
        //           .css('color', 'inherit')
        //           .css('border-color', 'inherit')
        //           .css('background-color', 'inherit');
        //       }
        //     },
        //     {
        //       extend: 'csv',
        //       text: '<i class="ti ti-file-text me-1" ></i>Csv',
        //       className: 'dropdown-item',
        //       exportOptions: {
        //         columns: [3, 4, 5, 6, 7],
        //         // prevent avatar to be display
        //         format: {
        //           body: function (inner, coldex, rowdex) {
        //             if (inner.length <= 0) return inner;
        //             var el = $.parseHTML(inner);
        //             var result = '';
        //             $.each(el, function (index, item) {
        //               if (item.classList !== undefined && item.classList.contains('user-name')) {
        //                 result = result + item.lastChild.firstChild.textContent;
        //               } else if (item.innerText === undefined) {
        //                 result = result + item.textContent;
        //               } else result = result + item.innerText;
        //             });
        //             return result;
        //           }
        //         }
        //       }
        //     },
        //     {
        //       extend: 'excel',
        //       text: '<i class="ti ti-file-spreadsheet me-1"></i>Excel',
        //       className: 'dropdown-item',
        //       exportOptions: {
        //         columns: [3, 4, 5, 6, 7],
        //         // prevent avatar to be display
        //         format: {
        //           body: function (inner, coldex, rowdex) {
        //             if (inner.length <= 0) return inner;
        //             var el = $.parseHTML(inner);
        //             var result = '';
        //             $.each(el, function (index, item) {
        //               if (item.classList !== undefined && item.classList.contains('user-name')) {
        //                 result = result + item.lastChild.firstChild.textContent;
        //               } else if (item.innerText === undefined) {
        //                 result = result + item.textContent;
        //               } else result = result + item.innerText;
        //             });
        //             return result;
        //           }
        //         }
        //       }
        //     },
        //     {
        //       extend: 'pdf',
        //       text: '<i class="ti ti-file-description me-1"></i>Pdf',
        //       className: 'dropdown-item',
        //       exportOptions: {
        //         columns: [3, 4, 5, 6, 7],
        //         // prevent avatar to be display
        //         format: {
        //           body: function (inner, coldex, rowdex) {
        //             if (inner.length <= 0) return inner;
        //             var el = $.parseHTML(inner);
        //             var result = '';
        //             $.each(el, function (index, item) {
        //               if (item.classList !== undefined && item.classList.contains('user-name')) {
        //                 result = result + item.lastChild.firstChild.textContent;
        //               } else if (item.innerText === undefined) {
        //                 result = result + item.textContent;
        //               } else result = result + item.innerText;
        //             });
        //             return result;
        //           }
        //         }
        //       }
        //     },
        //     {
        //       extend: 'copy',
        //       text: '<i class="ti ti-copy me-1" ></i>Copy',
        //       className: 'dropdown-item',
        //       exportOptions: {
        //         columns: [3, 4, 5, 6, 7],
        //         // prevent avatar to be display
        //         format: {
        //           body: function (inner, coldex, rowdex) {
        //             if (inner.length <= 0) return inner;
        //             var el = $.parseHTML(inner);
        //             var result = '';
        //             $.each(el, function (index, item) {
        //               if (item.classList !== undefined && item.classList.contains('user-name')) {
        //                 result = result + item.lastChild.firstChild.textContent;
        //               } else if (item.innerText === undefined) {
        //                 result = result + item.textContent;
        //               } else result = result + item.innerText;
        //             });
        //             return result;
        //           }
        //         }
        //       }
        //     }
        //   ]
        // },
        {
          text: '<i class="ti ti-plus me-sm-1"></i> <span class="d-sm-inline-block">Tambah User Baru</span>',
          className: "create-new btn btn-primary",
        },
      ],
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return "Detail dari " + (data[2] != null ? data[2] : data[3]);
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
    $("div.head-label").html(
      '<h5 class="card-title mb-0">Data User</h5>'
    );
  }
});

function submitForm() {
  // $("#form-add-new-record").on('submit', (function(e) {
  $("#btnAdd")
    .html('<span class="spinner-border me-1"></span> Menyimpan...')
    .attr("disabled", true);
  const formData = new FormData(document.getElementById("form-add-new-record"));
  // formData.append('isActive', document.getElementById("status").checked);
  // e.preventDefault();

  $.ajax({
    url: "users/create_users",
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
        offCanvasEl.hide();
        reload_table();
      } else {
        toastr["error"](data.message.text, data.message.title);
      }
      $("#btnAdd").text("Tambah").attr("disabled", false);
    },

    error: function (jqXHR, textStatus, errorThrown) {
      toastr["error"](data.message.text, data.message.title);
      $("#btnAdd").text("Tambah").attr("disabled", false);
    },
  });

  // }));
}

function edit_data(id, nama) {
  $(".item-edit").attr("disabled", true).css("border-color", "#fff");
  $.ajax({
    url: "users/update_users_form",
    type: "POST",
    dataType: "html",
    data: {
      id: id,
      from: "admin",
    },
    success: function (data) {
      $(".dtr-bs-modal").modal("hide");
      $("#tmpModal").html(data);
      $("#form-edit")[0].reset();
      $("#modal-edit").modal({
        backdrop: "static",
        keyboard: false,
      });
      $("#modal-edit").modal("show");
      $(".modal-edit-title").append(nama);
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert("Error get data from ajax");
      // $('.item-edit').attr('disabled', false);
    },
  });
}

function delete_data(id, name) {
  $(".item-delete").attr("disabled", true).css("border-color", "#fff");
  Swal.fire({
    title: "Apakah anda yakin akan menghapus data ini ?",
    text: 'Anda akan menghapus data user "' + name + '"',
    icon: "question",
    showDenyButton: false,
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Ya, Hapus!",
    reverseButtons: true,
    //closeOnConfirm: false,
    showLoaderOnConfirm: true,
    didOpen: function () {
      $(".swal2-deny").remove();
    },
    preConfirm: function () {
      return new Promise(function (resolve, reject) {
        setTimeout(function () {
          $.ajax({
            url: "users/delete_users",
            type: "POST",
            data: {
              id: id,
              // [csrfName]: $('.csrf_security').val()
            },
            dataType: "JSON",
            success: function (data) {
              if (data.status) {
                Swal.fire({
                  title: "Berhasil dihapus..!!!",
                  text: "Data berhasil di dihapus",
                  icon: "success",
                  timer: 1000,
                  showConfirmButton: false,
                });
                $(".item-delete").attr("disabled", false);
              } else {
                Swal.fire({
                  title: "Gagal dihapus..!!!",
                  text: data.msg,
                  icon: "error",
                  timer: 1000,
                  showConfirmButton: false,
                });
                // $('.item-delete').attr('disabled', false);
              }
              $(".dtr-bs-modal").modal("hide");
              reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown) {
              reject("Data gagal dihapus..!!!");
              // $('.item-delete').attr('disabled', false);
            },
          });
        }, 1000);
      });
    },
    allowOutsideClick: false,
  }).then(function (data) {
    if (data.status) {
      Swal.fire({
        title: "Berhasil dihapus..!!!",
        text: "Data berhasil di dihapus",
        icon: "success",
        timer: 1000,
        showConfirmButton: false,
      });
    }
  });
  $(".swal2-cancel").click(function () {
    $(".item-delete").attr("disabled", false);
  });
}

function reload_table() {
  let table = $(".datatables-basic").DataTable();
  table.ajax.reload();
}

$(document).ajaxComplete(function () {
  $(".item-edit").attr("disabled", false);
  $(".item-delete").attr("disabled", false);
});
