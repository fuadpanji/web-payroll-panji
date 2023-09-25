/**
 * Payroll
 */

let id = $("#empId").text();
let month = $("#month").text();
let year = $("#year").text();

let empId = id == "" ? "semua" : id;
let monthYear =
    month == "" ? new Date().toISOString().slice(0, 7) : year + "-" + month;

// Select2
$(document).on("select2:open", () => {
    document
        .querySelector(".select2-container--open .select2-search__field")
        .focus();
});

var select2 = $(".select2");
if (select2.length) {
    select2.each(function () {
        var $this = $(this);
        $this.wrap('<div class="position-relative"></div>').select2({
            dropdownParent: $this.parent(),
        });
    });
}

("use strict");

// datatable (jquery)
$(function () {
    var dt_basic_table = $(".datatables-basic"),
        dt_basic;

    // DataTable with buttons
    // --------------------------------------------------------------------

    if (dt_basic_table.length) {
        dt_basic = dt_basic_table.DataTable({
            destroy: true,
            processing: true, //Feature control the processing indicator.
            serverSide: true, //Feature control DataTables' server-side processing mode.
            order: [], // to reset order by
            ajax: {
                url: "payroll/datatable_payroll",
                type: "POST",
                data: {
                    empId: empId,
                    monthYear: monthYear,
                },
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
                    // Label
                    targets: 5,
                    render: function (data, type, full, meta) {
                        var $status_number = full[5];
                        var $status = {
                            0: {
                                title: "Menunggu Pengesahan SPV",
                                class: " bg-label-secondary",
                            },
                            1: { title: "Disahkan SPV", class: " bg-label-success" },
                        };
                        if (typeof $status[$status_number] === "undefined") {
                            return data;
                        }
                        return (
                            '<span class="badge ' +
                            $status[$status_number].class +
                            '">' +
                            $status[$status_number].title +
                            "</span>"
                        );
                    },
                },
            ],
            //   order: [[2, 'desc']],
            dom: '<"row"<"col-sm-12 col-md-4"l><"col-sm-12 col-md-4 btnExport d-flex justify-content-center align-items-center"B><"col-sm-12 col-md-4 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            lengthMenu: [
                [25, 100, -1],
                [25, 100, "All"],
            ],
            pageLength: 25,
            buttons: [
                {
                    extend: "collection",
                    className: "btn btn-label-primary dropdown-toggle me-2",
                    text: '<i class="ti ti-file-export me-sm-1"></i> <span class="d-none d-sm-inline-block">Export</span>',
                    buttons: [
                        {
                            extend: "print",
                            orientation: "portrait",
                            text: '<i class="ti ti-printer me-1" ></i>Print',
                            className: "dropdown-item",
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5],
                                modifier: {
                                    search: "applied",
                                    order: "applied",
                                },
                                // prevent avatar to be display
                                format: {
                                    body: function (inner, coldex, rowdex) {
                                        if (inner.length <= 0) return inner;
                                        var el = $.parseHTML(inner);
                                        var result = "";
                                        $.each(el, function (index, item) {
                                            if (
                                                item.classList !== undefined &&
                                                item.classList.contains("user-name")
                                            ) {
                                                result = result + item.lastChild.firstChild.textContent;
                                            } else if (item.innerText === undefined) {
                                                result = result + item.textContent;
                                            } else result = result + item.innerText;
                                        });
                                        return result;
                                    },
                                },
                            },
                            customize: function (win) {
                                //customize print view for dark
                                $(win.document.body)
                                    .css("color", config.colors.headingColor)
                                    .css("border-color", config.colors.borderColor)
                                    .css("background-color", config.colors.bodyBg);
                                $(win.document.body)
                                    .find("table")
                                    .addClass("compact")
                                    .css("color", "inherit")
                                    .css("border-color", "inherit")
                                    .css("background-color", "inherit");
                            },
                        },
                        {
                            extend: "pdf",
                            text: '<i class="ti ti-file-description me-1"></i>Pdf',
                            orientation: "portrait",
                            className: "dropdown-item",
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5],
                                modifier: {
                                    search: "applied",
                                    order: "applied",
                                },
                                // prevent avatar to be display
                                format: {
                                    body: function (inner, coldex, rowdex) {
                                        if (inner.length <= 0) return inner;
                                        var el = $.parseHTML(inner);
                                        var result = "";
                                        $.each(el, function (index, item) {
                                            if (
                                                item.classList !== undefined &&
                                                item.classList.contains("user-name")
                                            ) {
                                                result = result + item.lastChild.firstChild.textContent;
                                            } else if (item.innerText === undefined) {
                                                result = result + item.textContent;
                                            } else result = result + item.innerText;
                                        });
                                        return result;
                                    },
                                },
                            },
                        },
                    ],
                },
                {
                    text: '<i class="ti ti-file-description me-1"></i> <span class=" btn-sm d-sm-inline-block">Download Payroll Bulanan</span>',
                    className: 'monthly-payroll btn btn-danger',
                    attr: {
                        "onclick": `export_payroll_monthly("${empId}", "${month}", "${year}")`,
                    },
                }
            ],
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function (row) {
                            var data = row.data();
                            return (
                                "Detail dari Payroll " + (data[3] != null ? data[3] : data[3])
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
        $("div.head-label").html('<h5 class="card-title mb-0">Data Payroll</h5>');
        $('.dt-buttons.btn-group.flex-wrap').removeClass('flex-wrap');
    }
});

