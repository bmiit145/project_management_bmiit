<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ url('/') }}" class="app-brand-link">
                    <span class="app-brand-logo demo">
                        <svg width="25" viewBox="0 0 25 42" version="1.1" xmlns="http://www.w3.org/2000/svg"
                             xmlns:xlink="http://www.w3.org/1999/xlink">
                            <defs>
                                <path
                                    d="M13.7918663,0.358365126 L3.39788168,7.44174259 C0.566865006,9.69408886 -0.379795268,12.4788597 0.557900856,15.7960551 C0.68998853,16.2305145 1.09562888,17.7872135 3.12357076,19.2293357 C3.8146334,19.7207684 5.32369333,20.3834223 7.65075054,21.2172976 L7.59773219,21.2525164 L2.63468769,24.5493413 C0.445452254,26.3002124 0.0884951797,28.5083815 1.56381646,31.1738486 C2.83770406,32.8170431 5.20850219,33.2640127 7.09180128,32.5391577 C8.347334,32.0559211 11.4559176,30.0011079 16.4175519,26.3747182 C18.0338572,24.4997857 18.6973423,22.4544883 18.4080071,20.2388261 C17.963753,17.5346866 16.1776345,15.5799961 13.0496516,14.3747546 L10.9194936,13.4715819 L18.6192054,7.984237 L13.7918663,0.358365126 Z"
                                    id="path-1"></path>
                                <path
                                    d="M5.47320593,6.00457225 C4.05321814,8.216144 4.36334763,10.0722806 6.40359441,11.5729822 C8.61520715,12.571656 10.0999176,13.2171421 10.8577257,13.5094407 L15.5088241,14.433041 L18.6192054,7.984237 C15.5364148,3.11535317 13.9273018,0.573395879 13.7918663,0.358365126 C13.5790555,0.511491653 10.8061687,2.3935607 5.47320593,6.00457225 Z"
                                    id="path-3"></path>
                                <path
                                    d="M7.50063644,21.2294429 L12.3234468,23.3159332 C14.1688022,24.7579751 14.397098,26.4880487 13.008334,28.506154 C11.6195701,30.5242593 10.3099883,31.790241 9.07958868,32.3040991 C5.78142938,33.4346997 4.13234973,34 4.13234973,34 C4.13234973,34 2.75489982,33.0538207 2.37032616e-14,31.1614621 C-0.55822714,27.8186216 -0.55822714,26.0572515 -4.05231404e-15,25.8773518 C0.83734071,25.6075023 2.77988457,22.8248993 3.3049379,22.52991 C3.65497346,22.3332504 5.05353963,21.8997614 7.50063644,21.2294429 Z"
                                    id="path-4"></path>
                                <path
                                    d="M20.6,7.13333333 L25.6,13.8 C26.2627417,14.6836556 26.0836556,15.9372583 25.2,16.6 C24.8538077,16.8596443 24.4327404,17 24,17 L14,17 C12.8954305,17 12,16.1045695 12,15 C12,14.5672596 12.1403557,14.1461923 12.4,13.8 L17.4,7.13333333 C18.0627417,6.24967773 19.3163444,6.07059163 20.2,6.73333333 C20.3516113,6.84704183 20.4862915,6.981722 20.6,7.13333333 Z"
                                    id="path-5"></path>
                            </defs>
                            <g id="g-app-brand" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g id="Brand-Logo" transform="translate(-27.000000, -15.000000)">
                                    <g id="Icon" transform="translate(27.000000, 15.000000)">
                                        <g id="Mask" transform="translate(0.000000, 8.000000)">
                                            <mask id="mask-2" fill="white">
                                                <use xlink:href="#path-1"></use>
                                            </mask>
                                            <use fill="#696cff" xlink:href="#path-1"></use>
                                            <g id="Path-3" mask="url(#mask-2)">
                                                <use fill="#696cff" xlink:href="#path-3"></use>
                                                <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-3"></use>
                                            </g>
                                            <g id="Path-4" mask="url(#mask-2)">
                                                <use fill="#696cff" xlink:href="#path-4"></use>
                                                <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-4"></use>
                                            </g>
                                        </g>
                                        <g id="Triangle"
                                           transform="translate(19.000000, 11.000000) rotate(-300.000000) translate(-19.000000, -11.000000) ">
                                            <use fill="#696cff" xlink:href="#path-5"></use>
                                            <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-5"></use>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2"
                  style="text-transform:uppercase;">PMS</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    {{--    if role is admin--}}
    @if( Auth::user()->role == 1)
        <ul class="menu-inner py-1 sidebar-menu">
            <!-- Dashboard -->
            <!-- active open class for future -->
            <li class="menu-item">
                <a href=" {{ url('/admin/dashboard') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-home-circle"></i>
                    <div data-i18n="Analytics">Dashboard</div>
                </a>
            </li>

            <!-- Heading -->
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Basic</span>
            </li>


            <li class="menu-item">
                <a href="{{ route('ManageProgram') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-dock-top"></i>
                    <div data-i18n="Account Settings">Program</div>
                </a>
                {{-- <ul class="menu-sub">
            <li class="menu-item">
              <a href="pages-account-settings-account.html" class="menu-link">
                <div data-i18n="Account">Add Students</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="pages-account-settings-notifications.html" class="menu-link">
                <div data-i18n="Notifications">List Students</div>
              </a>
            </li>
            </ul> --}}
            </li>
            {{--  Acadamic Year --}}
            <li class="menu-item">
                <a href="{{ route('ManageYears') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-dock-top"></i>
                    <div data-i18n="Account Settings">Acadamic Years</div>
                </a>
            </li>
            <!-- Semester -->
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-layout"></i>
                    <div data-i18n="semester">Semester</div>
                </a>

                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{route('ManageSemester')}}" id="semester" class="menu-link">
                            <div data-i18n="semester">Manage Semester</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{route('ManageProgramSemester')}}" id="programSemester" class="menu-link">
                            <div data-i18n="Without navbar">Program Semester</div>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- Courses -->
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-layout"></i>
                    <div data-i18n="Courses">Courses</div>
                </a>

                <ul class="menu-sub">
                    <li class="menu-item ">
                        <a href="{{route('ManageCourses')}}" id="Courses" class="menu-link">
                            <div data-i18n="Courses">Courses</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{route('ManageCourseYears')}}" id="courseYear" class="menu-link">
                            <div data-i18n="Without navbar">Course Year</div>
                        </a>
                    </li>
                </ul>
            </li>


            <!-- Heading -->
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">USERS</span>
            </li>

            <!-- Faculty -->
            <li class="menu-item ">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-layout"></i>
                    <div data-i18n="Faculties">Faculties</div>
                </a>

                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="javascript:void(0);" id="add_faculty" class="menu-link">
                            <div data-i18n="Add Faculty">Add Faculty</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="javascript:void(0);" id="view_faculty" class="menu-link">
                            <div data-i18n="Without navbar">List Faculties</div>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- <li class="menu-header small text-uppercase">
          <span class="menu-header-text">Pages</span>
        </li> -->
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-dock-top"></i>
                    <div data-i18n="Account Settings">Students</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{ route('student.addForm') }}" class="menu-link">
                            <div data-i18n="Account">Add Students</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('ManageStudent') }}" class="menu-link">
                            <div data-i18n="Notifications">List Students</div>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Committee -->
            <li class="menu-item">
                <a href="{{ route('ManageCommittees') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-dock-top"></i>
                    <div data-i18n="Account Settings">Committees</div>
                </a>
            </li>


            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Groups</span>
            </li>

            <!-- Group -->
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-layout"></i>
                    <div data-i18n="Groups">Groups</div>
                </a>

                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{ route('ManageGroups')}}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-dock-top"></i>
                            <div data-i18n="New Group">Create Group</div>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="{{ route('ReviewGroups')}}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-dock-top"></i>
                            <div data-i18n="New Group">Review Group</div>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Allocation -->
            <li class="menu-item">
                <a href="{{ route('ManageAllocations')}}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-dock-top"></i>
                    <div data-i18n="Account Settings">Guide Allocation</div>
                </a>
            </li>

            <!-- Allocation -->
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-layout"></i>
                    <div data-i18n="Groups">Project</div>
                </a>

                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{ route('ManageProjects')}}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-dock-top"></i>
                            <div data-i18n="Account Settings">Project Allocation</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('ProjectReportPage') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-dock-top"></i>
                            <div data-i18n="Account Settings">Report</div>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Presentation  -->
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-layout"></i>
                    <div data-i18n="Presentation">Presentation</div>
                </a>

                <ul class="menu-sub">
                    <li class="menu-item ">
                        <a href="{{route('ManageSchedule')}}" id="Schedule" class="menu-link">
                            <div data-i18n="Schedule">Presentation Schedule</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{route('ManagePresentationPanel')}}" id="Panel" class="menu-link">
                            <div data-i18n="Panels">Presentation Panel</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{route('ManageAllocatePresentation')}}" id="Panel" class="menu-link">
                            <div data-i18n="Panels">Allocate Presentation Panel</div>
                        </a>
                    </li>
                </ul>

            </li>

            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-layout"></i>
                    <div data-i18n="Presentation">Evaluation</div>
                </a>

                <ul class="menu-sub">
                    <li class="menu-item ">
                        <a href="{{route('ManageEvaluations')}}" id="Schedule" class="menu-link">
                            <div data-i18n="Schedule">Add Evaluation Criteria</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{route('ManageAllEvaluations')}}" id="evaluation" class="menu-link">
                            <div data-i18n="evaluation">Evaluations Total Marks</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{route('ManageEvaluationStudentMarks')}}" id="Panel" class="menu-link">
                            <div data-i18n="Panels">Student Marks</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{route('DownloadEvaluationSheet')}}" id="Panel" class="menu-link">
                            <div data-i18n="Panels">Evaluation Sheet Download</div>
                        </a>
                    </li>
                </ul>

            </li>

        </ul>

    @elseif(Auth::user()->role == 0)
        <ul class="menu-inner py-1 sidebar-menu">
            <!-- Dashboard -->
            <!-- active open class for future -->
            <li class="menu-item">
                <a href=" {{ url('/admin/dashboard') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-home-circle"></i>
                    <div data-i18n="Analytics">Dashboard</div>
                </a>
            </li>


            {{--            <!-- Heading -->--}}
            {{--            <li class="menu-header small text-uppercase">--}}
            {{--                <span class="menu-header-text">USERS</span>--}}
            {{--            </li>--}}

            {{--            <!-- Faculty -->--}}
            {{--            <li class="menu-item ">--}}
            {{--                <a href="javascript:void(0);" class="menu-link menu-toggle">--}}
            {{--                    <i class="menu-icon tf-icons bx bx-layout"></i>--}}
            {{--                    <div data-i18n="Faculties">Faculties</div>--}}
            {{--                </a>--}}

            {{--                <ul class="menu-sub">--}}
            {{--                    <li class="menu-item">--}}
            {{--                        <a href="javascript:void(0);" id="add_faculty" class="menu-link">--}}
            {{--                            <div data-i18n="Add Faculty">Add Faculty</div>--}}
            {{--                        </a>--}}
            {{--                    </li>--}}
            {{--                    <li class="menu-item">--}}
            {{--                        <a href="javascript:void(0);" id="view_faculty" class="menu-link">--}}
            {{--                            <div data-i18n="Without navbar">List Faculties</div>--}}
            {{--                        </a>--}}
            {{--                    </li>--}}
            {{--                </ul>--}}
            {{--            </li>--}}

            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Groups</span>
            </li>

            {{-- groups --}}
            <li class="menu-item">
                <a href="{{ route('ManageStudentGroup') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-dock-top"></i>
                    <div data-i18n="Account Settings">Group</div>
                </a>
            </li>
        </ul>

