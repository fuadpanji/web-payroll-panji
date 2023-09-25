/**
 * Employee
 */

"use strict";
let fv, offCanvasEl, fullEditor;
document.addEventListener("DOMContentLoaded", function (e) {
    (function () {
        const formAddNewRecord = document.getElementById("form-add");
        const submitButton = formAddNewRecord.querySelector('[type="submit"]');
        const submitButtonDisabledAttribute = "disabled";

        $("#modal-add").modal({ backdrop: "static", keyboard: false });

        fv = FormValidation.formValidation(formAddNewRecord, {
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap5: new FormValidation.plugins.Bootstrap5({
                    eleValidClass: "",
                    rowSelector: ".col-12",
                }),
                submitButton: new FormValidation.plugins.SubmitButton(),
                autoFocus: new FormValidation.plugins.AutoFocus(),
                fieldStatus: new FormValidation.plugins.FieldStatus({
                    onStatusChanged: function (areFieldsValid) {
                        submitButton.disabled = !areFieldsValid;
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
        });
    })();

});

/* KeyUp Format Rupiah */
document.getElementById("basic_salary").addEventListener("keyup", function (e) {
    this.value = formatRupiah(this.value, "Rp. ");
});

document.getElementById("allowance").addEventListener("keyup", function (e) {
    this.value = formatRupiah(this.value, "Rp. ");
});

function formatRupiah(amount, prefix) {
    amount = amount.toString().replace(/\D/g, "");
    var rupiah = amount.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    return (prefix == undefined ? "" : "Rp. ") + rupiah;
}

// datatable (jquery)
$(function () {
    var dt_basic_table = $(".datatables-basic"),
        dt_basic;

    // DataTable with buttons
    // --------------------------------------------------------------------

    if (dt_basic_table.length) {
        dt_basic = dt_basic_table.DataTable({
            destroy: true,
            processing: true, // Feature control the processing indicator.
            serverSide: true, // Feature control DataTables' server-side processing mode.
            order: [], // to reset order by
            ajax: {
                url: "employee/datatable_employee",
                type: "POST",
            },
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
                        return (
                            `<button href="javascript:;" onclick="edit_data('${full[0]}')" class="btn btn-md btn-icon item-edit" title="Ubah"><i class="text-primary ti ti-pencil fs-4"></i></button>` +
                            `<button href="javascript:;" onclick="delete_data('${full[0]}')" class="btn btn-md btn-icon item-delete" title="Hapus"><i class="text-danger ti ti-trash fs-4"></i></button>`
                        );
                    },
                },
            ],
            //   order: [[2, 'desc']],
            dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            lengthMenu: [10, 25, 50, 75, 100],
            buttons: [
                {
                    text: '<i class="ti ti-plus me-sm-1"></i> <span class="d-sm-inline-block">Tambah Karyawan Baru</span>',
                    className: "create-new btn btn-primary",
                    attr: {
                        "data-bs-toggle": "modal",
                        "data-bs-target": "#modal-add",
                    },
                },
            ],
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function (row) {
                            var data = row.data();
                            return (
                                "Detail dari Karyawan " + (data[2] != null ? data[2] : data[3])
                            );
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
            '<h5 class="card-title mb-0">Data Karyawan</h5>'
        );
    }
});

function submitForm() {
    $("#btnAdd")
        .html('<span class="spinner-border me-1"></span> Menyimpan...')
        .attr("disabled", true);
    const formData = new FormData(document.getElementById("form-add"));

    $.ajax({
        url: "employee/create_employee",
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
                $("#modal-add").modal("hide");
                $("#form-add")[0].reset();
                reload_table();
            } else {
                $.each(data, function (key, value) {
                    // console.log(key+": "+value)
                    if (value != "") {
                        $("." + key).addClass("is-invalid");
                        $("." + key)
                            .parent(".col-12")
                            .find("#form-error")
                            .html(value);
                    }
                });
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

$("#form-add input").on("keyup", function () {
    if ($(this).val() == "") {
        $(this).removeClass("is-valid");
    } else {
        $(this).removeClass("is-invalid");
        $(this).parents(".col-12").find("#form-error").html(" ");
    }
});

$("#form-add select, #form-add input[type=radio]").on("change", function () {
    if ($(this).val() == "") {
        $(this).removeClass("is-valid");
    } else {
        $(this).removeClass("is-invalid");
        $(this).parents(".col-12").find("#form-error").html(" ");
    }
});

function edit_data(id) {
    $(".item-edit").attr("disabled", true).css("border-color", "#fff");
    $.ajax({
        url: "employee/update_employee_form",
        type: "POST",
        dataType: "html",
        data: {
            id: id,
        },
        success: function (data) {
            $(".dtr-bs-modal").modal("hide");
            $("#tmpModal").html(data);
            //   $("#form-edit")[0].reset();
            $("#modal-edit").modal({
                backdrop: "static",
                keyboard: false,
            });
            $("#modal-edit").modal("show");
            //   $(".modal-edit-title").append(nama);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert("Error get data from ajax");
            // $('.item-edit').attr('disabled', false);
        },
    });
}

function delete_data(id) {
    $(".item-delete").attr("disabled", true).css("border-color", "#fff");
    Swal.fire({
        title: "Apakah anda yakin akan menghapus data ini ?",
        // text: 'Anda akan menghapus data user "' + name + '"',
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
                        url: "employee/delete_employee",
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
