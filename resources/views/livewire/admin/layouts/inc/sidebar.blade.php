<div>
    <div class="vertical-menu">

        <div data-simplebar class="h-100">

            <!--- Sidemenu -->
            <div id="sidebar-menu">
                <!-- Left Menu Start -->
                <ul class="metismenu list-unstyled" id="side-menu">
                    <li class="menu-title" key="t-menu">Menu</li>

                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="waves-effect">
                            <i class="bx bx-home-circle"></i>
                            <span key="t-dashboard">Dashboard</span>
                        </a>
                    </li>

                    @if (isAdminPermitted('admins_manage'))
                        <li class="menu-title" key="t-user">App Feathurs</li>
                    @endif
                    @if (isAdminPermitted('admins_manage'))
                        <li>
                            <a href="#" class="waves-effect">
                                <i class="bx bx-data"></i>
                                <span key="t-chat">Plan List</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="waves-effect">
                                <i class="bx bx-customize"></i>
                                <span key="t-chat">Coach List</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.activities') }}" class="waves-effect">
                                <i class="bx bx-customize"></i>
                                <span key="t-chat">Activity List</span>
                            </a>
                        </li>
                    @endif

                    @if (isAdminPermitted('admins_manage'))
                        <li class="menu-title" key="t-user">Customer</li>
                    @endif
                    @if (isAdminPermitted('admins_manage'))
                        <li>
                            <a href="{{ route('admin.customers') }}" class="waves-effect">
                                <i class="bx bxs-user-rectangle"></i>
                                <span key="t-chat">Customer List</span>
                            </a>
                        </li>
                    @endif

                    @if (isAdminPermitted('admins_manage'))
                        <li class="menu-title" key="t-user">Message</li>
                    @endif
                    @if (isAdminPermitted('admins_manage'))
                        <li>
                            <a href="{{ route('admin.contact.message') }}" class="waves-effect">
                                <i class="bx bx-message-alt-dots"></i>
                                <span key="t-chat">Messages</span>
                            </a>
                        </li>
                    @endif

                    @if (isAdminPermitted('admins_manage'))
                        <li class="menu-title" key="t-user">Admin</li>
                    @endif
                    @if (isAdminPermitted('admins_manage'))
                        <li>
                            <a href="{{ route('admin.allAdmins') }}" class="waves-effect">
                                <i class="bx bx-user"></i>
                                <span key="t-chat">All Admins</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.team.members') }}" class="waves-effect">
                                <i class="bx bx-user"></i>
                                <span key="t-chat">Team Members</span>
                            </a>
                        </li>
                    @endif

                    @if (isAdminPermitted('settings_manage'))
                        <li class="menu-title" key="t-setting">Setting</li>
                        <li>
                            <a href="#" class="waves-effect">
                                <i class="bx bx-wrench"></i>
                                <span key="t-chat">Settings</span>
                            </a>
                        </li>
                    @endif

                    @if (isAdminPermitted('developer_console'))
                        <li class="menu-title" key="t-setting">Developer Console</li>
                        <li>
                            <a href="{{ route('admin.fatSecretApi') }}" class="waves-effect">
                                <i class="bx bx-lock"></i>
                                <span key="t-chat">Fat Secret API</span>
                            </a>
                        </li>
                    @endif

                    {{-- <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-share-alt"></i>
                            <span key="t-multi-level">Multi Level</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="true">
                            <li><a href="javascript: void(0);" key="t-level-1-1">Level 1.1</a></li>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow" key="t-level-1-2">Level 1.2</a>
                                <ul class="sub-menu" aria-expanded="true">
                                    <li><a href="javascript: void(0);" key="t-level-2-1">Level 2.1</a></li>
                                    <li><a href="javascript: void(0);" key="t-level-2-2">Level 2.2</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li> --}}

                </ul>
            </div>
        </div>
    </div>
</div>
