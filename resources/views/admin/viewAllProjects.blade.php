@extends('../template/layout')

@section('title', 'Admin Dashboard | PMS')

<!-- @section('content')
@endsection -->

@section('css')

    <style>
        .dataTable {
            width: 100% !important;
        }

        .dataTable td {
            word-wrap: break-word !important;;
            overflow-wrap: break-word !important;
        }
    </style>

@endsection
@section('body')

    <div class="row">
        <div class="col-md-6">

            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Project Assignment</h5>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('Project.add') }}" id="ProjectAllocationForm">
                            @csrf
                            <span id="error_info">

                            </span>
                            <div class="mb-3">
                                <label for="courseYear" class="form-label">Course And Year</label>
                                <select class="form-select selectSearch" id="courseYear" name="courseYearId"
                                        aria-label="Default select example">
                                    <option value="-1" selected>select Course and Acadamic Year</option>
                                    @foreach ($courseYears as $courseYear)
                                        <option value="{{ $courseYear->id }}">{{$courseYear->course->code ." " . $courseYear->course->name ."  -  " . $courseYear->year->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <label id="courseYear-error" class="error" for="courseYear"
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
                                <label class="form-label" for="c">title</label>
                                <div class="input-group input-group-merge">
                                    {{-- <span id="title2" class="input-group-text">
                                        <i class="bx bx-buildings"></i></span> --}}
                                    <input type="text" id="title" class="form-control" name="title"
                                           placeholder="Project Title " aria-label="Project Title "
                                           aria-describedby="title"/>
                                </div>
                                <label id="title-error" class="error" for="title"></label>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="definition">definition</label>
                                <textarea id="definition" name="definition" class="form-control"
                                          placeholder="Definition"></textarea>
                                <small class="font-light float-end" style="color: darkgreen">( Optional )</small>
                                <label id="definition-error" class="error" for="definition"></label><br>
                            </div>

                            <button type="submit" class="btn btn-primary">Assign Project</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header "><strong> Project Details</strong></h5>
                <div class="table-responsive p-2">
                    <table
                        class="dt-scrollableTable table-responsive datatables-ajax dtr-column  table table-hover dataTable"
                        id="dataTable">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Course Year</th>
                            <th>Group Number</th>
                            <th>Student Enrollment No</th>
                            <th>Student Name</th>
                            <th>Project Title</th>
                            <th>Project Definition</th>
                            <th>Guide Name</th>
                            {{--                            <th>Status</th>--}}
                            {{--                            <th>Actions</th>--}}
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        {{--                        @if (count($programs) != 0)--}}
                        @foreach ($studentGroups as $key => $studentGroup)
                            @if($studentGroup->student)
                                <tr>
                                    <td>
                                        <strong>{{ ++$key }}</strong>s
                                    </td>
                                    <td>{{ $studentGroup->courseYear->course->name }}
                                        - {{ $studentGroup->courseYear->year->name }}</td>
                                    <td>{{ $studentGroup->group->number }}</td>
                                    <td>{{ $studentGroup->student->enro }}</td>
                                    <td>{{ $studentGroup->student->fname .  '  ' . $studentGroup->student->lname  }}</td>
                                    @if($studentGroup->allocation)
                                        @if($studentGroup->allocation->project)
                                            <td>{{ $studentGroup->allocation->project->title }}</td>
                                            <td>{{ $studentGroup->allocation->project->definition}}</td>
                                        @else
                                            <td style="color: red">NULL</td>
                                            <td style="color: red">NULL</td>
                                        @endif
                                    @else
                                        <td style="color: red">Not Assigned</td>
                                        <td style="color: red">Not Assigned</td>
                                    @endif

                                    @if($studentGroup->allocation)
                                        <td>{{ $studentGroup->allocation->faculty->fname .  '  ' . $studentGroup->allocation->faculty->lname  }}</td>
                                    @else
                                        <td style="color: red">Not Assigned</td>
                                    @endif

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
                            @endif
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>

@endsection

@push('scripts')
    {{--    <script src="//cdn.datatables.net/rowgroup/1.1.4/js/dataTables.rowGroup.min.js"></script>--}}

    <script>

        $(document).ready(function () {
            CreateDataTableProject();
        });

    </script>
    <script>

        function Formreset() {
            $('#courseYear').val('-1');
            $('#courseYear').trigger('change');
            $('#group').val('-1');
            $('#group').trigger('change');
            $('#title').val('');
            $('#definition').val('');
            $('#project-title').text('Project Title');
        }

        $('#ProjectAllocationForm').validate({
            rules: {
                "courseYearId": {
                    notEqualValue: "-1",
                },
                "groupId": {
                    notEqualValue: "-1",
                },
                "title": {
                    required: true,
                },
                "definition": {
                    // required: true,
                },
            },
            messages: {
                courseYearId: {
                    notEqualValue: "Please select Course And Acadamic Year",
                },
                groupId: {
                    notEqualValue: "Please select Group",
                },
                title: {
                    required: "Please select Faculty",
                },
                definition: {
                    // required: "Please select Faculty",
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

                var formData = $('#ProjectAllocationForm').serialize()
                $.ajax({
                    type: "post",
                    url: "{{ route('Project.add') }}",
                    data: formData,
                    // dataType: "dataType",
                    success: function (res) {
                        if (res.success) {
                            toastr.success(res.success)
                        } else {
                            toastr.error(res.error)
                        }

                        // reset form
                        Formreset();
                        courseYearFill();

                        // get and replace table bodyy
                        $.ajax({
                            type: "get",
                            url: "{{ route('ManageProjects') }}",
                            // data: ,
                            // dataType: "dataType",
                            success: function (r) {
                                DestroyDataTable();
                                var response = $(r);
                                var tbody = response.find('tbody').html();
                                // console.log(tbody);
                                $(document).find('tbody').html(tbody)
                                CreateDataTableProject();
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
                            toastr.error('Something went wrong !')
                        }
                    }
                });
            }
        })
    </script>
    <script>
        $('#group').attr('disabled', true);
        $(document).on('change', '#courseYear', function () {
            var courseYearId = $(this).val();

            // if select a defalut option
            if (courseYearId == -1) {
                $('#group').val('-1');
                $('#group').trigger('change');
                $('#group').attr('disabled', true);
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
                        // options += '<option value="' + group.id + '">' + group.number + '</option>';
                        options += '<option value="' + group.id + '">' + group.number + '\t - \t' + group.title + '</option>';
                    });
                    $('#group').html(options);
                    $('#group').attr('disabled', false);
                }
            });
        })

        $(document).on('change', '#group', function () {
            var groupId = $(this).val();

            if (groupId == -1) {
                $('#title').val('');
                $('#definition').val('');
                return;
            }

            // get guide
            $.ajax({
                type: "get",
                url: "{{ route('getProject') }}",
                data: {
                    groupId: groupId
                },
                // dataType: "dataType",
                success: function (response) {
                    // console.log(response);

                    if (response.length == 0) {
                        toastr.info('Enter Project Info');

                        return;
                    }

                    var ProjectTitle = response.title;
                    if (ProjectTitle != null) {
                        $('#title').val(ProjectTitle);
                        $('#project-title').text(ProjectTitle);
                    } else {
                        $('#title').val('');
                        $('#project-title').text('Project Title');
                        $('#project-title').text('Project Title');
                    }

                    var ProjectDefinition = response.definition;
                    if (ProjectDefinition != null) {
                        $('#definition').val(ProjectDefinition);
                    } else {
                        $('#definition').val('');
                    }
                }
            });
        });

    </script>
@endpush
