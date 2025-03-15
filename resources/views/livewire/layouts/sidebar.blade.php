<!-- Sidebar  -->
<aside id="sidebar">
    <div class="sidebar-header sticky-top d-flex justify-content-center mb-3">
        <img src="{{ asset('img/Full-namelogo.png') }}" alt="">
    </div>
    <ul class="list-unstyled ">
        {{-- @dd($rs_parent_menu_utama) --}}
        {{-- @foreach ($rs_parent_menu_utama as $parent_menu_utama)
            @if (empty($rs_child_menu_utama[$parent_menu_utama->menu_id]))
                <li
                    class="menu-item @if ($url_segment == $parent_menu_utama->menu_url) active @endif @if (!$parent_menu_utama->menu_active) disabled @endif">
                    <a href="@if (!$parent_menu_utama->menu_active) # @else {{ url($parent_menu_utama->menu_url) }} @endif"
                        class="menu-link">
                        <i class="menu-icon tf-icons {{ $parent_menu_utama->menu_icon }}"></i>
                        <div data-i18n="{{ $parent_menu_utama->menu_name }}">
                            {{ $parent_menu_utama->menu_name }}
                        </div>
                    </a>
                </li>
            @else
                <!-- memiliki sub menu -->
                <li
                    class="menu-item @if ($url_parent == $parent_menu_utama->menu_url) active open @endif @if (!$parent_menu_utama->menu_active) disabled @endif">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons {{ $parent_menu_utama->menu_icon }}"></i>
                        <div data-i18n="{{ $parent_menu_utama->menu_name }}">{{ $parent_menu_utama->menu_name }}</div>
                    </a>

                    <ul class="menu-sub">
                        @foreach ($rs_child_menu_utama[$parent_menu_utama->menu_id] as $child_menu_utama)
                            <li
                                class="menu-item @if ($url_segment == $child_menu_utama->menu_url) active @endif @if (!$child_menu_utama->menu_active) disabled @endif">
                                <a href="@if (!$child_menu_utama->menu_active) # @else {{ url($child_menu_utama->menu_url) }} @endif "
                                    class="menu-link">
                                    <div data-i18n="{{ $child_menu_utama->menu_name }}">
                                        {{ $child_menu_utama->menu_name }}</div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endif
        @endforeach --}}
        <div class="accordion-item">
            @if (App\Models\Base\BaseModel::isAuthorize('94', 'R'))
        <li class=" {{ request()->routeIs('report.show.report') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="sidebar-menu text-decoration-none text-white"
                wire:navigate.defer>
                <i class="fa-solid fa-gauge-high"></i>
                <span>Dashboard</span>
            </a>
        </li>
    @endif

            @if (App\Models\Base\BaseModel::isAuthorize('90', 'R'))
                <li
                    class="sidebar-menu d-flex justifty-content-between {{ request()->routeIs('projects.show.project') ? 'active' : '' }}">
                    <a class="text-decoration-none text-white d-flex align-items-center"
                        href="{{ route('projects.show.project') }}" wire:navigate.defer>
                        <i class="fa-solid fa-folder-closed"></i>
                        Projects
                    </a>
                    <button class="btn btn-sm text-white p-0 ms-auto border-0 text-end" type="button"
                        data-bs-toggle="collapse" data-bs-target="#projectsCollapse" aria-expanded="true"
                        aria-controls="projectsCollapse">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor"
                            class="bi bi-chevron-down" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708" />
                        </svg> {{--  chevron down --}}
                    </button>
                </li>
            @endif

            @if (request()->routeIs('projects.*') && $projectId)
                <div wire:ignore id="projectsCollapse" class="accordion-collapse collapse show"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        @if (App\Models\Base\BaseModel::isAuthorize('110', 'R'))
                            <li
                                class="sidebar-accordition sidebar-menu {{ request()->routeIs('projects.dashboard.task') ? 'active' : '' }} ">
                                <a class=" text-decoration-none text-white"
                                    href="{{ route('projects.dashboard.task', $projectId) }}" wire:navigate.defer.defer>
                                    <i class="fa-solid fa-chart-simple"></i>
                                    <span>Dashboard Project</span>
                                </a>
                            </li>
                        @endif
                        @if (App\Models\Base\BaseModel::isAuthorize('109', 'R'))
                            <li
                                class="sidebar-accordition sidebar-menu {{ request()->routeIs('projects.tasks.*') ? 'active' : '' }}">
                                <a class="text-decoration-none text-white"
                                    href="{{ route('projects.tasks.show', $projectId) }}" wire:navigate.defer>
                                    <i class="fa-solid fa-list-check"></i>
                                    <span>Tasks</span>
                                </a>
                            </li>
                        @endif
                        @if (App\Models\Base\BaseModel::isAuthorize('111', 'R'))
                            <li
                                class="sidebar-accordition sidebar-menu {{ request()->routeIs('projects.calendar') ? 'active' : '' }}">
                                <a class="text-decoration-none text-white"
                                    href="{{ route('projects.calendar', $projectId) }}">
                                    <i class="fa-solid fa-calendar-week"></i>
                                    <span>Calendar</span>
                                </a>
                            </li>
                        @endif

                        @if (App\Models\Base\BaseModel::isAuthorize('112', 'R'))
                            <li
                                class="sidebar-accordition sidebar-menu {{ request()->routeIs('projects.ganttchart') ? 'active' : '' }}">
                                <a class="text-decoration-none text-white"
                                    href="{{ route('projects.ganttchart', $projectId) }}">
                                    <i class="fa-solid fa-chart-gantt"></i>
                                    <span>Gantt Chart</span>
                                </a>
                            </li>
                        @endif

                        @if (App\Models\Base\BaseModel::isAuthorize('113', 'R'))
                            <li
                                class="sidebar-accordition sidebar-menu {{ request()->routeIs('projects.release.*') ? 'active' : '' }}">
                                <a class="text-decoration-none text-white"
                                    href="{{ route('projects.release.show.release', $projectId) }}"
                                    wire:navigate.defer>
                                    <i class="fa-regular fa-note-sticky"></i>
                                    <span>Release Note</span>
                                </a>
                            </li>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        @if (App\Models\Base\BaseModel::isAuthorize('93', 'R'))
            <li class=" {{ request()->routeIs('budget.*') ? 'active' : '' }}">
                <a href="{{ route('budget.show.budget') }}" class="sidebar-menu text-decoration-none text-white"
                    wire:navigate.defer>
                    <i class="fa-solid fa-money-bill-wave"></i>
                    <span>Budget</span>
                </a>
            </li>
        @endif

        @if (App\Models\Base\BaseModel::isAuthorize('94', 'R'))
            <li class=" {{ request()->routeIs('report.show.report') ? 'active' : '' }}">
                <a href="{{ route('report.show.report') }}" class="sidebar-menu text-decoration-none text-white"
                    wire:navigate.defer>
                    <i class="fa-regular fa-flag"></i>
                    <span>Report</span>
                </a>
            </li>
        @endif

        @if (App\Models\Base\BaseModel::isAuthorize('95', 'R'))
            <li class="sidebar-menu {{ request()->routeIs('time-card.show') ? 'active' : '' }}">
                <a href="{{ route('time-card.show') }}" class="sidebar-menu text-decoration-none text-white"
                    wire:navigate.defer>
                    <i class="fa-solid fa-stopwatch"></i>
                    <span>Time Card</span>
                </a>
            </li>
        @endif

        @if (App\Models\Base\BaseModel::isAuthorize('96', 'R'))
            <li class="sidebar-menu {{ request()->routeIs('availability-tracking.*') ? 'active' : '' }}">
                <a href="{{ route('availability-tracking.show') }}"
                    class="sidebar-menu text-decoration-none text-white" wire:navigate.defer>
                    <i class="fa-solid fa-chart-column"></i>
                    <span>Resources Track</span>
                </a>
            </li>
        @endif

        @if (App\Models\Base\BaseModel::isAuthorize('94', 'R'))
            <li class=" {{ request()->routeIs('work-from-home.show') ? 'active' : '' }}">
                <a href="{{ route('work-from-home.show') }}" class="sidebar-menu text-decoration-none text-white"
                    wire:navigate.defer>
                    <i class="fa-solid fa-house-laptop"></i>
                    <span>Work From Home</span>
                </a>
            </li>
        @endif
        @if (App\Models\Base\BaseModel::isAuthorize('94', 'R'))
            <li class=" {{ request()->routeIs('work-from-home.show') ? 'active' : '' }}">
                <a href="{{ route('work-from-home.show') }}" class="sidebar-menu text-decoration-none text-white"
                    wire:navigate.defer>
                    <i class="fa-solid fa-house-laptop"></i>
                    <span>Monitoring WFH</span>
                </a>
            </li>
        @endif

        

        <div class="accordion-item">
            <li class="sidebar-menu d-flex" data-bs-toggle="collapse" data-bs-target="#masterCollapse"
                aria-expanded="true" aria-controls="masterCollapse">
                <p class=" text-white d-flex align-items-center justify-content-center p-0 m-0">
                    <i class="fa-solid fa-database"></i>
                    Master
                </p>
                <button class="btn btn-sm text-white ms-auto p-0 border-0 text-end" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor"
                        class="bi bi-chevron-down" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708" />
                    </svg> {{--  chevron down --}}
                </button>
            </li>

            <div wire:ignore id="masterCollapse"
                class="accordion-collapse collapse {{ Request::segment(1) == 'master' ? 'show' : '' }}"
                data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    @if (App\Models\Base\BaseModel::isAuthorize('98', 'R'))
                        <li
                            class="sidebar-accordition sidebar-menu {{ request()->routeIs('master.status-wfh') ? 'active' : '' }} ">
                            <a class=" text-decoration-none text-white" href="{{ route('master.status-wfh') }}"
                                wire:navigate.defer.defer>
                                <i class="fa-solid fa-database"></i>
                                <span>Status WFH</span>
                            </a>
                        </li>
                    @endif

                    @if (App\Models\Base\BaseModel::isAuthorize('98', 'R'))
                        <li
                            class="sidebar-accordition sidebar-menu {{ request()->routeIs('master.project-status') ? 'active' : '' }} ">
                            <a class=" text-decoration-none text-white" href="{{ route('master.project-status') }}"
                                wire:navigate.defer.defer>
                                <i class="fa-solid fa-database"></i>
                                <span>Project Status</span>
                            </a>
                        </li>
                    @endif

                    @if (App\Models\Base\BaseModel::isAuthorize('99', 'R'))
                        <li
                            class="sidebar-accordition sidebar-menu {{ request()->routeIs('master.task-status') ? 'active' : '' }} ">
                            <a class=" text-decoration-none text-white" href="{{ route('master.task-status') }}"
                                wire:navigate.defer.defer>
                                <i class="fa-solid fa-database"></i>
                                <span>Task Status</span>
                            </a>
                        </li>
                    @endif

                    @if (App\Models\Base\BaseModel::isAuthorize('101', 'R'))
                        <li
                            class="sidebar-accordition sidebar-menu {{ request()->routeIs('master.task-flag') ? 'active' : '' }} ">
                            <a class=" text-decoration-none text-white" href="{{ route('master.task-flag') }}"
                                wire:navigate.defer.defer>
                                <i class="fa-solid fa-database"></i>
                                <span>Task Flag</span>
                            </a>
                        </li>
                    @endif

                    @if (App\Models\Base\BaseModel::isAuthorize('102', 'R'))
                        <li
                            class="sidebar-accordition sidebar-menu {{ request()->routeIs('master.task-label') ? 'active' : '' }} ">
                            <a class=" text-decoration-none text-white" href="{{ route('master.task-label') }}"
                                wire:navigate.defer.defer>
                                <i class="fa-solid fa-database"></i>
                                <span>Task Label</span>
                            </a>
                        </li>
                    @endif

                    @if (App\Models\Base\BaseModel::isAuthorize('103', 'R'))
                        <li
                            class="sidebar-accordition sidebar-menu {{ request()->routeIs('master.task-category') ? 'active' : '' }} ">
                            <a class=" text-decoration-none text-white" href="{{ route('master.task-category') }}"
                                wire:navigate.defer.defer>
                                <i class="fa-solid fa-database"></i>
                                <span>Task Category </span>
                            </a>
                        </li>
                    @endif

                    @if (App\Models\Base\BaseModel::isAuthorize('104', 'R'))
                        <li
                            class="sidebar-accordition sidebar-menu {{ request()->routeIs('master.budget-category') ? 'active' : '' }} ">
                            <a class=" text-decoration-none text-white" href="{{ route('master.budget-category') }}"
                                wire:navigate.defer.defer>
                                <i class="fa-solid fa-database"></i>
                                <span>Budget Category</span>
                            </a>
                        </li>
                    @endif

                    @if (App\Models\Base\BaseModel::isAuthorize('105', 'R'))
                        <li
                            class="sidebar-accordition sidebar-menu {{ request()->routeIs('master.budget-subcategory') ? 'active' : '' }} ">
                            <a class=" text-decoration-none text-white"
                                href="{{ route('master.budget-subcategory') }}" wire:navigate.defer.defer>
                                <i class="fa-solid fa-database"></i>
                                <span> Budget Sub Category</span>
                            </a>
                        </li>
                    @endif

                    @if (App\Models\Base\BaseModel::isAuthorize('106', 'R'))
                        <li
                            class="sidebar-accordition sidebar-menu {{ request()->routeIs('master.holidays') ? 'active' : '' }} ">
                            <a class=" text-decoration-none text-white" href="{{ route('master.holidays') }}"
                                wire:navigate.defer.defer>
                                <i class="fa-solid fa-database"></i>
                                <span>Holiday</span>
                            </a>
                        </li>
                    @endif

                    @if (App\Models\Base\BaseModel::isAuthorize('107', 'R'))
                        <li
                            class="sidebar-accordition sidebar-menu {{ request()->routeIs('master.uom') ? 'active' : '' }} ">
                            <a class=" text-decoration-none text-white" href="{{ route('master.uom') }}"
                                wire:navigate.defer.defer>
                                <i class="fa-solid fa-database"></i>
                                <span>Unit Of Measure</span>
                            </a>
                        </li>
                    @endif
                </div>
            </div>
        </div>

        <div class="accordion-item">
            @if (App\Models\Base\BaseModel::isAuthorize('01', 'R'))
                <li class="sidebar-menu d-flex" data-bs-toggle="collapse" data-bs-target="#settingCollapse"
                    aria-expanded="true" aria-controls="settingCollapse">
                    <p class=" text-white d-flex align-items-center justify-content-center p-0 m-0">
                        <i class="fa-solid fa-gear"></i>
                        Settings
                    </p>
                    <button class="btn btn-sm text-white ms-auto p-0 border-0 text-end" type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor"
                            class="bi bi-chevron-down" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708" />
                        </svg> {{--  chevron down --}}
                    </button>
                </li>
            @endif

            <div wire:ignore id="settingCollapse"
                class="accordion-collapse collapse {{ Request::segment(1) == 'settings' ? 'show' : '' }}"
                data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    @if (App\Models\Base\BaseModel::isAuthorize('03', 'R'))
                        <li
                            class="sidebar-accordition sidebar-menu {{ request()->routeIs('settings.menu') ? 'active' : '' }} ">
                            <a class=" text-decoration-none text-white" href="{{ route('settings.menu') }}"
                                wire:navigate.defer.defer>
                                <i class="fa-solid fa-bars"></i>
                                <span>Menu</span>
                            </a>
                        </li>
                    @endif

                    @if (App\Models\Base\BaseModel::isAuthorize('02', 'R'))
                        <li
                            class="sidebar-accordition sidebar-menu {{ request()->routeIs('settings.role') ? 'active' : '' }}">
                            <a class="text-decoration-none text-white" href="{{ route('settings.role') }}"
                                wire:navigate.defer>
                                <i class="fa-solid fa-users"></i>
                                <span>Role</span>
                            </a>
                        </li>
                    @endif

                    @if (App\Models\Base\BaseModel::isAuthorize('04', 'R'))
                        <li
                            class="sidebar-accordition sidebar-menu {{ request()->routeIs('settings.account.index') ? 'active' : '' }}">
                            <a class="text-decoration-none text-white" href="{{ route('settings.account.index') }}"
                                wire:navigate.defer>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-person-fill-gear" viewBox="0 0 16 16">
                                    <path
                                        d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0m-9 8c0 1 1 1 1 1h5.256A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1 1.544-3.393Q8.844 9.002 8 9c-5 0-6 3-6 4m9.886-3.54c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382zM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0" />
                                </svg>
                                <span>Account</span>
                            </a>
                        </li>
                    @endif

                    @if (App\Models\Base\BaseModel::isAuthorize('108', 'R'))
                        <li
                            class="sidebar-accordition sidebar-menu {{ request()->routeIs('settings.hierarchy.index') ? 'active' : '' }}">
                            <a class="text-decoration-none text-white" href="{{ route('settings.hierarchy.index') }}"
                                wire:navigate.defer>
                                <i class="fa fa-sitemap"></i>
                                <span>Hierarcy</span>
                            </a>
                        </li>
                    @endif
                </div>
            </div>
        </div>
    </ul>
</aside>

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar').toggleClass('active');
                $('#content').toggleClass('active');
            });

            $('.more-button,.body-overlay').on('click', function() {
                $('#sidebar,.body-overlay').toggleClass('show-nav');
            });

        });
    </script>
@endpush

{{-- humberger menu --}}
{{-- <script type="text/javascript">
$(document).ready(function () {
    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
        $('#content').toggleClass('active');
    });

    $('.more-button,.body-overlay').on('click', function () {
        $('#sidebar,.body-overlay').toggleClass('show-nav');
    });

});
</script> --}}
