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
                                        <option value="{{ $courseYear->id }}">{{ $courseYear->course->code ."   " . $courseYear->course->name . "  -  " . $courseYear->year->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <label id="courseYear-error" class="error" for="courseYear"
                                       style="display: none"></label>
                            </div>
                            <div class="mb-3">
                                <label for="courseYear" class="form-label">SHEET TYPE</label>
                                <div class="col mt-2">
                                    <div class="form-check form-check-inline">
                                        <input name="withStudent" class="form-check-input" type="radio"
                                               value="TRUE" id="student_wise" checked>
                                        <label class="form-check-label" for="student_wise">Student Wise </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input name="withStudent" class="form-check-input" type="radio"
                                               value="FALSE" id="group_wise">
                                        <label class="form-check-label" for="group_wise">Group Wise</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="evaluation" class="form-label">Evaluation Criteria</label>
                                <div class="evaluation_checkbox row">
                                    <div class="form-check">
                                        <input class="form-check-input" name="evaluation[]" type="checkbox"
                                               value="-1"
                                               id="evaluationId"
                                               checked="">
                                        <label class="form-check-label" for="evaluationId">
                                            All Evaluation Criteria
                                        </label>
                                    </div>
                                </div>
                                <label id="evaluation[]-error" class="error" for="evaluation[]"
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

        // rules for minimum 1 checkbox checked
        $.validator.addMethod('minCheckbox', function (value, el, param) {
            return $('input[name="' + param + '"]:checked').length > 0;
        }, 'Please check at least one Check box.');

        $('#evaluationSheetForm').validate({
            ignore: [],
            rules: {
                "courseYearId": {
                    notEqualValue: "-1",
                },
                "evaluation[]": {
                    minCheckbox: 'evaluation[]',
                },
            },
            messages: {
                "courseYearId": {
                    notEqualValue: "Please select Course And Acadamic Year",
                },
                "evaluation[]": {
                    minCheckbox: "Please select Evaluation Criteria",
                },
            },
            // error: function(error, element) {
            // // // Use Toastr to show error messages
            // toastr.error(error.text());
            // },
            // invalidHandler: function(event, validator) {
            // // Use Toastr to show a summary error message
            // toastr.error('Please fix the highlighted fields');
            // },
            submitHandler: function (form, event) {
                // form.submit();
                event.preventDefault();

                var formData = $('#evaluationSheetForm').serialize()
                $.ajax({
                    type: "post",
                    url: "{{ route('DownloadEvaluationSheetPdf') }}",
                    data: formData,
                    xhrFields: {
                        responseType: 'blob'
                    },
                    // dataType: "dataType",
                    success: function (data, status, xhr) {
                        // get filename which sends from backend in 'content-disposition' header
                        // var disposition = xhr.getResponseHeader('Content-Disposition');
                        // if (disposition && disposition.indexOf('attachment') !== -1) {
                        //     var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                        //     var matches = filenameRegex.exec(disposition);
                        //     if (matches != null && matches[1]) filename = matches[1].replace(/['"]/g, '');
                        // }
                        try {
                            var filename = xhr.getResponseHeader('filename');
                            if (filename == null || filename == "" || filename == undefined) {
                                filename = "evaluation_sheet.pdf";
                            }
                        } catch (e) {
                            filename = "evaluation_sheet.pdf";
                        }

                        // The actual download
                        var a = document.createElement('a');
                        var url = window.URL.createObjectURL(data);
                        a.href = url;
                        a.download = filename;
                        document.body.append(a);
                        a.click();
                        a.remove();
                        window.URL.revokeObjectURL(url);
                        //
                        if (status == 'success') {
                            toastr.success("Evaluation Sheet Downloaded")
                        } else {
                            toastr.error("Sheet Not Downloaded")
                        }


                        // // reset form
                        $('#evaluationSheetForm')[0].reset();
                        $('#evaluationSheetForm').find('select').trigger('change');
                        courseYearFill();

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
                            toastr.error('Something went wrong')
                        } else if (xhr.status == 404) {
                            toastr.error('Evaluation Sheet Not Found')
                        }
                    }

                });
            }
        })
    </script>
    <script>
        var evaluation_checkbox_html = $('.evaluation_checkbox').eq(0).html();
        // console.log(evaluation_checkbox_html);

        $(document).on('change', '#courseYear', function () {
            var courseYearId = $(this).val();

            if (courseYearId == -1) {
                $(document).find(".evaluation_checkbox").html(evaluation_checkbox_html);
                return;
            }

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
                    if (response.length > 0) {
                        var html = evaluation_checkbox_html;
                        $.each(response, function (index, value) {
                            html += '<div class="form-check col-md-6">';
                            html += '<input class="form-check-input" name="evaluation[]" type="checkbox" value="' + value.id + '" id="evaluationId">';
                            html += '<label class="form-check-label" for="evaluationId">';
                            html += value.name;
                            html += '</label>';
                            html += '</div>';
                        });
                        $(document).find(".evaluation_checkbox").html(html);
                    } else {
                        $(document).find(".evaluation_checkbox").html(evaluation_checkbox_html);
                    }


                    if (response.length == 0) {
                        toastr.error('No Evaluation Criteria Found');
                        $(document).find(".evaluation_checkbox").html(evaluation_checkbox_html);
                        return;
                    }
                }
            })
        });

        $(document).on('change', '#evaluationId', function () {
            var evaluationMarkId = $(this).val();
            if (evaluationMarkId == -1) {
                $(document).find(".evaluation_checkbox").find('input[type="checkbox"]').prop('checked', false);
                $(document).find(".evaluation_checkbox").find('input[type="checkbox"]').eq(0).prop('checked', true);
                return;
            } else {
                $(document).find(".evaluation_checkbox").find('input[type="checkbox"]').eq(0).prop('checked', false);
            }
        });

    </script>
@endpush
