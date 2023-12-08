@extends('../template/layout')

@section('title', 'Student Dashboard | PMS')

<!-- @section('content')
@endsection -->

@section('body')

    <div class="row">
        @if(($courseYears && $courseYears->count() != 0))
            <div class="col-md-6">
                <div class="col-xl">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"> Make New Group </h5>
                            <!-- <small class="text-muted float-end">Merged input group</small> -->
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('PanddingGroup.add') }}" id="addPanddingGroupForm">
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
                                                value="{{ $courseYear->id }}">{{$courseYear->course->code . "   " . $courseYear->course->name ." - " . $courseYear->year->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label id="courseYear-error" class="error" for="courseYear"
                                           style="display: none"></label>
                                </div>
                                <div class="mb-3">
                                    <label for="student" class="form-label">Students</label>
                                    <div class="member_select_div">
                                        <select class="form-select selectSearch unique-dropdown member-dropdown my-4"
                                                id="member"
                                                name="members[]">
                                            <option value="-1" selected>select Student</option>
                                            @foreach ($students as $student)
                                                <option value="{{ $student->enro }}">
                                                    {{ $student->enro ." ". $student->fname . " ". $student->lname }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <label id="member-error" class="error" for="member"
                                           style="display: none"></label><br>
                                    <button type="button" class="btn btn-dark mt-2 add_member">Add Student</button>
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
{{--                                    <small class="font-light float-end" style="color: darkgreen">( Optional )</small>--}}
                                    <label id="definition-error" class="error" for="definition"></label><br>
                                </div>
                                <button type="submit" class="btn btn-primary">Make Group</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- </div>  -->
            </div>
        @else
            <div class="col-md-6">
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">No Upcoming Project Found</h4>
                    <p>There is no project Found for upcoming Course Year or course</p>
                    {{--                    <hr>--}}
                    <p class="mb-0">contact committee for further details</p>
                    <a href="{{ route('show.student.dashboard') }}" class="btn btn-primary mt-3">Go to dashboard</a>
                </div>
            </div>
        @endif
    </div>

    {{--   All Panding Groups for approval --}}
    @if($panddingGroups && $panddingGroups->count() != 0)
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"> Pending Groups </h5>
                        <!-- <small class="text-muted float-end">Merged input group</small> -->
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Project Title</th>
                                <th>Project Definition</th>
                                <th>Students</th>
                                <th>Course Year</th>
                                <th>Created By</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach( $panddingGroups as $group)
                                <tr>
                                    <td>{{ $group->title ? $group->title:"No any Project Title Given" }}</td>
                                    <td>{{ $group->definition?$group->definition == null ?"No any Project Definition Given": $group->definition : "No any Project Title Given" }}</td>
                                    <td>
                                        <ul>
                                            @foreach( $group->panddingGroups as $member)
                                                <li>
                                                    <small>{{$member->studentenro . "\t" . $member->student->fname . "\t" . $member->student->lname }}</small>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>{{ $group->courseYear->course->code . " - " . $group->courseYear->course->name . " - " . $group->courseYear->year->name }}</td>
                                    <td>{{ $group->created_by  }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{--    view all students group where login student have--}}
    <div class="row">
        @foreach($groups as $group)
            <div class="col-md-12 col-lg-6 mb-4">
                <div class="card">
                    <div class="col-12">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="w-100 d-flex justify-content-between align-items-center">
                                    <div class="ms-2 me-2 w-100 d-flex flex-column justify-content-between"
                                         style="text-align: center ;">
                                        <div class="font-weight-bold">
                                            <a href="">
                                                {{"Group No .\t" . $group->group->number }}
                                            </a>
                                        </div>
                                        <div class="text-gray-600">
                                            {{ $group->courseYear->course->code . " - " . $group->courseYear->course->name . " - " . $group->courseYear->year->name }}
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <span class="badge badge-primary text-dark">{{ $group->group->studentGroups->count() }} Members</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @if($group->group->project)
                                <h4 class="card-title mb-1 text-nowrap">{{ $group->group->project->title }}</h4>
                                @if($group->group->project->definition != null)
                                    <p class="d-block mb-3 text-wrap"
                                       style="font-size: small">{{ $group->group->project->definition}}</p>
                                @else
                                    <div class="alert alert-danger" role="alert">
                                        <strong>Project Definition Not Given</strong>
                                    </div>
                                @endif
                            @else
                                <div class="alert alert-danger" role="alert">
                                    <strong>Project Not Assigned</strong>
                                </div>
                            @endif

                            {{--                            <h5 class="card-title  mb-2">Guide : <span--}}
                            {{--                                    class="text-primary">{{ $group->group->allocation ? $group->group->allocation->faculty->fname . " " . $group->group->allocation->faculty->lname :"No any Guide Assigned" }}</span>--}}
                            {{--                            </h5>--}}

                            @foreach( $group->group->studentGroups as $student)
                                <small class="d-block pb-1"
                                       style="font-size: math">{{$student->studentenro . "\t" . $student->student->fname . "\t" . $student->student->lname }}</small>
                            @endforeach

                            {{--                            <a href="javascript:;" class="btn btn-sm mt-3 btn-primary">View sales</a>--}}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@push('scripts')

    <script>
        $(document).ready(function () {
            // Initialize the DataTable
            let dataTable = CreateDataTable();

            dataTable.order(['7', 'desc'], ['6', 'asc'], ['1', 'asc'], ['2', 'asc']).draw();
            dataTable.rowGroup({
                dataSrc: '[7 , 6 , 1 , 2]'
            })
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
                // get Students of selected course year
                var courseYearId = $(this).val();

                if (courseYearId == -1) {
                    $('.member_select_div select').html('<option value="-1" selected>select Student</option>');
                    $('.member_select_div select').select2();
                    $('.member_select_div select').val('-1').trigger('change');
                    return;
                }

                $.ajax({
                    type: "get",
                    url: "{{ route('getStudents') }}",
                    data: {courseYearId: courseYearId},
                    // dataType: "dataType",
                    success: function (res) {
                        if (res.error) {
                            toastr.error(res.error)
                        }
                        // console.log(res.success);
                        // toastr.success(res.success)
                        var students = res.students;
                        var options = '<option value="-1" selected>select Student</option>';
                        $.each(students, function (index, student) {
                            options += '<option value="' + student.enro + '">'+ student.enro + '  ' + student.fname + ' ' + student.lname + '</option>';
                        });


                        $('.member_select_div select').html(options);
                        select_html = $('.member_select_div select').first().prop('outerHTML');
                        $('.member_select_div select').select2();
                        $('.member_select_div select').val('-1').trigger('change');

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
                });
            });
        });
    </script>
    <script>
        let select_html = $('.member_select_div select').first().prop('outerHTML');
        $('#addPanddingGroupForm').validate({
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
                title: {
                    required: true,
                    minlength: 3,
                    maxlength: 255,
                },
                definition: {
                    required:true,
                },
            },
            messages: {
                courseYearId: {
                    notEqualValue: "Please select Course Year",
                },
                'members[]': {
                    // notEqualValue: "Please select Member Of committee",
                    uniqueValues: "Please select unique Each Student Of Group",
                    require_from_group: "Please select at least one Student Of Group",
                },
                title: {
                    required: "Please enter Project Title",
                    minlength: "Project Title must be at least 3 characters long",
                    maxlength: "Project Title must be at least 255 characters long",
                },
                definition: {
                    required: "Please enter Project Definition",
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

                var formData = $('#addPanddingGroupForm').serialize()
                $.ajax({
                    type: "post",
                    url: "{{ route('PanddingGroup.add') }}",
                    data: formData,
                    // dataType: "dataType",
                    success: function (res) {
                        if (res.error) {
                            toastr.error(res.error)
                            return;
                        }
                        // console.log(res.success);
                        toastr.success(res.success)

                        $('#addPanddingGroupForm')[0].reset();
                        $('#addPanddingGroupForm').find('select').val('-1').trigger('change');
                        $('.member_select_div').html(select_html);
                        courseYearFill();


                        // get and replace table body
                        $.ajax({
                            type: "get",
                            url: "{{ route('ManageStudentGroup') }}",
                            dataType: "html",
                            success: function (r) {
                                // DestroyDataTable();
                                document.open();
                                document.write(r);
                                document.close();
                                // CreateDataTable();
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
