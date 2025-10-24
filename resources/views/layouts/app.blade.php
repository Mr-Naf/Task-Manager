<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Alpha</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        html {
            scroll-behavior: smooth;

            /* Custom Scrollbar */
            scrollbar-width: thin;
            scrollbar-color: #888 #f0f0f0;
        }

        body {
            overflow-x: hidden;
            background-color: #f0f0f0;
        }

        #wrapper {
            transition: all 0.3s ease;
        }

        #sidebar-wrapper {
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            background-color: #fff;
            color: #000;
            padding-top: 60px;
            border-right: 1px solid #dee2e6;
            transition: all 0.3s ease;
        }

        #sidebar-wrapper ul {
            list-style: none;
            padding-left: 0;
        }

        #sidebar-wrapper li {
            padding: 12px 20px;
        }

        #sidebar-wrapper li a {
            color: #000;
            text-decoration: none;
            display: block;

        }

        #sidebar-wrapper li a:hover,
        #sidebar-wrapper li a.active {
            background-color: #f0f0f0;
            border-radius: 4px;

        }

        #page-content-wrapper {
            margin-left: 250px;
            padding: 80px 30px 30px 30px;
            background-color: #fff;
            min-height: 100vh;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        #wrapper.toggled #sidebar-wrapper {
            margin-left: -250px;
        }

        #wrapper.toggled #page-content-wrapper {
            margin-left: 0;
        }

        .navbar {
            background-color: #fff !important;
            color: #000 !important;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .navbar .dropdown-menu {
            min-width: 150px;
        }

        @media (max-width: 768px) {
            #sidebar-wrapper {
                margin-left: -250px;
            }

            #wrapper.toggled #sidebar-wrapper {
                margin-left: 0;
            }

            #page-content-wrapper {
                margin-left: 0;
            }
        }

        .bg-high {
            background-color: #fd7e14 !important;
            /* Orange for High */
        }

        .text-high {
            color: #fd7e14 !important;
        }

        .border-high {
            border-color: #fd7e14 !important;
        }

        .bg-medium {
            background-color: #ffc107 !important;
            /* Yellow for Medium */
        }

        .text-medium {
            color: #ffc107 !important;
        }

        .border-medium {
            border-color: #ffc107 !important;
        }

        .subtask-row {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .subtask-row input[type="text"] {
            flex: 1;
            margin-right: 10px;
        }

        .subtask-row input[type="checkbox"] {
            margin-right: 10px;
        }

        .remove-subtask {
            margin-left: 10px;
        }

        .task-card {
            border: 1px solid #ddd;
            background-color: white;
            cursor: pointer;
            margin-bottom: 10px;
        }

        .task-card:hover {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .toast-container {
            z-index: 1055;
        }
    </style>
</head>

<body>

    <div id="wrapper">
        <!-- Navbar -->
        <nav class="navbar navbar-light fixed-top shadow-sm">
            <div class="container-fluid">
                <button class="btn btn-outline-secondary" id="menu-toggle">
                    <i class="fa fa-bars"></i>
                </button>

                <!-- Profile Dropdown -->
                <div class="dropdown ms-auto">
                    <a class="btn btn-light dropdown-toggle" href="#" role="button" id="profileDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-user me-2"></i> {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="fa fa-user me-2"></i> Profile
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out-alt me-2"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul>
                <li><a href="{{ url('/dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}"><i
                            class="fa fa-home me-2"></i> Dashboard</a></li>
                <li><a href="{{ route('manage.tasks') }}" class="{{ request()->is('tasks*') ? 'active' : '' }}"><i
                            class="fa fa-tasks me-2"></i> Tasks</a></li>
                <li><a href="#"><i class="fa fa-wrench me-2"></i> Services</a></li>
                <li><a href="#"><i class="fa fa-server me-2"></i> Contact</a></li>
            </ul>
        </div>

        <!-- Page Content -->
        <div id="page-content-wrapper">
            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>



    <script>
        $(document).ready(function() {
            // Toggle sidebar
            $("#menu-toggle").click(function(e) {
                e.preventDefault();
                $("#wrapper").toggleClass("toggled");
            });
        });
    </script>
    @yield('scripts')
    @stack('scripts')
</body>

</html>
