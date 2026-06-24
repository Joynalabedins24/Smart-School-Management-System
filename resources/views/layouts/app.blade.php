<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @vite(['resources/css/style.css'])
    <script src="https://kit.fontawesome.com/ef1ffbecf6.js" crossorigin="anonymous"></script>


</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('home') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    @auth
                    <ul class="navbar-nav me-auto">
                        @role('admin')
                        <li class="dropdown">
                            <a class="nav-link dropdown-toggle" style="color:#727472;" data-bs-toggle="dropdown" aria-expanded="false" href="">
                               Administration
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('permissions.index') }}">permissions</a></li>
                                <li><a class="dropdown-item" href="{{ route('roles.index') }}">Role</a></li>
                                <li><a class="dropdown-item" href="{{ route('users.roles.index') }}">Users Role</a></li>
                                {{--
                                <li><aclass="dropdown-item"href="route('exams.index') ">Exams</a></li>
                                <li><a class="dropdown-item" href="{{ route('AcademicSessions.index') }}">Sessions</a></li>
                                --}}
                            </ul>
                        </li>
                        @endrole
                        <li class="dropdown">
                            <a class="nav-link dropdown-toggle" style="color:#727472;" data-bs-toggle="dropdown" aria-expanded="false" href="{{ route('student.index') }}">
                               Students
                            </a>
                            <ul class="dropdown-menu">
                                @role('student')
                                <li><a class="dropdown-item" href="{{ route('student.profile') }}">Profile</a></li>
                                @endrole
                                @can('Manage students')
                                <li><a class="dropdown-item" href="{{ route('student.index') }}">All Students</a></li>
                                <li><a class="dropdown-item" href="{{ route('StudentSessions.index') }}">Student's Session's</a></li>
                                @endcan
                                @can('Roll assignment')
                                <li><a class="dropdown-item" href="{{ route('roll.assignment') }}">Roll Assignment</a></li>
                                @endcan
                                @can('Promotion')
                                <li><a class="dropdown-item" href="{{ route('promotions.index') }}">Promotion</a></li>
                                @endcan
                            </ul>
                        </li>


                        @canany(['Manage teacher'])
                        <li class="dropdown">

                            <a class="nav-link dropdown-toggle" style="color:#727472;" data-bs-toggle="dropdown" aria-expanded="false" href="">
                               Teachers
                            </a>
                            <ul class="dropdown-menu">
                                @can('Manage teacher')
                                <li><a class="dropdown-item" href="{{ route('teacher.index') }}">All Teachers</a></li>
                                <li><a class="dropdown-item" href="{{ route('TeacherAssignments.index') }}">Teacher's Assignment's</a></li>
                                @endcan
                            </ul>

                        </li>
                        @endcanany

                        @canany(['Manage subject','Manage class','Manage section','Manage exam'])
                        <li class="dropdown">
                            <a class="nav-link dropdown-toggle" style="color:#727472;" data-bs-toggle="dropdown" aria-expanded="false" href="">
                               School Materials
                            </a>
                            <ul class="dropdown-menu">
                                @can('Manage subject')
                                <li><a class="dropdown-item" href="{{ route('subjects.index') }}">Subjects</a></li>
                                @endcan

                                @can('Manage class')
                                <li><a class="dropdown-item" href="{{ route('classe.index') }}">Classes</a></li>
                                @endcan

                                @can('Manage section')
                                <li><a class="dropdown-item" href="{{ route('sections.index') }}">Sections</a></li>
                                @endcan

                                @can('Manage exam')
                                <li><a class="dropdown-item" href="{{ route('exams.index') }}">Exams</a></li>
                                @endcan

                                @role('admin')
                                <li><a class="dropdown-item" href="{{ route('AcademicSessions.index') }}">Sessions</a></li>
                                @endrole
                            </ul>
                        </li>
                        @endcanany


                        @canany(['Manage attendance','View attendance'])
                        <li class="dropdown">
                            <a class="nav-link dropdown-toggle" style="color:#727472;" data-bs-toggle="dropdown" aria-expanded="false" href="">
                               Attendance
                            </a>
                            <ul class="dropdown-menu">
                                @can('Manage attendance')
                                <li><a class="dropdown-item" href="{{ route('attendance.create') }}">Take Attendance</a></li>
                                <li><a class="dropdown-item" href="{{ route('attendance.report' ) }}">Attendance Report</a></li>
                                <li><a class="dropdown-item" href="{{ route('attendance.monthlyReport' ) }}">Monthly Attendance Report</a></li>
                                @endcan
                                @can('View attendance')
                                <li><a class="dropdown-item" href="{{ route('attendance.calendar' ) }}">Individual Attendance History</a></li>
                                @endcan
                            </ul>
                        </li>
                        @endcanany

                        @canany(['Manage result','View results'])
                        <li class="dropdown">
                            <a class="nav-link dropdown-toggle" style="color:#727472;" data-bs-toggle="dropdown" aria-expanded="false" href="">
                               Results
                            </a>
                            <ul class="dropdown-menu">
                                @can('Manage result')
                                <li><a class="dropdown-item" href="{{ route('results.create') }}">Entry Marks By Subject</a></li>
                                <li><a class="dropdown-item" href="{{ route('results.index' ) }}">Subject Wise Result view</a></li>
                                <li><a class="dropdown-item" href="{{ route('attendance.monthlyReport' ) }}"> Class Wise Ranking </a></li>
                                @endcan
                                @can('View results')
                                    <li><a class="dropdown-item" href="{{ route('result.marksheet' ) }}">Individual Result</a></li>
                                @endcan

                            </ul>
                        </li>
                        @endcanany


                        @canany(['manage fees','View ledger'])
                        <li class="dropdown">
                            <a class="nav-link dropdown-toggle" style="color:#727472;" data-bs-toggle="dropdown" aria-expanded="false" href="">
                               Fees
                            </a>
                            <ul class="dropdown-menu">
                                @can('manage fees')
                                <li><a class="dropdown-item" href="{{ route('Fees.create') }}">Fees Generate</a></li>
                                <li><a class="dropdown-item" href="{{ route('Fees.index') }}">Fees list</a></li>
                                <li><a class="dropdown-item" href="{{ route('FeePayments.create') }}">Recive Payment</a></li>
                                <li><a class="dropdown-item" href="{{ route('FeePayments.index') }}">Payment History</a></li>
                                @endcan
                                @can('View ledger')
                                <li><a class="dropdown-item" href="{{ route('FeePayments.ledger') }}">My Financial Ledger</a></li>
                                @endcan
                            </ul>
                        </li>
                        @endcanany


                        <li>

                        </li>

                    </ul>

                    @endauth


                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script>
        (() => {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        const forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.from(forms).forEach(form => {
          form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
              event.preventDefault()
              event.stopPropagation()
            }

            form.classList.add('was-validated')
          }, false)
        })
      })()
    </script>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</html>
