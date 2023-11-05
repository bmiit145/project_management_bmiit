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
                        <h5 class="mb-0">Evaluation Sheet</h5>
                        <!-- <small class="text-muted float-end">Merged input group</small> -->
                    </div>
                    <div class="card-body">
                        <form method="post" id="evaluationSheetForm">
                            @csrf
                            <span id="error_info">

                            </span>
                            <div class="mb-3">
                                <label for="courseYear" class="form-label">Course And Year</label>
                                <select class="form-select selectSearch" id="courseYear" name="courseYearId"
                                        aria-label="Default select example">
                                    <option value="-1" selected>select Course and Acadamic Year</option>
                                    @foreach ($courseYears as $courseYear)
                                        <option value="{{ $courseYear->id }}">{{ $courseYear->course->name }}
                                            - {{ $courseYear->year->name }}
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

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
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
        $('#evaluationSheetForm').validate({
            v: [],
            rules: {
                "courseYearId": {
                    notEqualValue: "-1",
                },
                "evaluationId": {
                    // notEqualValue: "-1",
                },
            },
            messages: {
                "courseYearId": {
                    notEqualValue: "Please select Course And Acadamic Year",
                },
                "evaluationId": {
                    notEqualValue: "Please select Evaluation Criteria",
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

                var formData = $('#evaluationSheetForm').serialize()
                $.ajax({
                    type: "post",
                    url: "{{ route('DownloadEvaluationSheetPdf') }}",
                    data: formData,
                    xhrFields: {
                        responseType: 'blob'
                    },
                    // dataType: "dataType",
                    success: function (data) {

                        var a = document.createElement('a');
                        var url = window.URL.createObjectURL(data);
                        a.href = url;
                        a.download = 'evaluation_sheet.pdf';
                        document.body.append(a);
                        a.click();
                        a.remove();
                        window.URL.revokeObjectURL(url);
                        //
                        // if (res.success) {
                        //     toastr.success(res.success)
                        //
                        //
                        // } else {
                        //     toastr.error(res.error)
                        // }
                        //
                        // // reset form
                        // $('#evaluationSheetForm')[0].reset();
                        // $('#evaluationSheetForm').find('select').trigger('change');
                        //
                        // courseYearFill();
                        // $('#group').attr('disabled', true);
                        // // courseYearFill();

                        // get and replace table body

                        {{--$.ajax({--}}
                        {{--    type: "get",--}}
                        {{--    url: "{{ route('DownloadEvaluationSheet') }}",--}}
                        {{--    // data: ,--}}
                        {{--    // dataType: "dataType",--}}
                        {{--    success: function (r) {--}}
                        {{--        DestroyDataTable();--}}
                        {{--        var response = $(r);--}}
                        {{--        var tbody = response.find('tbody').html();--}}
                        {{--        // console.log(tbody);--}}
                        {{--        $(document).find('tbody').html(tbody)--}}
                        {{--        CreateDataTable();--}}
                        {{--    },--}}

                        {{--    error: function (xhr, response) {--}}
                        {{--        if (xhr.status == 422) {--}}
                        {{--            var errors = xhr.responseJSON.errors;--}}

                        {{--            $.each(errors, function (field, messages) {--}}
                        {{--                $.each(messages, function (index,--}}
                        {{--                                           message) {--}}
                        {{--                    toastr.error(messages)--}}
                        {{--                });--}}
                        {{--            });--}}
                        {{--        }--}}
                        {{--    }--}}

                        {{--})--}}

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

    </script>
@endpush
