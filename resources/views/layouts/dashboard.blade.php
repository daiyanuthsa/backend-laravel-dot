<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>@yield('title')</title>
    {{-- Stylesheet --}}
    @stack('prepend-style')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <link href="/css/main.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/2.1.7/css/dataTables.dataTables.min.css" rel="stylesheet">
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css"> --}}
    @stack('addon-style')

</head>

<body>
    <div class="page-dashboard">
        <div class="d-flex" id="wrapper">
            <!-- Sidebar Menu -->
            <div class="border-right" id="sidebar-wrapper" data-aos="fade-right" data-aos-duration="800">
                <div class="sidebar-heading text-center">
                    <img src="/images/admin.png" alt="" class="my-4" style="max-width: 150px" />
                </div>
                <a href="{{ route('book') }}"
                    class="list-group-item list-group-item-action {{ request()->is('book*') ? 'active' : '' }}">
                    Buku
                </a>

                <a href="{{ route('category.index') }}"
                    class="list-group-item list-group-item-action {{ request()->is('category*') ? 'active' : '' }}">
                    Categories
                </a>
                <a href="{{ route('logout') }}" class="list-group-item list-group-item-action text-red">
                    Sign Out
                </a>
            </div>

            <!-- Page Content -->
            <div id="page-content-wrapper">
                <nav class="navbar navbar-expand-lg navbar-light navbar-store fixed-top " data-aos="fade-down">
                    <div class="container-fluid">
                        <button class="btn btn-secondary d-md-none  mr-2" id="menu-toggle">
                            &laquo;Menu
                        </button>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-target="#navbarSupportedContent">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">

                            <!-- Dekstop Menu -->
                            <ul class="navbar-nav d-none d-lg-flex ml-auto">
                                <li class="nav-item dropdown">
                                    <a href="#" class="nav-link" id="navbarDropdown" role="button"
                                        data-bs-toggle="dropdown">
                                        <img src="/images/icon-user.png" alt="icon-user"
                                            class="rounded-circle mr-2 profile-picture" />
                                        Hi, Angga
                                    </a>
                                    <div class="dropdown-menu">
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>
                                        <a href="#" class="dropdown-item"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>
                                    </div>
                                </li>

                            </ul>

                            <ul class="navbar-nav d-block d-lg-none">
                                <li class="nav-item">
                                    <a href="#" class="nav-link"> Hi, Angga </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link d-inline-block"> Cart </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>

                <!-- Content -->
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    @stack('prepend-script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.mxpnl.com/libs/mixpanel-2-latest.min.js"></script>

    <script src="https:////cdn.datatables.net/2.1.7/js/dataTables.min.js"></script>
    {{-- <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script> --}}
    <script>
        AOS.init();
    </script>
    <script>
        $('#menu-toggle').click(function(e) {
            e.preventDefault();
            $('#wrapper').toggleClass('toggled');
            AOS.refresh();
        });
    </script>
    @stack('addon-script')

</body>

</html>
