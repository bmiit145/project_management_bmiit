<nav
    class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar"
>
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

        <div class="navbar-nav align-items-center">
            <div class="nav-item d-flex align-items-center">
                <i class="bx bx-search fs-4 lh-0"></i>
                <input
                    type="text"
                    class="form-control border-0 shadow-none"
                    placeholder="Search..."
                    aria-label="Search..."
                />
            </div>
        </div>
        <ul class="navbar-nav flex-row align-items-center ms-auto">
            <!-- Place this tag where you want the button to render. -->


            <!-- Program -->
            <div class="navbar-nav align-items-center">
                <div class="nav-item d-flex align-items-center" style="width: 300px">
                    {{--                    <i class="bx bx-search fs-4 lh-0"></i>--}}
                    <select class="form-select selectSearch" id="NavProgram"
                            aria-label="Default select example">
                        <option value="-1" selected>select Program</option>
                        {{--                        @foreach ($courseYears as $courseYear)--}}
                        {{--                            <option value="{{ $courseYear->id }}">{{ $courseYear->course->name }}--}}
                        {{--                                - {{ $courseYear->year->name }}--}}
                        {{--                            </option>--}}s
                        {{--                        @endforeach--}}
                    </select>
                </div>
            </div>
            <!-- Program -->

            <!-- Semester -->
            <div class="navbar-nav align-items-center">
                <div class="nav-item d-flex align-items-center mx-2" style="width: 120px">
                    {{--                    <i class="bx bx-search fs-4 lh-0"></i>--}}
                    <select class="form-select selectSearch" id="NavSemester"
                            aria-label="Default select example">
                        <option value="-1" selected>Semester</option>
                        {{--                                                @foreach ($courseYears as $courseYear)--}}
                        {{--                                                    <option value="{{ $courseYear->id }}">{{ $courseYear->course->name }}--}}
                        {{--                                                        - {{ $courseYear->year->name }}--}}
                        {{--                                                    </option>s--}}
                        {{--                                                @endforeach--}}
                    </select>
                </div>
            </div>
            <!-- Semester -->

            <!-- Search -->
            <div class="navbar-nav align-items-center">
                <div class="nav-item d-flex align-items-center" style="width: 300px">
                    {{--                    <i class="bx bx-search fs-4 lh-0"></i>--}}
                    <select class="form-select selectSearch" id="NavcourseYear"
                            aria-label="Default select example">
                        <option value="-1" selected>select Course and Acadamic Year</option>
                        {{--                        @foreach ($courseYears as $courseYear)--}}
                        {{--                            <option value="{{ $courseYear->id }}">{{ $courseYear->course->name }}--}}
                        {{--                                - {{ $courseYear->year->name }}--}}
                        {{--                            </option>--}}s
                        {{--                        @endforeach--}}
                    </select>
                </div>
            </div>
            <!-- /Search -->

            <!-- User -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        <img src="../assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle"/>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="#">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                        <img src="../assets/img/avatars/1.png" alt
                                             class="w-px-40 h-auto rounded-circle"/>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    @if(auth()->user()->role != 1)
                                        <span
                                                class="fw-semibold d-block">{{ auth()->user()->user->fname . ' '. auth()->user()->user->lname }}
                                        </span>
                                    @else
                                        <span
                                                class="fw-semibold d-block text-capitalize">{{ auth()->user()->username }}
                                        </span>
                                    @endif
                                    <small class="text-muted">
                                        @if(auth()->user()->role == 1)
                                            Admin
                                        @elseif(auth()->user()->role == 2)
                                            Teacher
                                        @elseif(auth()->user()->role == 0)
                                            Student
                                        @endif
                                    </small>
                                </div>
                            </div>
                        </a>
                    </li>
                    {{--                    <li>--}}
                    {{--                        <div class="dropdown-divider"></div>--}}
                    {{--                    </li>--}}
                    {{--                    <li>--}}
                    {{--                        <a class="dropdown-item" href="#">--}}
                    {{--                            <i class="bx bx-user me-2"></i>--}}
                    {{--                            <span class="align-middle">My Profile</span>--}}
                    {{--                        </a>--}}
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('changePasswordPage')}}">
                            <i class='bx bxs-edit-alt me-2'></i>
                            <span class="align-middle">Change Password</span>
                        </a>
                    </li>
                    <!-- <li>
                      <a class="dropdown-item" href="#">
                        <i class="bx bx-cog me-2"></i>
                        <span class="align-middle">Settings</span>
                      </a>
                    </li> -->
                    <!-- <li>
                      <a class="dropdown-item" href="#">
                        <span class="d-flex align-items-center align-middle">
                          <i class="flex-shrink-0 bx bx-credit-card me-2"></i>
                          <span class="flex-grow-1 align-middle">Billing</span>
                          <span class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20">4</span>
                        </span>
                      </a>
                    </li> -->
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{route('auth.logout')}}">
                            <i class="bx bx-power-off me-2"></i>
                            <span class="align-middle">Log Out</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!--/ User -->
        </ul>
    </div>
</nav>
