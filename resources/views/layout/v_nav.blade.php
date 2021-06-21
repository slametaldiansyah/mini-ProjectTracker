<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column text-sm" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

        <li class="nav-header">MENU</li>
        <li class="nav-item">
            <a href="/" class="nav-link {{ (request()->is('/')) ? 'active' : '' }}">
                <i class="nav-icon fas fa-users"></i>
                <p>Master Client</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="/contracts" class="nav-link {{ (request()->is('contracts*')) ? 'active' : '' }}">
                <i class="nav-icon fas fa-file"></i>
                <p>Contracts</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="/projects" class="nav-link
            {{ (request()->is('projects')) ? 'active' : '' }}
            {{ (request()->is('projects/*')) ? 'active' : ''}}">
                <i class="nav-icon fas fa-tasks"></i>
                <p>Projects</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="/operationals" class="nav-link {{ (request()->is('operationals*')) ? 'active' : '' }}">
                <i class="nav-icon fas fa-briefcase"></i>
                <p>Operational & Cost</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="/payments" class="nav-link {{ (request()->is('payments*')) ? 'active' : '' }}">
                <i class="nav-icon fas fa-credit-card"></i>
                <p>Payments</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="/projects_status" class="nav-link {{ (request()->is('projects_status*')) ? 'active' : '' }}">
                <i class="nav-icon fas fa-book"></i>
                <p>Projects Status</p>
            </a>
        </li>

        {{-- <li class="nav-item">
            <a href="/progress_status" class="nav-link {{ (request()->is('progress_status*')) ? 'active' : '' }}">
                <i class="nav-icon fas fa-book"></i>
                <p>Master Status</p>
            </a>
        </li> --}}
        {{-- <div  > --}}
        <li class="nav-header" @if (session()->get('token')['user']['role'] != 'Admin')
            style="display: none"
        @endif>Configuration</li>
        <li class="nav-item" @if (session()->get('token')['user']['role'] != 'Admin')
            style="display: none"
        @endif>
            <a href="/progress_status" class="nav-link {{ (request()->is('progress_status*')) ? 'active' : '' }}">
                <i class="nav-icon fas fa-cog"></i>
                <p>Master Status</p>
            </a>
        </li>
        <li class="nav-item" @if (session()->get('token')['user']['role'] != 'Admin')
            style="display: none"
        @endif>
            <a href="/types" class="nav-link {{ (request()->is('type*')) ? 'active' : '' }}">
                <i class="nav-icon fas fa-cog"></i>
                <p>Type Contract</p>
            </a>
        </li>
        <li class="nav-item" @if (session()->get('token')['user']['role'] != 'Admin')
            style="display: none"
        @endif>
            <a href="/email_configuration" class="nav-link {{ (request()->is('email_configuration*')) ? 'active' : '' }}">
                <i class="nav-icon fas fa-envelope"></i>
                <p>Email Configuration</p>
            </a>
        </li>
        {{-- </div> --}}


        <li class="mt-4 nav-item">
            <a href="{{ route('logout') }}" class="nav-link">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p class="text">Logout</p>
            </a>
        </li>
    </ul>

        {{-- </li>
    </ul> --}}
</nav>
