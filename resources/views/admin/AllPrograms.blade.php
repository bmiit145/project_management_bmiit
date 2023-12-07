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
                        <h5 class="mb-0">Add new Program</h5>
                        <!-- <small class="text-muted float-end">Merged input group</small> -->
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('program.add') }}" id="addProgramForm">
                            @csrf
                            <span id="error_info">

                            </span>
                            <div class="mb-3">
                                <label class="form-label" for="code">code</label>
                                <div class="input-group input-group-merge">
                                    {{-- <span id="code2" class="input-group-text">
                                        <i class="bx bx-buildings"></i></span> --}}
                                    <input type="text" id="code" class="form-control" name="code"
                                           placeholder="0310341" aria-label="0310341" aria-describedby="code2"/>
                                </div>
                                <label id="code-error" class="error" for="code"></label>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="name">name</label>
                                <div class="input-group input-group-merge">
                                    {{-- <span id="name2" class="input-group-text">
                                        <i class="bx bx-buildings"></i></span> --}}
                                    <input type="text" id="name" class="form-control" name="name"
                                           placeholder="B.Sc(IT)" aria-label="B.Sc(IT)" aria-describedby="name2"/>
                                </div>
                                <label id="name-error" class="error" for="name"></label>
                            </div>


                            <button type="submit" class="btn btn-primary">Add Program</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- </div>  -->
        </div>
        <div class="col-md-6">
            <div class="card">
                <h5 class="card-header "><strong> Program List</strong></h5>

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
                    <table class="table table-hover table-responsive text-nowrap" id="dataTable">
                        <thead>
                        <tr>
                            <th class="select-filter">No.</th>
                            <th>Code</th>
                            <th>Name</th>
                            {{--                            <th>Status</th>--}}
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0 ">
                        {{-- @if (count($programs) != 0) --}}
                        @foreach ($programs as $key => $program)
                            <tr>
                                <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                    <strong>{{ ++$key }}</strong>
                                </td>
                                <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                    <strong>{{ $program->code }}</strong>
                                </td>
                                <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                    <span>{{ $program->name }}</span>
                                </td>
                                {{-- <td>
                            @if ($program->status == 1)
                                <td id="status"><span class="badge bg-label-primary me-1">Active</span></td>
                            @else
                                <td id="status"><span class="badge bg-label-danger me-1">InActive</span></td>
                            @endif
                            </td> --}}
                                <td>
                                    <span class="dropdown-item EditBtn" data-bs-toggle="modal" data-bs-target="#EditModal"
                                       data-id="{{ $program->id }}" onclick="EditBtnClick('{{ $program->id }}')"><i
                                            class="bx bx-edit-alt me-1"></i>
                                    </span>
                                    {{--                                    <div class="dropdown">--}}
                                    {{--                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"--}}
                                    {{--                                                data-bs-toggle="dropdown">--}}
                                    {{--                                            <i class="bx bx-dots-vertical-rounded"></i>--}}
                                    {{--                                        </button>--}}
                                    {{--                                        <div class="dropdown-menu">--}}
                                    {{--                                            <a class="dropdown-item" href="javascript:void(0);"><i--}}
                                    {{--                                                    class="bx bx-edit-alt me-1"></i>--}}
                                    {{--                                                Edit</a>--}}
                                    {{--                                            @if ($program->status == 1)--}}
                                    {{--                                                <a class="dropdown-item" href="javascript:void(0);" id="changeStatus"--}}
                                    {{--                                                   data-username="{{ $program->code }}"--}}
                                    {{--                                                   data-status="{{ $program->status }}"><i class="bx bx-refresh"></i>--}}
                                    {{--                                                    <span>Inactive</span></a>--}}
                                    {{--                                            @else--}}
                                    {{--                                                <a class="dropdown-item" href="javascript:void(0);" id="changeStatus"--}}
                                    {{--                                                   data-username="{{ $program->code }}"--}}
                                    {{--                                                   data-status="{{ $program->status }}"><i--}}
                                    {{--                                                        class="bx bx-refresh"></i>--}}
                                    {{--                                                    <span>Active</span></a>--}}
                                    {{--                                            @endif--}}

                                    {{--                                        </div>--}}
                                    {{--                                    </div>--}}
                                </td>
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

    {{-- Edit Modal --}}
    <div class="modal modal-top fade" id="EditModal" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTopTitle">Edit Program</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
m                    <div class="row">
                        <form id="EditForm">
                            @csrf
                            <input name="id" id="idModal" hidden/>
                            <div class="col mb-3">
                                <label for="codeModal" class="form-label">Code</label>
                                <input type="text" id="codeModal" class="form-control" name="code"
                                       placeholder="Enter Name">
                            </div>
                            <div class="col mb-3">
                                <label for="nameModal" class="form-label">Name</label>
                                <input type="text" id="nameModal" class="form-control" name="name"
                                       placeholder="Enter Name">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="editUpdate">Update</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            // Initialize the DataTable
            var Table = CreateDataTable();
        });

        function EditBtnClick (EditId) {
            // Simulate data retrieval (replace with actual API call)
            const Data = getData(EditId);
        };

        function getData(EditId) {
            // console.log("Get data Called")
            $.ajax({
                type: 'get',
                url: "{{ route('program.getProgram') }}",
                data: {id: EditId},
                success: function (res) {
                    // console.log(res);

                    // Display group details in the modal
                    displayData(res);
                    return res;
                },
            })
        }

        function displayData(data) {
            $('#codeModal').val(data.code);
            $('#nameModal').val(data.name);
            $('#idModal').val(data.id);

            // submit form
            $('#editUpdate').click(function () {
                // console.log("editUpdate Clicked");
                $(document).find('#EditForm').submit();
            });
        }


        // edit form validation
        $('#EditForm').validate({
            rules: {
                "id": {
                    required: true,
                    number: true
                },
                "code": {
                    required: true,
                },
                "name": {
                    required: true,
                },
            },
            messages: {
                id: {
                    required: "Please enter Id",
                },
                code: {
                    required: "Please enter Program Code",
                },
                name: {
                    required: "Please enter Program name",
                },
            },
            submitHandler: function (form, event) {
                event.preventDefault();
                var formData = $('#EditForm').serialize()
                // console.log(formDatda);
                // add id to it
                $.ajax({
                    type: "post",
                    url: "{{ route('program.update') }}",
                    data: formData,
                    // dataType: "dataType",
                    success: function (res) {
                        // console.log(res.success);
                        toastr.success(res.success)
                        $('#EditForm')[0].reset();
                        $('#EditModal').modal('hide');

                        // get and replace table bodyy
                        $.ajax({
                            type: "get",
                            url: "{{ route('ManageProgram') }}",
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
        $('#addProgramForm').validate({
            rules: {
                "name": {
                    required: true,
                },
                "code": {
                    required: true,
                },
            },
            messages: {
                name: {
                    required: "Please enter Program name",
                },
                code: {
                    required: "Please enter Program Code",
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

                var formData = $('#addProgramForm').serialize()
                $.ajax({
                    type: "post",
                    url: "{{ route('program.add') }}",
                    data: formData,
                    // dataType: "dataType",
                    success: function (res) {
                        // console.log(res.success);
                        toastr.success(res.success)
                        $('#addProgramForm')[0].reset();


                        // get and replace table bodyy
                        $.ajax({
                            type: "get",
                            url: "{{ route('ManageProgram') }}",
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
