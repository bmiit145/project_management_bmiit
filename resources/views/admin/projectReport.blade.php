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
                        <form method="post" id="projectSheetForm">
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


        $('#projectSheetForm').validate({
            ignore: [],
            rules: {
                "courseYearId": {
                    notEqualValue: "-1",
                },
            },
            messages: {
                "courseYearId": {
                    notEqualValue: "Please select Course And Acadamic Year",
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

                var formData = $('#projectSheetForm').serialize()
                $.ajax({
                    type: "post",
                    url: "{{ route('DownloadProjectSheetPdf') }}",
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
                                filename = "project_sheet.pdf";
                            }
                        } catch (e) {
                            filename = "project_sheet.pdf";
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
                            toastr.success("Project ReportSheet Downloaded")
                        } else {
                            toastr.error("Sheet Not Downloaded")
                        }


                        // // reset form
                        $('#projectSheetForm')[0].reset();
                        $('#projectSheetForm').find('select').trigger('change');
                        courseYearFill();

                    },

                    error: function (xhr, response) {
                        if (xhr.status == 422) {
                            toastr.error('Validation Error')
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
@endpush
