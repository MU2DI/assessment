<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'School Management System')</title>
    
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/css/adminlte.min.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @stack('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- User Menu -->
                <li class="nav-item">
                    <span class="nav-link">Welcome, {{ Auth::user()->name }}</span>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </nav>

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('dashboard') }}" class="brand-link text-center">
                <span class="brand-text font-weight-light">School System</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                        <!-- Dashboard -->
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <!-- Admin Section -->
                        @can('admin')
                        <li class="nav-header">ADMINISTRATION</li>
                        
                        <!-- Schools -->
                        <li class="nav-item">
                            <a href="{{ route('admin.schools.index') }}" class="nav-link {{ request()->routeIs('admin.schools.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-school"></i>
                                <p>Manage Schools</p>
                            </a>
                        </li>

                        <!-- Users -->
                        <li class="nav-item">
                            <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users-cog"></i>
                                <p>Manage Users</p>
                            </a>
                        </li>
                        @endcan

                        <!-- School Admin Section -->
                        @can('school_admin')
                        <li class="nav-header">SCHOOL MANAGEMENT</li>
                        
                        <!-- Students -->
                        <li class="nav-item">
                            <a href="{{ route('school.students.index') }}" class="nav-link {{ request()->routeIs('school.students.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-graduate"></i>
                                <p>Students</p>
                            </a>
                        </li>

                        <!-- Quick Actions for Students -->
                        <li class="nav-item">
                            <a href="{{ route('school.students.create') }}" class="nav-link {{ request()->routeIs('school.students.create') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-plus-circle"></i>
                                <p>Add New Student</p>
                            </a>
                        </li>

                        <!-- Subjects -->
                        <li class="nav-item">
                            <a href="{{ route('school.subjects.index') }}" class="nav-link {{ request()->routeIs('school.subjects.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-book"></i>
                                <p>Subjects</p>
                            </a>
                        </li>

                        <!-- Exams -->
                        <li class="nav-item">
                            <a href="{{ route('school.exams.index') }}" class="nav-link {{ request()->routeIs('school.exams.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-file-alt"></i>
                                <p>Exams</p>
                            </a>
                        </li>
                        @endcan

                        <!-- Data Entry Section -->
                        @can('data_entry')
                        <li class="nav-header">DATA ENTRY</li>
                        
                        <!-- Marks -->
                        <li class="nav-item">
                            <a href="{{ route('data.marks.create') }}" class="nav-link {{ request()->routeIs('data.marks.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-pen"></i>
                                <p>Enter Marks</p>
                            </a>
                        </li>

                        <!-- View Marks -->
                        <li class="nav-item">
                            <a href="{{ route('data.marks.index') }}" class="nav-link {{ request()->routeIs('data.marks.index') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-list"></i>
                                <p>View Entered Marks</p>
                            </a>
                        </li>
                        @endcan

                        <!-- Reports Section (All Authenticated Users) -->
                        <li class="nav-header">REPORTS</li>
                        
                        <!-- Student Rankings -->
                        <li class="nav-item">
                            <a href="{{ route('reports.rankings') }}" class="nav-link {{ request()->routeIs('reports.rankings') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-chart-line"></i>
                                <p>Student Rankings</p>
                            </a>
                        </li>

                        <!-- School Performance -->
                        <li class="nav-item">
                            <a href="{{ route('reports.school-performance') }}" class="nav-link {{ request()->routeIs('reports.school-performance') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-chart-bar"></i>
                                <p>School Performance</p>
                            </a>
                        </li>

                        <!-- Student Progress -->
                        <li class="nav-item">
                            <a href="{{ route('reports.student-progress') }}" class="nav-link {{ request()->routeIs('reports.student-progress') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-graduate"></i>
                                <p>Student Progress</p>
                            </a>
                        </li>

                        <!-- SYSTEM -->
                        <li class="nav-header">SYSTEM</li>
                        
                        <!-- Profile -->
                        <li class="nav-item">
                            <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user"></i>
                                <p>My Profile</p>
                            </a>
                        </li>

                        <!-- Help -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-question-circle"></i>
                                <p>Help & Support</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Content Header -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">@yield('page_title', 'Dashboard')</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item active">@yield('breadcrumb', 'Dashboard')</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
        </div>

        <!-- Footer -->
        <footer class="main-footer">
            <div class="float-right d-none d-sm-inline-block">
                <b>School Management System</b> v1.0
            </div>
        </footer>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/js/adminlte.min.js"></script>
    
    @stack('scripts')
</body>
</html>