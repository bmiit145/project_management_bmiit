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

                @foreach ($faculties as $key => $faculty)
                <tr>

                    <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{++$key}}</strong></td>
                    <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{$faculty->fname}}</strong></td>
                    <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{$faculty->lname}}</strong></td>
                    <td>{{$faculty->contactno}}</td>
                    <td>{{$faculty->email}}</td>
                    <td>{{$faculty->designation}}</td>
                    <td>{{date('d-m-Y', strtotime($faculty->doj))}}</td>
                    @if ($faculty->status == 1)
                    <td><span class="badge bg-label-primary me-1">Active</span></td>    
                    @else
                    <td><span class="badge bg-label-danger me-1">InActive</span></td>    
                        
                    @endif
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i>
                                    Edit</a>
                                <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i>
                                    Delete</a>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!--/ Hoverable Table rows -->
