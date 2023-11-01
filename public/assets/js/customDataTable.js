$(document).ready(function () {
    $('#dataTable').addClass('dataTable');
    // $('#dataTable').addClass('datatables-ajax');
});

function CreateDataTable() {
    dataTable = $('.dataTable').DataTable({
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

    return dataTable;
}

function DestroyDataTable() {
    $('.dataTable').DataTable().destroy();
}