function detail_payroll(id, monthYear) {
    $(".item-detail").attr("disabled", true).css("border-color", "#fff");
    $.ajax({
        url: "payroll/detail_payroll",
        type: "POST",
        dataType: "html",
        data: {
            id: id,
        },
        success: function (data) {
            $(".dtr-bs-modal").modal("hide");
            $("#tmpModal").html(data);
            $("#modal-detail").modal({
                backdrop: "static",
                keyboard: false,
            });
            $("#modal-detail").modal("show");
            //   $(".modal-detail-title").append(nama);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert("Error get data from ajax");
        },
    });
}

function print_payroll(id, monthYear, empName) {
    let url = `/back/payroll/print_payroll/${id}/${monthYear}`
    window.open(url, "_blank");
    // $(".item-print").attr("disabled", true).css("border-color", "#fff");
    // $.ajax({
    //     method: "POST",
    //     url: "payroll/print_payroll",
    //     data: {
    //         id: id,
    //         monthYear: monthYear,
    //     },
    //     async: true,
    //     success: function (data) {
    //         let url =
    //             `/assets/data/payroll/SlipGaji-` +
    //             empName +
    //             `-` +
    //             monthYear +
    //             `.pdf`;
    //         window.open(url, "_blank");
    //     },
    // });
}

function reload_table() {
    let table = $(".datatables-basic").DataTable();
    table.ajax.reload();
}

function generate_payroll() {
    $(".btn-generate").attr("disabled", true).css("border-color", "#fff");
    Swal.fire({
        title: "Generate payroll",
        text: "Apakah Anda yakin ingin melakukan generate payroll untuk bulan " + month + " tahun " + year + " ?",
        icon: "question",
        showDenyButton: false,
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya, Generate!",
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
                        url: "payroll/generate_payroll",
                        type: "POST",
                        data: {
                            month: month,
                            year: year
                        },
                        dataType: "JSON",
                        success: function (data) {
                            if (data.status) {
                                Swal.fire({
                                    title: "Berhasil..!!!",
                                    text: "Data payroll berhasil digenerate",
                                    icon: "success",
                                    timer: 1000,
                                    showConfirmButton: false,
                                });
                                $(".item-delete").attr("disabled", false);
                            } else {
                                Swal.fire({
                                    title: "Gagal..!!!",
                                    text: data.msg,
                                    icon: "error",
                                    timer: 1000,
                                    showConfirmButton: false,
                                });
                            }
                            $(".btn-generate").attr("disabled", false);
                            $(".dtr-bs-modal").modal("hide");
                            reload_table();
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            reject("Data payroll gagal digenerate..!!!");
                        },
                    });
                }, 1000);
            });
        },
        allowOutsideClick: false,
    }).then(function (data) {
        if (data.status) {
            Swal.fire({
                title: "Berhasil..!!!",
                text: "Data payroll berhasil digenerate",
                icon: "success",
                timer: 1000,
                showConfirmButton: false,
            });
        }
    });
    $(".swal2-cancel").click(function () {
        $(".btn-generate").attr("disabled", false);
    });
}

function export_payroll_monthly(empId, month, year) {
    $('.monthly-payroll').html('<span class="spinner-border me-1"></span> Memproses...').attr('disabled', true);
    // let url = `/back/payroll/export_payroll_monthly/${empId}/${month}/${year}`
    // window.open(url, "_blank");
    $.ajax({
        method: 'POST',
        url: 'payroll/export_payroll_monthly',
        data: {
            empId: empId,
            month: month,
            year: year
        },
        async: true,
        success: function (data) {
            setTimeout(() => {
                let url = `payroll/downloadPdf/${month}/${year}`;
                window.open(url, "_blank");
                $('.monthly-payroll').html('<i class="ti ti-file-description me-1"></i></i> <span class=" btn-sm d-sm-inline-block">Download Payroll Bulanan</span>').attr('disabled', false);
            }, 1000);
        }, error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}

$(document).ajaxComplete(function () {
    $(".btn-generate").attr("disabled", false);
    $(".item-detail").attr("disabled", false);
    $(".item-print").attr("disabled", false);
    $(".item-verify").attr("disabled", false);
});
