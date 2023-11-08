{{--page length--}}

<div class="row mx-2">
    <div class="col-sm-12 col-md-4 col-lg-6 my-2">
        <div class="dataTables_length" id="DataTables_Table_0_length"><label><select
                    name="DataTables_Table_0_length" aria-controls="DataTables_Table_0"
                    class="form-select">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="-1">Show All</option>
                </select></label></div>
    </div>
    <div class="col-sm-12 col-md-8 col-lg-6">
        <div
            class="dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-md-end justify-content-center align-items-center flex-sm-nowrap flex-wrap me-1">
            <div class="me-3">
                <div id="DataTables_Table_0_filter" class="dataTables_filter"><label>Search<input
                            type="search" class="form-control" placeholder="Search.."
                            aria-controls="DataTables_Table_0"></label></div>
            </div>
        </div>
    </div>
</div>
<hr class="mt-0">


{{-- column search --}}

<div class="card-body">
    <form class="dt_adv_search" method="POST">
        <div class="row">
            <div class="col-12">
                <div class="row g-3">
                    <div class="col-12 col-sm-6 col-lg-4">
                        <label class="form-label">Name:</label>
                        <input type="text" class="form-control dt-input dt-full-name" data-column=1
                               placeholder="Alaric Beslier" data-column-index="0">
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4">
                        <label class="form-label">Email:</label>
                        <input type="text" class="form-control dt-input" data-column=2
                               placeholder="demo@example.com" data-column-index="1">
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4">
                        <label class="form-label">Post:</label>
                        <input type="text" class="form-control dt-input" data-column=3
                               placeholder="Web designer" data-column-index="2">
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4">
                        <label class="form-label">City:</label>
                        <input type="text" class="form-control dt-input" data-column=4
                               placeholder="Balky" data-column-index="3">
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4">
                        <label class="form-label">Date:</label>
                        <div class="mb-0">
                            <input type="text" class="form-control dt-date flatpickr-range dt-input"
                                   data-column="5" placeholder="StartDate to EndDate"
                                   data-column-index="4" name="dt_date"/>
                            <input type="hidden" class="form-control dt-date start_date dt-input"
                                   data-column="5" data-column-index="4" name="value_from_start_date"/>
                            <input type="hidden" class="form-control dt-date end_date dt-input"
                                   name="value_from_end_date" data-column="5" data-column-index="4"/>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4">
                        <label class="form-label">Salary:</label>
                        <input type="text" class="form-control dt-input" data-column=6
                               placeholder="10000" data-column-index="5">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<hr class="mt-0">