{{--        faculty --}}
    @elseif(Auth::user()->role == 2)
        <ul class="menu-inner py-1 sidebar-menu">
            <!-- Dashboard -->
            <!-- active open class for future -->
            <li class="menu-item">
                <a href=" {{ url('/faculty/dashboard') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-home-circle"></i>
                    <div data-i18n="Analytics">Dashboard</div>
                </a>
            </li>


            {{--            <!-- Heading -->--}}
            {{--            <li class="menu-header small text-uppercase">--}}
            {{--                <span class="menu-header-text">USERS</span>--}}
            {{--            </li>--}}

            {{--            <!-- Faculty -->--}}
            {{--            <li class="menu-item ">--}}
            {{--                <a href="javascript:void(0);" class="menu-link menu-toggle">--}}
            {{--                    <i class="menu-icon tf-icons bx bx-layout"></i>--}}
            {{--                    <div data-i18n="Faculties">Faculties</div>--}}
            {{--                </a>--}}

            {{--                <ul class="menu-sub">--}}
            {{--                    <li class="menu-item">--}}
            {{--                        <a href="javascript:void(0);" id="add_faculty" class="menu-link">--}}
            {{--                            <div data-i18n="Add Faculty">Add Faculty</div>--}}
            {{--                        </a>--}}
            {{--                    </li>--}}
            {{--                    <li class="menu-item">--}}
            {{--                        <a href="javascript:void(0);" id="view_faculty" class="menu-link">--}}
            {{--                            <div data-i18n="Without navbar">List Faculties</div>--}}
            {{--                        </a>--}}
            {{--                    </li>--}}
            {{--                </ul>--}}
            {{--            </li>--}}

            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Groups</span>
            </li>

            {{-- groups --}}
            <li class="menu-item">
                <a href="{{ route('ManageFacultyGroup') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-dock-top"></i>
                    <div>Group</div>
                </a>
            </li>

        </ul>

    @endif

</aside>
<!-- / Menu -->
