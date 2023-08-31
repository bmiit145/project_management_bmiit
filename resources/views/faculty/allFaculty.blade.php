{{-- @dd($faculties) --}}

<!-- Hoverable Table rows -->
<div class="card">
    <h5 class="card-header "> <strong> Faculty List</strong></h5>
    <div class="table-responsive text-nowrap">
        <table class="table table-hover table-responsive text-nowrap">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Phone no.</th>
                    <th>Email</th>
                    <th>Designation</th>
                    <th>Date of Join</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @if (count($faculties) != 0)
                    @foreach ($faculties as $key => $faculty)
                        <tr>

                            <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                <strong>{{ ++$key }}</strong>
                            </td>
                            <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                <strong>{{ $faculty->fname }}</strong>
                            </td>
                            <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                <strong>{{ $faculty->lname }}</strong>
                            </td>
                            <td>{{ $faculty->contactno }}</td>
                            <td>{{ $faculty->email }}</td>
                            <td>{{ $faculty->designation }}</td>
                            <td>{{ date('d-m-Y', strtotime($faculty->doj)) }}</td>
                            @if ($faculty->status == 1)
                                <td id="status"><span class="badge bg-label-primary me-1">Active</span></td>
                            @else
                                <td id="status"><span class="badge bg-label-danger me-1">InActive</span></td>
                            @endif
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="bx bx-edit-alt me-1"></i>
                                            Edit</a>
                                        @if ($faculty->status == 1)
                                            <a class="dropdown-item" href="javascript:void(0);" id="changeStatus"
                                                data-username="{{ $faculty->username }}"
                                                data-status="{{ $faculty->status }}"><i class="bx bx-refresh"></i>
                                                <span>Inactive</span></a>
                                        @else
                                            <a class="dropdown-item" href="javascript:void(0);" id="changeStatus"
                                                data-username="{{ $faculty->username }}"
                                                data-status="{{ $faculty->status }}"><i class="bx bx-refresh"></i>
                                                <span>Active</span></a>
                                        @endif

                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="9" style="text-align: center">No record Found !</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<script>
    // $(document).on('click', '#changeStatus', function() {
    //     // alert(username);
    //     var username = $(this).data('username')
    //     // var trWithStatus = $('td#status').closest('tr');
    //     var trWithStatus = $(document).find('[data-username="' + username + '"]').closest('td').siblings('td#status')
    //     var aWithUsername = $(document).find('[data-username="' + username + '"]').children('span')
    //     var status = $(document).find('[data-username="' + username + '"]').data('status');

    //     $.ajax({
    //         type: "POST",
    //         url: "{{ route('changeFacultyStatus') }}",
    //         data: {
    //             "_token": "{{ csrf_token() }}",
    //             "username": username,
    //         },
    //         success: function(response) {
    //             //  console.log(response);

    //             console.log(trWithStatus.html());
    //             if (status == '1') {
    //                 // tag.text("adc")
    //                 trWithStatus.html(' <span class="badge bg-label-danger me-1">InActive</span>')
    //                 aWithUsername.html('Active')
    //                 $(document).find('[data-username="' + username + '"]').attr('data-status', 0)
    //                 console.log(status)
    //             } else {
    //                 trWithStatus.html('<span class="badge bg-label-primary me-1">Active</span>')
    //                 aWithUsername.html('Inactive')
    //                 $(document).find('[data-username="' + username + '"]').attr('data-status', 1)
    //                 console.log(status)
    //             }
    //             //  console.log($msg);
    //         },
    //         error: function(response) {
    //             console.log(response);
    //         }
    //     });

    // })


    $(document).on('click', '#changeStatus', function() {
                let username = $(this).data('username');
                let userClass = $(document).find('[data-username="' + username + '"]')
                // console.log("userClass", userClass.html());
                let trWithStatus = userClass.closest('td').siblings(
                    'td#status');
                // console.log("trWithStatus", trWithStatus.html());
                let aWithUsername = userClass.children('span');
                // console.log("aWithUsername", aWithUsername.html());
                let status = userClass.data('status');
                // console.log("status", status);

                $.ajax({
                        type: "POST",
                        url: "{{ route('changeFacultyStatus') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "username": username,
                        },
                        success: function(response) {
                            if (status == '1') {
                                // console.log("status 1 work");
                                trWithStatus.html('<span class="badge bg-label-danger me-1">Inactive</span>');
                                aWithUsername.html('Active');
                                userClass.data('status', 0);
                            } else if (status == '0') {
                                // console.log("status 0 work");
                                trWithStatus.html('<span class="badge bg-label-primary me-1">Active</span>');
                                aWithUsername.html('Inactive');
                                userClass.data('status', 1);
                            } else {
                                alert("not working")
                            }
                            // Update the status variable after the AJAX call
                            status = status == '1' ? '0' : '1';
                        },
                        error: function(xhr , response) {
                            if (xhr.status == 422) { 
                            var errors = xhr.responseJSON.errors;

                            $.each(errors, function(field, messages) {
                                $.each(messages, function(index, message) {
                                    toastr.error(messages)
                                });
                            });
                        }

                        });
                });
</script>
<!--/ Hoverable Table rows -->
