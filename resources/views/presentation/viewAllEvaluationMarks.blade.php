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
                        <h5 class="mb-0">Evaluation Criteria For Course Year</h5>
                        <!-- <small class="text-muted float-end">Merged input group</small> -->
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('evaluationCriteriaMark.add') }}"
                              id="addEvaluationCriteriaMarkForm">
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
                                            value="{{ $courseYear->id }}">{{ $courseYear->course->code ."  " .$courseYear->course->name ." - " . $courseYear->year->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <label id="courseYear-error" class="error" for="courseYear"
                                       style="display: none"></label>
                            </div>
                            <div class="mb-3">
                                <label for="evaluationCriteria" class="form-label">Evaluation Criteria</label>
                                <select class="form-select selectSearch evaluationCriteriaSearch"
                                        id="evaluationCriteria" name="evaluationCriteria"
                                        aria-label="Default select example">
                                    <option value="-1" selected>select Evaluation Criteria</option>
                                    @foreach ($evaluationCriterias as $evaluationCriteria)
                                        <option
                                            value="{{ $evaluationCriteria->id }}">{{ $evaluationCriteria->name}}
                                        </option>
                                    @endforeach
                                </select>

                                <div class="evaluationCriteriaTextDiv">
                                    <input type="text" id="evaluationCriteria"
                                           class="form-control evaluationCriteriaText"
                                           name="evaluationCriteria"
                                           placeholder="CIE" aria-label="CIE"
                                           aria-describedby="evaluationCriteria" style="display: none" disabled/>
                                    <input type="text" name="etext" id="criteriaText" hidden disabled>
                                </div>
                                <button type="button" class="btn btn-dark mt-2" id="toggleCriteria">Add New Criteria
                                </button>
                                <label id="evaluationCriteria-error" class="error" for="evaluationCriteria"
                                       style="display: none"></label>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="outof">OUT Of</label>
                                <div class="input-group input-group-merge">
                                    {{-- <span id="name2" class="input-group-text">
                                        <i class="bx bx-buildings"></i></span> --}}
                                    <input type="text" id="outof" class="form-control" name="outof"
                                           placeholder="100" aria-label="100"
                                           aria-describedby="outof"/>
                                </div>
                                <label id="outof-error" class="error" for="outof" style="display: none"></label>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Evaluation Mark</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- </div>  -->
        </div>
        <div class="col-md-6">
            <div class="card">
                <h5 class="card-header "><strong>Evaluation Criteria List</strong></h5>
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
                    <table class="dt-advanced-search table table-hover table-responsive dataTable text-nowrap"
                           id="dataTable">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Evaluation Criteria</th>
                            <th>Out Of</th>
                            <th>Course</th>
                            <th>Year</th>
                            {{--                            <th>Status</th>--}}
                            {{--                            <th>Actions</th>--}}
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        @if (count($evaluationCriteriaMarks) != 0)
                            @foreach ( $evaluationCriteriaMarks as $key => $evaluationCriteriaMark)
                                <tr>
                                    <td>
                                        <strong>{{ ++$key }}</strong>
                                    </td>
                                    <td>
                                        <strong>{{ $evaluationCriteriaMark->evaluationCriteria->name}}</strong>
                                    </td>
                                    <td>
                                        <strong>{{ $evaluationCriteriaMark->outof }}</strong>
                                    </td>
                                    <td>
                                        <strong>{{ $evaluationCriteriaMark->courseYear->course->name }}</strong>
                                    </td>
                                    <td>
                                        <strong>{{ $evaluationCriteriaMark->courseYear->year->name }}</strong>
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
            CreateDataTable();

            // $(".evaluationCriteriaText").show();
            // $(".evaluationCriteriaText").eq(0).prop('disabled' , true);
        });
    </script>
    {{--    toggle criteria--}}
    <script>
        $(document).ready(function () {
            $(".evaluationCriteriaText").hide();
            $(".evaluationCriteriaText").eq(0).prop('disabled', true);
            $("#criteriaText").prop('disabled', true);

            $("#toggleCriteria").click(function () {
                if ($(".evaluationCriteriaText").is(":visible")) {
                    $(".evaluationCriteriaText").hide();
                    $(".evaluationCriteriaText").eq(0).prop('disabled', true);
                    $(".evaluationCriteriaSearch").show();
                    $(".evaluationCriteriaSearch").eq(0).prop('disabled', false).next('.select2-container').show();
                    $("#criteriaText").prop('disabled', true);

                    $("#toggleCriteria").text("Add New Criteria");
                } else {
                    $(".evaluationCriteriaText").show();
                    $(".evaluationCriteriaText").eq(0).prop('disabled', false);
                    $(".evaluationCriteriaSearch").select2('close').next('.select2-container').hide();
                    $(".evaluationCriteriaSearch").eq(0).prop('disabled', true);
                    $("#criteriaText").prop('disabled', false);

                    $("#toggleCriteria").text("Select Criteria");

                }
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $(document).on('change', '#courseYear', function () {
                let value = $(this).val();
                if (value != -1) {
                    $('#name').val($(this).find(':selected').text().trim());
                    // console.log($(this).find(':selected').text().trim())
                } else {
                    $('#name').val('');
                }
            });

            $(document).on('change', '#evaluationCriteria', function () {
                let criteriaId = $(this).val();
                if (criteriaId != -1) {
                    // get out of
                    $.ajax({
                        type: "get",
                        url: "{{ route('getOutOfByCriteriaId') }}",
                        data: {
                            criteriaId: criteriaId
                        },
                        // dataType: "dataType",
                        success: function (response) {
                            // console.log(response);
                            // $('#outof').text('OUT OF : ' + response);
                            if (response == null || response == '' || response == undefined) {
                                $('#outof').val('');
                                return;
                            }
                            $('#outof').val(response);
                        }
                    });
                } else {
                    $('#outof').val('');
                }
            });
        });
    </script>
    <script>
        $('#addEvaluationCriteriaMarkForm').validate({
            rules: {
                "courseYearId": {
                    notEqualValue: "-1",
                },
                "evaluationCriteria": {
                    required: true,
                    notEqualValue: "-1",
                    // required: true,
                },
                'outof': {
                    required: true,
                    number: true,
                }
            },
            messages: {
                courseYearId: {
                    notEqualValue: "Please select Course Year",
                },
                evaluationCriteria: {
                    required: "Please Enter Evaluation Criteria",
                    notEqualValue: "Please select Evaluation Criteria",
                },
                outof: {
                    required: "Please Enter Total Marks"
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

                var formData = $('#addEvaluationCriteriaMarkForm').serialize()
                $.ajax({
                    type: "post",
                    url: "{{ route('evaluationCriteriaMark.add') }}",
                    data: formData,
                    // dataType: "dataType",
                    success: function (res) {
                        if (res.error) {
                            toastr.error(res.error)
                            return;
                        }
                        // console.log(res.success);
                        toastr.success(res.success)

                        $('#addEvaluationCriteriaMarkForm')[0].reset();
                        $(document).find('#addEvaluationCriteriaMarkForm select').trigger('change');
                        courseYearFill();

                        // get and replace table body
                        $.ajax({
                            type: "get",
                            url: "{{ route('ManageAllEvaluations') }}",
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
