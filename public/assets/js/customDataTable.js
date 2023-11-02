$(document).ready(function () {
    $('#dataTable').addClass('dataTable');
    $('.dataTable').addClass('w-100');
    // $('#dataTable').addClass('datatables-ajax');
});

function CreateDataTable() {
    var dataTable = $('.dataTable').DataTable({
        paging: true, // Enable pagination
        pageLength: 10, // Number of rows per page
        // responsive: true,
        scrollX: true,
        "autoWidth": true,
        // "order": [
        //     [2, 'asc']
        // ],
        // "rowGroup": {
        //     dataSrc: 2
        // },
        language: {
            emptyTable: "No records available", // Customize the "No record Found" message
        },
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

function DestroyDataTable() {
    $('.dataTable').DataTable().destroy();
}
