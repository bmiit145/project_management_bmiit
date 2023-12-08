@extends('../template/layout')

@section('title', 'Admin Dashboard | PMS')

<!-- @section('content')
@endsection -->

@section('css')

    <link rel="stylesheet" href="{{ asset('../assets/css/flatpickr.min.css') }}"/>


    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection
@section('body')

    <div class="row">
        <div class="col-md-6">

            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Schedule Presentation</h5>
                        <!-- <small class="text-muted float-end">Merged input group</small> -->
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('Schedule.add') }}" id="scheduleForm"
                              enctype="multipart/form-data">
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
                                <label class="form-label" for="assessmentType">Assessment Type</label>
                                <div class="input-group input-group-merge">
                                    {{--                                     <span id="assessmentType2" class="input-group-text">--}}
                                    {{--                                        <i class="bx bx-buildings"></i></span>--}}
                                    <input type="text" id="assessmentType" class="form-control" name="assessmentType"
                                           placeholder="Unit Test | Internal | CIE 1,2,3 "
                                           aria-label="Unit Test | Internal | CIE 1,2,3"
                                           aria-describedby="assessmentType"/>
                                </div>
                                <label id="name-error" class="error" for="assessmentType" style="display: none"></label>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-icon-default-message">Data And Time</label>
                                <div class="input-group input-group-merge">
                                    {{--                                    <input class="form-control" name="datetime" type="datetime-local" value="2022-06-18T08:05" id="html5-date-input">--}}
                                    <input type="text" id="datetime" class="form-control" name="datetime"
                                           placeholder="Select date and time" aria-describedby="datetime">
                                </div>
                                <label id="datetime-error" class="error" for="datetime" style="display: none"></label>
                            </div>
                            <div class="mb-3">
                                <textarea id="emailBody" name="emailBody"></textarea>
                                <label id="emailBody-error" class="error" for="emailBody" style="display: none"></label>
                            </div>
                            {{--  attachment file input  --}}
                            <div class="mb-3">
                                <label for="attachment" class="form-label">Multiple attachments </label>
                                <input type="file" class="form-control" id="attachment" name="attachments[]" multiple>
                            </div>
                            <button type="submit" class="btn btn-primary">Schedule Presentation</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- </div>  -->
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Scheduled Presentation</h5>
                        <!-- <small class="text-muted float-end">Merged input group</small> -->
                    </div>
                    <div class="card-body">
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
                            <table class="table table-striped table-bordered dataTable" style="width:100%"
                                   id="dataTable">
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Course Year</th>
                                    <th>Assessment Type</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    {{--                                    <th>Created At</th>--}}
                                    {{--                                    <th>Updated At</th>--}}
                                    {{--                                    <th>Action</th>--}}
                                </tr>
                                </thead>

                                <tbody>
                                @foreach ($schedules as $key => $schedule)
                                        <?php
                                        $date = date_create($schedule->datetime);
                                        $dateOnly = date_format($date, 'Y-m-d');
                                        $timeOnly = date_format($date, 'h:i:s A');

                                        ?>
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $schedule->courseYear->course->name ." - " . $schedule->courseYear->year->name }}</td>
                                        <td>{{ $schedule->assessmentType }}</td>
                                        <td>{{ $dateOnly }}</td>
                                        <td>{{ $timeOnly }}</td>
                                        {{--                                        <td>{{ $schedule->created_at }}</td>--}}
                                        {{--                                        <td>{{ $schedule->updated_at }}</td>--}}
                                        {{--                                        <td>--}}
                                        {{--                                            <a href="{{ route('Schedule.edit', $schedule->id) }}"--}}
                                        {{--                                               class="btn btn-primary btn-sm">Edit</a>--}}
                                        {{--                                            <a href="{{ route('Schedule.delete', $schedule->id) }}"--}}
                                        {{--                                               class="btn btn-danger btn-sm">Delete</a>--}}
                                        {{--                                        </td>--}}
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://cdn.tiny.cloud/1/694jsilu2i2a150wdh5m7uhmno49slwk405uxocc8cqogt5i/tinymce/5/tinymce.min.js"
            referrerpolicy="origin"></script>
    {{--<script src="{{ asset('../assets/js/tinymce.min.js') }}"></script>--}}
    <script>
        tinymce.init({
            selector: '#emailBody',
            plugins: 'autoresize',
            // toolbar: 'undo redo | formatselect|  bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat'
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | align lineheight | tinycomments | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
        });
    </script>

    <script src="{{ asset('../assets/js/flatpickr.js') }}"></script>
    <!-- jQuery library -->
    {{--    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>--}}
    <script src="{{ asset('../assets/js/jquery-ui.min.js') }}"></script>
    <script>
        flatpickr("#datetime", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            time_24hr: false,
            minDate: "today",
            allowInput: true,
            defaultDate: new Date(),
        });

        $(document).ready(function () {
            var availableAssessmentType = [
                "Unit Test", "Internal", "CIE 1", "CIE 2", "CIE 3", "External", "Final", "Semester"
            ]
            $("#assessmentType").autocomplete({
                source: availableAssessmentType,
                minLength: 1,
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            // Initialize the DataTable
            let dataTable = CreateDataTable();

            dataTable.order(['3', 'desc'], ['4', 'desc'], ['2', 'asc']).draw();
        });
    </script>

    <script>
        $('#scheduleForm').validate({
            // ignore: [],
            rules: {
                "courseYearId": {
                    notEqualValue: "-1",
                },
                "assessmentType": {
                    required: true,
                },
                "datetime": {
                    required: true,
                    validDateTime: true,
                },
            },
            messages: {

                courseYearId: {
                    notEqualValue: "Please select Course Year",
                },
                assessmentType: {
                    required: "Please enter Assessment Type",
                },
                datetime: {
                    required: "Please enter Date and Time",
                    validDateTime: "Please enter valid Date and Time",
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

                // get and set email body
                var content = tinymce.get('emailBody').getContent();
                $('#emailBody').val(content);

                // var formData = $('#scheduleForm').serialize();
                var formData = new FormData($('#scheduleForm')[0]);
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "{{ route('Schedule.add') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    // dataType: "dataType",
                    success: function (res) {
                        if (res.error) {
                            toastr.error(res.error)
                            return;
                        }
                        // console.log(res.success);
                        toastr.success(res.success)

                        $('#scheduleForm')[0].reset();
                        $('#scheduleForm select').trigger('change');
                        courseYearFill();

                        // get and replace table body
                        $.ajax({
                            type: "get",
                            url: "{{ route('ManageSchedule') }}",
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
                                    toastr.success('Something went wrong !')
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
