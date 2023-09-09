function CreateDataTable() {
    $('#dataTable').DataTable({
        paging: true, // Enable pagination
        pageLength: 10, // Number of rows per page
        responsive: true, // Enable responsive design
        // Add any additional configuration options as needed
        language: {
            emptyTable: "No records available", // Customize the "No record Found" message
        },
    });
}

function DestroyDataTable() {
    $('#dataTable').DataTable().destroy();
  }
