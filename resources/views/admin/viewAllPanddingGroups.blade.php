@extends('../template/layout')

@section('title', 'Student Dashboard | PMS')

<!-- @section('content')
@endsection -->

@section('body')

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
                                <th>Students</th>
                                <th>Course Year</th>
                                <th>Created By</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach( $panddingGroups as $group)
                                <tr>
                                    <td>{{ $group->title ? $group->title:"No any Project Title Given" }}</td>
                                    {{--                                    <td>{{ $group->definition?$group->definition == null ?"No any Project Definition Given": $group->definition : "No any Project Title Given" }}</td>--}}
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
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <button class="btn btn-primary btn-sm me-2 view-details-btn"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#panddingGroupModal"
                                                    data-group-num="{{ $group->groupNumber }}"><i
                                                    class='bx bxs-card'></i></button>
                                            <form action="{{ route('PanddingGroup.delete', $group->groupNumber) }}"
                                                  method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <h5 class="mb-0"> No Pending Groups </h5>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{--   Model for view a data of pandding group --}}
    <div class="modal fade" id="panddingGroupModal" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalScrollableTitle">Review a Group</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" id="ModalForm">
                        @csrf
                        <input type="hidden" name="groupNumber">
                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="w-100 d-flex justify-content-between align-items-center">
                                            <div class="text-gray-600 font-weight-bold">
                                                <span id="model_courseYear"></span>
                                            </div>
                                        </div>
                                        <div>
                                            <span class="badge badge-primary text-dark"
                                                  id="member_length">10 Members</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="members" class="form-label">Students</label>
                                    <ul id="member_list">

                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Project Title</label>
                                    <input type="text" class="form-control" id="title" name="title"
                                           placeholder="Enter Project Title" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="definition" class="form-label">Project Definition</label>
                                    <textarea class="form-control" id="definition" name="definition"
                                              placeholder="Enter Project Definition" required></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Approve</button>

                    <form action="{{ route('PanddingGroup.delete' , 0) }}"
                          method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Reject</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{--    view all students group where login student have--}}

    {{--    <div class="row">--}}
    {{--        @foreach($groups as $group)--}}
    {{--            <div class="col-md-12 col-lg-6 mb-4">--}}
    {{--                <div class="card">--}}
    {{--                    <div class="col-12">--}}
    {{--                        <div class="card-header">--}}
    {{--                            <div class="d-flex justify-content-between align-items-center">--}}
    {{--                                <div class="w-100 d-flex justify-content-between align-items-center">--}}
    {{--                                    <div class="ms-2 me-2 w-100 d-flex flex-column justify-content-between"--}}
    {{--                                         style="text-align: center ;">--}}
    {{--                                        <div class="font-weight-bold">--}}
    {{--                                            <a href="">--}}
    {{--                                                {{"Group No .\t" . $group->group->number }}--}}
    {{--                                            </a>--}}
    {{--                                        </div>--}}
    {{--                                        <div class="text-gray-600">--}}
    {{--                                            {{ $group->courseYear->course->code . " - " . $group->courseYear->course->name . " - " . $group->courseYear->year->name }}--}}
    {{--                                        </div>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                                <div>--}}
    {{--                                    <span class="badge badge-primary text-dark">{{ $group->group->studentGroups->count() }} Members</span>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                        <div class="card-body">--}}
    {{--                            <h4 class="card-title mb-1 text-nowrap">{{ $group->group->project?$group->group->project->title:"No any Project Title Given" }}</h4>--}}
    {{--                            <p class="d-block mb-3 text-wrap"--}}
    {{--                               style="font-size: medium">{{ $group->group->project?$group->group->project->definition == null ?"No any Project Definition Given": $group->group->project->definition : "No any Project Title Given" }}</p>--}}

    {{--                            <h5 class="card-title  mb-2">Guide : <span--}}
    {{--                                    class="text-primary">{{ $group->group->allocation ? $group->group->allocation->faculty->fname . " " . $group->group->allocation->faculty->lname :"No any Guide Assigned" }}</span>--}}
    {{--                            </h5>--}}

    {{--                            @foreach( $group->group->studentGroups as $student)--}}
    {{--                                <small class="d-block pb-1"--}}
    {{--                                       style="font-size: math">{{$student->studentenro . "\t" . $student->student->fname . "\t" . $student->student->lname }}</small>--}}
    {{--                            @endforeach--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        @endforeach--}}
    {{--    </div>--}}

@endsection

@push('scripts')
    {{-- for modal --}}
    <script>
        $(document).ready(function () {
            $('.view-details-btn').on('click', function () {
                const groupNum = $(this).data('group-num');

                // Simulate data retrieval (replace with actual API call)
                const groupDetails = getGroupDetails(groupNum);

            });
        });

        function getGroupDetails(groupNum) {
            // send ajax to get the Pandding Group Details
            $.ajax({
                type: 'get',
                url: "{{ route('PanddingGroup.getDetails') }}",
                data: {groupNum: groupNum},
                success: function (res) {
                    // console.log(res);

                    // Display group details in the modal
                    displayGroupDetails(res);

                    return res;
                },
            })
        }


        function displayGroupDetails(groupDetails) {
// Display group details in the modal
            var groupDetail = groupDetails[0];
            var members = groupDetails[0].member;
            var memberCount = members.length;

            $('#panddingGroupModal').find('input[name="groupNumber"]').val(groupDetail.groupNumber);
            $('#panddingGroupModal').find('#model_courseYear').text(groupDetail.code + " - " + groupDetail.course + "   " + groupDetail.year);
            $('#panddingGroupModal').find('#title').val(groupDetail.title);
            $('#panddingGroupModal').find('#definition').val(groupDetail.definition);
            $('#panddingGroupModal').find('#member_length').text(memberCount + " Members");
            $('#panddingGroupModal').find('#member_list').html('');
            $.each(members, function (index, member) {
                $('#panddingGroupModal').find('#member_list').append('<li>' + member.enro + "\t" + member.fname + "\t" + member.lname + '</li>');
            });

            // set form action in model for delete
            $('#panddingGroupModal').find('form').attr('action', "{{ route('PanddingGroup.delete', '') }}" + "/" + groupDetail.groupNumber);

            // set form action in model for approve
            $('#panddingGroupModal').find('.btn-primary').attr('onclick', "approveGroup(" + groupDetail.groupNumber + ")");
        }

        function approveGroup(GroupNumber) {
            // submit form for approve with ajax

            var formData = $('#panddingGroupModal').find('#ModalForm').serialize();
            formData += "&GroupNum=" + GroupNumber;

            $.ajax({
                type: 'post',
                url: "{{ route('PanddingGroup.approve') }}",
                data: formData,
                success: function (res) {
                    // console.log(res);
                    if (res.error) {
                        toastr.error(res.error)
                        return;
                    }
                    toastr.success(res.success)

                    $('#panddingGroupModal').modal('hide');
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
            })
        }
    </script>
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
                    required: true,
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
