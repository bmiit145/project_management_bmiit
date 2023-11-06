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
                        <h5 class="mb-0">Add new Course Year</h5>
                        <!-- <small class="text-muted float-end">Merged input group</small> -->
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('courseYear.add') }}" id="addCourseYarForm">
                            @csrf
                            <span id="error_info">

                            </span>
                            <div class="mb-3">
                                <label for="course" class="form-label">Course</label>
                                <select class="form-select selectSearch" id="course" name="courseid"
                                        aria-label="Default select example">
                                    <option value="-1" selected>select Course</option>
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->code }} - {{ $course->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <label id="course-error" class="error" for="course"
                                       style="display: none"></label>
                            </div>
                            <div class="mb-3">
                                <label for="academicyear" class="form-label">Academic year</label>
                                <select class="form-select selectSearch" id="academicyear" name="academicyearid"
                                        aria-label="Default select example">
                                    <option value="-1" selected>select Acadamic Year </option>
                                    @foreach ($academicyears as $academicyear)
                                        <option value="{{ $academicyear->id }}">{{ $academicyear->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <label id="academicyear-error" class="error" for="academicyear"
                                       style="display: none"></label>
                            </div>

                            <button type="submit" class="btn btn-primary">Add Course</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- </div>  -->
        </div>
        <div class="col-md-6">
            <div class="card">
                <h5 class="card-header "><strong> Course Year List</strong></h5>
                <div class="table-responsive text-nowrap p-2">

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
                    <table class="datatables-ajax table table-hover dataTable no-footer  " id="dataTable">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Course Code</th>
                            <th>Course Name</th>
                            <th>Acadamic Year</th>
                            {{-- <th>Status</th>
                            <th>Actions</th> --}}
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        {{-- @if (count($programs) != 0) --}}
                        @foreach ($courseYears as $key => $courseYear)
                            <tr>
                                <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                    <strong>{{ ++$key }}</strong>
                                </td>
                                <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                    <strong>{{ $courseYear->course->code }}</strong>
                                </td><td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                    <strong>{{ $courseYear->course->name }}</strong>
                                </td>
                                <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                    <span>{{ $courseYear->year->name }}</span>
                                </td>
                                {{-- <td>
                            @if ($program->status == 1)
                                <td id="status"><span class="badge bg-label-primary me-1">Active</span></td>
                            @else
                                <td id="status"><span class="badge bg-label-danger me-1">InActive</span></td>
                            @endif
                            </td> --}}
                                {{-- <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="bx bx-edit-alt me-1"></i>
                                            Edit</a>
                                        @if ($program->status == 1)
                                            <a class="dropdown-item" href="javascript:void(0);" id="changeStatus"
                                                data-username="{{ $program->code }}"
                                                data-status="{{ $program->status }}"><i class="bx bx-refresh"></i>
                                                <span>Inactive</span></a>
                                        @else
                                            <a class="dropdown-item" href="javascript:void(0);" id="changeStatus"
                                                data-username="{{ $program->code }}"
                                                data-status="{{ $program->status }}"><i
                                                    class="bx bx-refresh"></i>
                                                <span>Active</span></a>
                                        @endif

                                    </div>
                                </div>
                            </td> --}}
                            </tr>
                        @endforeach
                        {{-- @else
                            <tr>
                                <td colspan="3" style="text-align: center">No record Found !</td>
                            </tr>
                        @endif --}}
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
            CreateDataTable();
        });
    </script>
    <script>
        $('#addCourseYarForm').validate({
            rules: {
                "courseid": {
                    notEqualValue: "-1",
                },
                "academicyearid": {
                    notEqualValue: "-1",
                },
            },
            messages: {
                courseid: {
                    required: "Please select Course",
                },
                academicyearid: {
                    required: "Please select Acadamic Year",
                },
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

                var formData = $('#addCourseYarForm').serialize()
                $.ajax({
                    type: "post",
                    url: "{{ route('courseYear.add') }}",
                    data: formData,
                    // dataType: "dataType",
                    success: function (res) {
                        if (res.success) {
                            toastr.success(res.success)
                        } else {
                            toastr.error(res.error)
                        }

                        $('#addCourseYarForm')[0].reset();
                        $(document).find('#addCourseYarForm').find('select').val('-1').trigger('change');

                        // get and replace table bodyy
                        $.ajax({
                            type: "get",
                            url: "{{ route('ManageCourseYears') }}",
                            // data: ,
                            // dataType: "dataType",
                            success: function (r) {
                                DestroyDataTable();
                                var response = $(r);
                                var tbody = response.find('tbody').html();
                                // console.log(tbody);
                                $(document).find('tbody').html(tbody)
                                CreateDataTable();
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
                        }
                    }

                });
            }
        })
    </script>
@endpush
