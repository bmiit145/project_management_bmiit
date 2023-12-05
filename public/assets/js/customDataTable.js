$(document).ready(function () {
    $('#dataTable').addClass('dataTable');
    $('.dataTable').addClass('w-100');

    // $('#dataTable').addClass('datatables-ajax');
});

// function CreateDataTable() {
//     var dataTable = $('#dataTable').DataTable({
//         paging: true, // Enable pagination
//         pageLength: 10, // Number of rows per page
//         // responsive: true,
//         scrollX: true,
//         "autoWidth": true,
//         // "order": [
//         //     [2, 'asc']
//         // ],
//         // "rowGroup": {
//         //     dataSrc: 2
//         // },
//         language: {
//             emptyTable: "No records available", // Customize the "No record Found" message
//         },
//     });
//
//     // dataTable
//     //     .on('order.dt search.dt', function () {
//     //         let i = 1;
//     //
//     //         dataTable
//     //             .cells(null, 0, {search: 'applied', order: 'applied'})
//     //             .every(function (cell) {
//     //                 this.data(i++);
//     //             });
//     //     })
//     //     .draw();
//
//     // $('#dataTable tbody').on('draw.dt', function () {
//     //     $('#yourDataTable tbody td').each(function () {
//     //         if ($(this).text() === 'NULL' || $(this).text() === 'null' || $(this).text() === 'Not Assigned') {
//     //             $(this).css('color', 'red');s
//     //         }
//     //     });
//     // });
//
//     return dataTable;
// }


function CreateDataTable(param) {

    // if param not passed
    if (param === undefined || param === null || param === '') {
        param = "dataTable";
    }

    var dataTable = $(document).find('#' + param).DataTable({
            paging: true, // Enable pagination
            pageLength: 10, // Number of rows per page
            // responsive: true,
            scrollX: true,
            "autoWidth": true,
            //for reorder
            rowReorder: true,
            // columnDefs: [
            //     {orderable: true, className: 'reorder', targets: 0},
            //     {orderable: false, targets: '_all'}
            // ],

            // length change
            lengthMenu: [
                [10, 25, 50, -1],
                ['10 rows', '25 rows', '50 rows', 'Show all']
            ],
            // dom: 'lBfrtip',
            dom: 'Brtip',
            buttons: [
                // {
                //     extend: 'pageLength',
                //     className: 'btn btn-label-primary dropdown-toggle',
                //
                // },
                'spacer',  // not a button, just an empty space
                {
                    extend: 'collection',
                    className: 'btn btn-label-primary dropdown dropdown-toggle',
                    autoClose: true,
                    text: '<i class="bx bx-export me-sm-1"></i> <span class="d-none d-sm-inline-block">Export</span>',
                    buttons: [{
                        extend: 'copy',
                        title: 'PMS - Project Management System',
                    }, {
                        extend: 'csv',
                        title: 'PMS - Project Management System',
                    }, {
                        extend: 'excel',
                        title: 'PMS - Project Management System',
                    }, {
                        extend: 'pdf',
                        pageSize: 'A4',
                        // orientation: 'landscape',
                        title: 'PMS - Project Management System',
                    }, {
                        extend: 'print',
                        title: 'PMS - Project Management System',
                    },
                    ]
                },
                // 'spacer',  // not a button, just an empty space
                // {
                //     extend: 'pdf',
                //     title: 'PMS - Project Management System',
                // }
                // 'colvis'
            ],
            // "order": [
            //     [2, 'asc']
            // ],
            // "rowGroup": {
            //     dataSrc: 2
            // },
            language:
                {
                    emptyTable: "No records available", // Customize the "No record Found" message
                }
            ,
            // select: true,
        });

    dataTable
        .on('order.dt search.dt', function () {
            let i = 1;

            dataTable
                .cells(null, 0, {search: 'applied', order: 'applied'})
                .every(function (cell) {
                    this.data(i++);
                });
        })
        .draw();


    $('#dataTable tbody').on('draw.dt', function () {
        $('#yourDataTable tbody td').each(function () {
            if ($(this).text() === 'NULL' || $(this).text() === 'null' || $(this).text() === 'Not Assigned') {
                $(this).css('color', 'red');
            }
        });
    });


    $('#DataTables_Table_0_filter input').on('keyup', function () {
        dataTable.search(this.value).draw();
    });

    $('#DataTables_Table_0_length select').on('change', function () {
        dataTable.page.len($(this).val()).draw();
    });

    return dataTable;
}


function CreateDataTableProject() {

    var dataTable = $(document).find('#dataTable').DataTable({
        paging: true, // Enable pagination
        pageLength: 10, // Number of rows per page
        responsive: true,
        scrollX: true,
        "autoWidth": true,
        "order": [
            [1, 'asc'], [2, 'asc'], [3, 'asc']
        ],
        "columnDefs": [
            {
                "targets": '_all', // Apply this to all columns
                "render": function (data) {
                    if (data === 'NULL' || data === 'null' || data === 'Not Assigned') {
                        return '<span style="color: red;">' + data + '</span>';
                    }
                    return data;
                }
            }
        ],
        "columnDefs": [
            {"visible": false, "targets": [1, 2, 5]} // Hide 'Group No.' and 'Project Title' columns
        ],

        "rowGroup": {
            dataSrc: function (row) {
                if (row[5] === 'NULL' || row[5] === 'null' || row[5] === 'Not Assigned') {
                    var temp = '<span style="color:red"> ' + row[5] + ' </span>'
                } else {
                    var temp = row[5];
                }
                return 'Course Year: <b>' + row[1] + '</b><br> Group <b>' + row[2] + '</b><br>  Project Title : <b>' + temp + '</b>';
            }
        },

        language:
            {
                emptyTable: "No records available", // Customize the "No record Found" message
            }
        ,
    });

    dataTable
        .on('order.dt search.dt', function () {
            let i = 1;

            dataTable
                .cells(null, 0, {search: 'applied', order: 'applied'})
                .every(function (cell) {
                    this.data(i++);
                });
        })
        .draw();
}

function DestroyDataTable(param) {

    if (param === undefined || param === null || param === '') {
        param = "dataTable";
    }

    $(document).find('#' + param).DataTable().destroy();
}


function ColumnSearch(className, table, column) {
    $(document).find(className).on('keyup', function () {
        table
            .api()
            .columns(column)
            .search(this.value)
            .draw();
    });
}


