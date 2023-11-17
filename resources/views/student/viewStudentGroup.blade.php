@extends('../template/layout')

@section('title', 'Student Dashboard | PMS')

<!-- @section('content')
@endsection -->

@section('body')

    <div class="row">
        @if($courseYears && $courseYears->count() != 0)
            <div class="col-md-6">

                <div class="col-xl">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"> Make New Group </h5>
                            <!-- <small class="text-muted float-end">Merged input group</small> -->
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('studentGroup.add') }}" id="addGroupForm">
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
                    <h4 class="alert-heading">No Course Year Found</h4>
                    <p>There is no Course Year Found for upcoming project or course</p>
                    <hr>
                    <p class="mb-0">contact committee for further details</p>
                    <a href="{{ route('show.student.dashboard') }}" class="btn btn-primary mt-3">Go to dashboard</a>
                </div>
            </div>
        @endif
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
                            options += '<option value="' + student.enro + '">' + student.fname + ' ' + student.lname + '</option>';
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
        $('#addGroupForm').validate({
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
                    uniqueValues: "Please select unique Each Student Of Group",
                    require_from_group: "Please select at least one Student Of Group",
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

                var formData = $('#addGroupForm').serialize()
                $.ajax({
                    type: "post",
                    url: "{{ route('studentGroup.add') }}",
                    data: formData,
                    // dataType: "dataType",
                    success: function (res) {
                        if (res.error) {
                            toastr.error(res.error)
                            return;
                        }
                        // console.log(res.success);
                        toastr.success(res.success)

                        $('#addGroupForm')[0].reset();
                        $('#addGroupForm').find('select').val('-1').trigger('change');
                        $('.member_select_div').html(select_html);
                        courseYearFill();


                        // get and replace table body
                        $.ajax({
                            type: "get",
                            url: "{{ route('ManageGroups') }}",
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
