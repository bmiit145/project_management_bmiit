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
                        <h5 class="mb-0">Student Marks</h5>
                        <!-- <small class="text-muted float-end">Merged input group</small> -->
                    </div>
                    <div class="card-body">
                        <form method="post" id="StudentMarkform">
                            @csrf
                            <span id="error_info">

                            </span>
                            <div class="mb-3">
                                <label for="courseYear" class="form-label">Course And Year</label>
                                <select class="form-select selectSearch" id="courseYear" name="courseYearId"
                                        aria-label="Default select example">
                                    <option value="-1" selected>select Course and Acadamic Year</option>
                                    @foreach ($courseYears as $courseYear)
                                        <option value="{{ $courseYear->id }}">{{$courseYear->course->code ." ". $courseYear->course->name ."  -  " . $courseYear->year->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <label id="courseYear-error" class="error" for="courseYear"
                                       style="display: none"></label>
                            </div>
                            <div class="mb-3">
                                <label for="evaluation" class="form-label">Evaluation Criteria</label>
                                <select class="form-select selectSearch" id="evaluationSelectBox" name="evaluationId"
                                        aria-label="Default select example">
                                    <option value="-1" selected>select Evaluation Criteria</option>
                                    {{--                                    @foreach ($evaluationCriteriaMarks as $evaluationCriteriaMark)--}}
                                    {{--                                        <option--}}
                                    {{--                                            value="{{ $evaluationCriteriaMark->id }}">{{ $evaluationCriteriaMark->evaluationCriteria->name}}--}}
                                    {{--                                        </option>--}}
                                    {{--                                    @endforeach--}}
                                </select>
                                <label class="outof" for="outof">OUT OF : <span id="outof"
                                                                                style="color: #2d8f16">NULL</span></label><br>
                                <label id="evaluation-error" class="error" for="evaluation"
                                       style="display: none"></label>
                            </div>
                            <div class="mb-3">
                                <label for="group" class="form-label">Group Number</label>
                                <select class="form-select selectSearch" id="group" name="groupId"
                                        aria-label="Default select example">
                                    <option value="-1" selected>select Group</option>
                                    {{--                                    @foreach ($groups as $group)--}}
                                    {{--                                        <option value="{{ $group->id }}">{{ $group->course->name }}--}}
                                    {{--                                            - {{ $group->year->name }}--}}
                                    {{--                                        </option>--}}
                                    {{--                                    @endforeach--}}
                                </select>
                                <label id="project-title" class="title" for="title"
                                       style="color: #0d6efd">Project Title</label><br>
                                <label id="group-error" class="error" for="group"
                                       style="display: none"></label>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="mark">Mark</label>
                                <div class="input-group input-group-merge">
                                    <input type="text" id="mark" class="form-control" name="marks" placeholder="90"
                                           aria-label="90" aria-describedby="90">
                                </div>
                                <label id="mark-error" class="error" for="mark" style="display: none;"></label>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <h5 class="card-header "><strong> Marks</strong></h5>
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
                    <table
                        class="dt-scrollableTable table-responsive datatables-ajax dtr-column  table table-hover dataTable "
                        id="dataTable">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Course</th>
                            <th>Year</th>
                            <th>Group Number</th>
                            <th>Project Title</th>
                            <th>Evaluation Criteria</th>
                            <th>Total Mark</th>
                            <th>Mark</th>
                            {{--                            <th>Status</th>--}}
                            {{--                            <th>Actions</th>--}}
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        {{--                        @if (count($programs) != 0)--}}
                        @foreach ($marks as $key => $mark)
                            <tr>
                                <td>
                                    <strong>{{ ++$key }}</strong>
                                </td>
                                <td>
                                    <strong>{{ $mark->evaluationMark->courseYear->course->name}}</strong>
                                </td>
                                <td>
                                    <strong>{{ $mark->evaluationMark->courseYear->year->name}}</strong>
                                </td>
                                <td>
                                    <strong>{{ $mark->group->number  }}</strong>
                                </td>
                                <td>
                                    @if($mark->group->project)
                                        <span>{{ $mark->group->project->title  }}</span>
                                    @else
                                        <span style="color: red"> No Project Assign</span>
                                    @endif
                                </td>
                                <td>
                                    <span>{{ $mark->evaluationMark->evaluationCriteria->name}}</span>
                                </td>
                                <td>
                                    <span>{{ $mark->evaluationMark->outof}}</span>
                                </td>
                                <td>
                                    <span>{{ $mark->marks}}</span>
                                </td>
                                {{--                                @if ($program->status == 1)--}}
                                {{--                                    <td id="status"><span--}}
                                {{--                                            class="badge bg-label-primary me-1">Active</span></td>--}}
                                {{--                                @else--}}
                                {{--                                    <td id="status"><span class="badge bg-label-danger me-1">InActive</span>--}}
                                {{--                                    </td>--}}
                                {{--                                @endif--}}
                                {{--                                <td>--}}
                                {{--                                    <div class="dropdown">--}}
                                {{--                                        <button type="button"--}}
                                {{--                                                class="btn p-0 dropdown-toggle hide-arrow"--}}
                                {{--                                                data-bs-toggle="dropdown">--}}
                                {{--                                            <i class="bx bx-dots-vertical-rounded"></i>--}}
                                {{--                                        </button>--}}
                                {{--                                        <div class="dropdown-menu">--}}
                                {{--                                            <a class="dropdown-item" href="javascript:void(0);"><i--}}
                                {{--                                                    class="bx bx-edit-alt me-1"></i>--}}
                                {{--                                                Edit</a>--}}
                                {{--                                            @if ($program->status == 1)--}}
                                {{--                                                <a class="dropdown-item"--}}
                                {{--                                                   href="javascript:void(0);" id="changeStatus"--}}
                                {{--                                                   data-username="{{ $program->code }}"--}}
                                {{--                                                   data-status="{{ $program->status }}"><i--}}
                                {{--                                                        class="bx bx-refresh"></i>--}}
                                {{--                                                    <span>Inactive</span></a>--}}
                                {{--                                            @else--}}
                                {{--                                                <a class="dropdown-item"--}}
                                {{--                                                   href="javascript:void(0);" id="changeStatus"--}}
                                {{--                                                   data-username="{{ $program->code }}"--}}
                                {{--                                                   data-status="{{ $program->status }}"><i--}}
                                {{--                                                        class="bx bx-refresh"></i>--}}
                                {{--                                                    <span>Active</span></a>--}}
                                {{--                                            @endif--}}

                                {{--                                        </div>--}}
                                {{--                                    </div>--}}
                                {{--                                </td>--}}
                            </tr>
                        @endforeach
                        {{--                        @else--}}
                        {{--                            <tr>--}}
                        {{--                                <td colspan="3" style="text-align: center">No record Found !</td>--}}
                        {{--                            </tr>--}}
                        {{--                        @endif--}}
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
        $('#StudentMarkform').validate({
            v: [],
            rules: {
                "courseYearId": {
                    notEqualValue: "-1",
                },
                "groupId": {
                    notEqualValue: "-1",
                },
                "evaluationId": {
                    notEqualValue: "-1",
                },
                "marks": {
                    required: true,
                    number: true,
                    min: 0,
                    // max: function () {
                    //     return $('#outof').text();
                    // }
                },

            },
            messages: {
                "courseYearId": {
                    notEqualValue: "Please select Course And Acadamic Year",
                },
                "groupId": {
                    notEqualValue: "Please select Group",
                },
                "evaluationId": {
                    notEqualValue: "Please select Evaluation Criteria",
                },
                "marks": {
                    required: "Please enter Marks",
                    number: "Please enter a valid Marks",
                    min: "Please enter a Mark greater than or equal to 0",
                    max: "Please enter a number less than or equal to Max Marks"
                },
            },
            // errorPl  acement: function(error, element) {
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

                var formData = $('#StudentMarkform').serialize()
                $.ajax({
                    type: "post",
                    url: "{{ route('evaluaionGroupMark.add') }}",
                    data: formData,
                    // dataType: "dataType",
                    success: function (res) {
                        if (res.success) {
                            toastr.success(res.success)


                        } else {
                            toastr.error(res.error)
                        }

                        // reset form
                        $('#StudentMarkform')[0].reset();
                        $('#StudentMarkform').find('select').trigger('change');

                        courseYearFill();
                        $('#group').attr('disabled', true);
                        // courseYearFill();

                        // get and replace table bodyy
                        $.ajax({
                            type: "get",
                            url: "{{ route('ManageEvaluationStudentMarks') }}",
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
    <script>

        function getUpdatedMark() {
            var groupId = $(document).find("#group").val();
            var evaluationMarkId = $(document).find('#evaluationSelectBox').val();

            // if select a defalut option
            if (groupId == -1) {
                $('#mark').val('');
                return;
            }

            if (evaluationMarkId == -1) {
                $('#mark').val('');
                return;
            }

            // get Group MArk if already exists
            $.ajax({
                type: "get",
                url: "{{ route('getGroupMark') }}",
                data: {
                    groupId: groupId,
                    evaluationMarkId: evaluationMarkId,
                },
                // dataType: "dataType",
                success: function (response) {
                    // console.log(response);
                    if (response) {
                        $('#mark').val(response.marks);

                        if (response.project_title == null) {
                            $('#project-title').text('Project Title');
                        } else {
                            $('#project-title').text(response.project_title);
                        }
                    } else {
                        $('#mark').val('');
                    }
                }
            });

        }

        $('#group').attr('disabled', true);
        $(document).find('#evaluationSelectBox').attr('disabled', true);

        $(document).on('change', '#courseYear', function () {
            var courseYearId = $(this).val();
            // if select a defalut option
            if (courseYearId == -1) {
                $('#group').val('-1');
                $('#evaluationSelectBox').val('-1');
                $('#group').trigger('change');
                $('#evaluationSelectBox').trigger('change');
                $('#group').attr('disabled', true);
                $('#evaluationSelectBox').attr('disabled', true);
                return;
            }

            // get groups
            $.ajax({
                type: "get",
                url: "{{ route('getGroups') }}",
                data: {
                    courseYearId: courseYearId
                },
                // dataType: "dataType",
                success: function (response) {
                    // console.log(response);
                    $('#group').attr('disabled', true);

                    if (response.length == 0) {
                        toastr.error('No Groups Found');
                        $('#group').val('-1');
                        $('#group').trigger('change');
                        return;
                    }

                    var groups = response;
                    var options = '<option value="-1" selected>select Group</option>';
                    $.each(groups, function (index, group) {
                        options += '<option value="' + group.id + '">' + group.number + '\t - \t' + group.title + '</option>';
                    });
                    $('#group').html(options);
                    $('#group').attr('disabled', false);
                }
            });

            //get evaluation criteria
            $.ajax({
                type: "get",
                url: "{{ route('getEvaluationCriteria') }}",
                data: {
                    courseYearId: courseYearId
                },
                // dataType: "dataType",
                success: function (response) {
                    // console.log(response);
                    $('#evaluationSelectBox').attr('disabled', true);

                    if (response.length == 0) {
                        toastr.error('No Evaluation Criteria Found');
                        $('#evaluationSelectBox').val('-1');
                        $('#evaluationSelectBox').trigger('change');
                        return;
                    }

                    var evaluationCriteria = response;
                    var options = '<option value="-1" selected>select Evaluation Criteria</option>';
                    $.each(evaluationCriteria, function (index, evaluationCriteria) {
                        options += '<option value="' + evaluationCriteria.id + '">' + evaluationCriteria.name + '</option>';
                    });
                    $('#evaluationSelectBox').html(options);
                    $('#evaluationSelectBox').attr('disabled', false);
                }
            });
        })

        $(document).on('change', '#evaluationSelectBox', function () {
            getUpdatedMark();

            var evaluationMarkId = $(this).val();
            if (evaluationMarkId == -1) {
                $('#outof').text('NULL');
                // $('#group').val('-1');
                // $('#group').trigger('change');
                return;
            }

            // get out of
            $.ajax({
                type: "get",
                url: "{{ route('getOutOf') }}",
                data: {
                    evaluationMarkId: evaluationMarkId
                },
                // dataType: "dataType",
                success: function (response) {
                    // console.log(response);
                    // $('#outof').text('OUT OF : ' + response);
                    if (response == null) {
                        $('#outof').text('NULL');
                    } else {
                        $('#outof').text(response);
                    }
                }
            });
        });

        $(document).on('change', '#group', function () {
            getUpdatedMark();
        });
    </script>
@endpush
