@extends('../template/layout')

@section('title', 'Admin Dashboard | PMS')

<!-- @section('content')
@endsection -->

@section('body')

    <div class="row">
        <div class="col-md-6">

            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Add new Panel</h5>
                        <!-- <small class="text-muted float-end">Merged input group</small> -->
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('panel.add') }}" id="addPanelForm">
                            @csrf
                            <span id="error_info">

                            </span>
                            <div class="mb-3">
                                <label for="courseYear" class="form-label">Course Year</label>
                                <select class="form-select selectSearch" id="courseYear" name="courseYearId"
                                        aria-label="Default select example">
                                    <option value="-1" selected>select Course Year</option>
                                    @foreach ($courseYears as $courseYear)
                                        <option
                                            value="{{ $courseYear->id }}">{{$courseYear->course->code ."  ". $courseYear->course->name ." - " . $courseYear->year->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <label id="courseYear-error" class="error" for="courseYear"
                                       style="display: none"></label>
                            </div>
                            <div class="mb-3">
                                <label for="member" class="form-label">Faculty</label>
                                <div class="member_select_div">
                                    <select class="form-select selectSearch unique-dropdown member-dropdown my-4"
                                            id="member"
                                            name="members[]"
                                            aria-label="Default select example">
                                        <option value="-1" selected>select Faculty for panel</option>
                                        @foreach ($faculties as $faculty)
                                            <option
                                                value="{{ $faculty->id }}">{{ $faculty->fname . " ". $faculty->lname }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <label id="member-error" class="error" for="member"
                                       style="display: none"></label><br>
                                <button type="button" class="btn btn-dark mt-2 add_member">Add Faculty</button>
                            </div>
                            <button type="submit" class="btn btn-primary">Add new Panel</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- </div>  -->
        </div>

    </div>
    <div class="row">

        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header "><strong> Panel List</strong></h5>

                <div class="card-datatable  table-responsive text-nowrap p-2">

                    {{--                Search --}}
                    <div class="row mx-2 my-2">
                        <div class="col-sm-12 col-md-4 col-lg-6">
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
                                    <div id="DataTables_Table_0_filter" class="dataTables_filter"><label><input
                                                type="search" class="form-control" placeholder="Search.."
                                                aria-controls="DataTables_Table_0"></label></div>
                                </div>
                            </div>
                        </div>
                        {{--                        <hr class="mt-0">--}}
                    </div>
                    <table class="table table-hover table-responsive dataTable text-nowrap"
                           id="dataTable">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Panel Number</th>
                            <th>Faculty Name</th>
                            <th>Course</th>
                            <th>Year</th>
                            {{--                            <th>Status</th>--}}
                            {{--                            <th>Actions</th>--}}
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        @if (count($PresentationPanels) != 0)
                            @foreach ( $PresentationPanels as $key => $PresentationPanel)
                                <tr>
                                    <td>
                                        <strong>{{ ++$key }}</strong>
                                    </td>
                                    <td>
                                        <strong>{{ $PresentationPanel->panel->number}}</strong>
                                    </td>
                                    <td>
                                        <strong>{{ $PresentationPanel->faculty->fname . ' ' . $PresentationPanel->faculty->lname  }}</strong>
                                    </td>
                                    <td>
                                        <strong>{{ $PresentationPanel->courseYear->course->name }}</strong>
                                    </td>

                                    <td>
                                        <strong>{{ $PresentationPanel->courseYear->year->name }}</strong>
                                    </td>

                                    {{--                                    <td>--}}
                                    {{--                                    @if ($program->status == 1)--}}
                                    {{--                                        <td id="status"><span class="badge bg-label-primary me-1">Active</span></td>--}}
                                    {{--                                    @else--}}
                                    {{--                                        <td id="status"><span class="badge bg-label-danger me-1">InActive</span></td>--}}
                                    {{--                                        @endif--}}
                                    {{--                                        </td>--}}
                                    {{--                                        <td>--}}
                                    {{--                                            <div class="dropdown">--}}
                                    {{--                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"--}}
                                    {{--                                                        data-bs-toggle="dropdown">--}}
                                    {{--                                                    <i class="bx bx-dots-vertical-rounded"></i>--}}
                                    {{--                                                </button>--}}
                                    {{--                                                <div class="dropdown-menu">--}}
                                    {{--                                                    <a class="dropdown-item" href="javascript:void(0);"><i--}}
                                    {{--                                                            class="bx bx-edit-alt me-1"></i>--}}
                                    {{--                                                        Edit</a>--}}
                                    {{--                                                    @if ($program->status == 1)--}}
                                    {{--                                                        <a class="dropdown-item" href="javascript:void(0);"--}}
                                    {{--                                                           id="changeStatus"--}}
                                    {{--                                                           data-username="{{ $program->code }}"--}}
                                    {{--                                                           data-status="{{ $program->status }}"><i--}}
                                    {{--                                                                class="bx bx-refresh"></i>--}}
                                    {{--                                                            <span>Inactive</span></a>--}}
                                    {{--                                                    @else--}}
                                    {{--                                                        <a class="dropdown-item" href="javascript:void(0);"--}}
                                    {{--                                                           id="changeStatus"--}}
                                    {{--                                                           data-username="{{ $program->code }}"--}}
                                    {{--                                                           data-status="{{ $program->status }}"><i--}}
                                    {{--                                                                class="bx bx-refresh"></i>--}}
                                    {{--                                                            <span>Active</span></a>--}}
                                    {{--                                                    @endif--}}

                                    {{--                                                </div>--}}
                                    {{--                                            </div>--}}
                                    {{--                                        </td>--}}
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

    <script>
        $(document).ready(function () {
            // Initialize the DataTable
            let dataTable = CreateDataTable();

            dataTable.order(['4', 'desc'], ['3', 'asc'], ['1', 'asc']).draw();
        });
    </script>
    <script>
        $(document).ready(function () {
            var select_html = $('.member_select_div select').first().prop('outerHTML');
            $(document).on('click', '.add_member', function () {
                // console.log(select_html);
                $('.member_select_div').append(select_html);

                $('.member_select_div select').select2();

            });

            $(document).on('change', '#courseYear', function () {
                let value = $(this).val();
                if (value != -1) {
                    $('#name').val($(this).find(':selected').text().trim());
                    // console.log($(this).find(':selected').text().trim())
                } else {
                    $('#name').val('');
                }
            });
        });
    </script>
    <script>

        $('#addPanelForm').validate({
            ignore: [],
            rules: {
                "courseYearId": {
                    notEqualValue: "-1",
                },
                'members[]': {
                    // notEqualValue: "-1",
                    uniqueValues: 'unique-dropdown',
                    require_from_group: [1, '.member-dropdown']
                },
                // 'guide': {
                //     notEqualValue: "-2",
                // }
            },
            messages: {

                // guide: {
                //     notEqualValue: "Please select Head Of committee",
                // },
                courseYearId: {
                    notEqualValue: "Please select Course Year",
                },
                'members[]': {
                    // notEqualValue: "Please select Member Of committee",
                    uniqueValues: "Please select unique Each Faculty Of Panel",
                    require_from_group: "Please select at least one Faculty for panel",
                }
            },
            // errorPlacement: function(error, element) {
            // // Use Toastr to show error messages
            // // toastr.error(error.text());
            // },
            // invalidHandler: function(event, validator) {
            // // Use Toastr to show a summary error message
            // toastr.error('Please fix the highlighted fields');
            // },
            submitHandler: function (form, event) {
                // form.submit();
                event.preventDefault();


                // name = $(document).find('#name').val();

                // //send ajax for similar name check
                // if (similarName) {

                // }

                var formData = $('#addPanelForm').serialize()
                $.ajax({
                    type: "post",
                    url: "{{ route('panel.add') }}",
                    data: formData,
                    // dataType: "dataType",
                    success: function (res) {
                        if (res.error) {
                            toastr.error(res.error)
                            return;
                        }
                        // console.log(res.success);
                        toastr.success(res.success)

                        $('#addPanelForm')[0].reset();
                        $('#addPanelForm').find('select').val('-1').trigger('change');
                        $('.member_select_div').html(select_html);
                        courseYearFill();

                        // get and replace table body
                        $.ajax({
                            type: "get",
                            url: "{{ route('ManagePresentationPanel') }}",
                            // data: ,
                            // dataType: "dataType",
                            success: function (r) {
                                DestroyDataTable();
                                var response = $(r);
                                var tbody = response.find('tbody').html();
                                console.log(tbody);
                                $(document).find('tbody').html(tbody);
                                CreateDataTable();
                                console.log(111111111)
                            },

                            error: function (xhr, response) {
                                if (xhr.status == 422) {
                                    var errors = xhr.responseJSON.errors;
                                    $.each(errors, function (field, messages) {
                                        $.each(messages, function (index,
                                                                   message) {
                                            toastr.error(messages)
                                        });
                                    });
                                } else if (xhr.status == 500) {
                                    // toastr.error(xhr.responseJSON.message)
                                    toastr.error('Something went wrong !')
                                }
                            }

                        })

                    },

                    error: function (xhr, response) {
                        if (xhr.status == 422) {
                            var errors = xhr.responseJSON.errors;

                            $.each(errors, function (field, messages) {
                                $.each(messages, function (index, message) {
                                    toastr.error(messages)
                                });
                            });
                        } else if (xhr.status == 500) {
                            // toastr.error(xhr.responseJSON.message)
                            toastr.error('Something went wrong !')
                        }
                    }
                });
            }
        })
    </script>
@endpush
