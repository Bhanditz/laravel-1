<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
    	<meta charset="utf-8">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <!-- Favicon icon -->
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('resources/assets/img/msw-logo.png') }}"> 

    	<title>MSW Raffle</title>

    	<!-- ./links -->
    	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.css">
    	<link rel="stylesheet" href="{{ asset('resources/assets/css/jquery.datetimepicker.css') }}">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <!-- ./sweetalert css -->
        <link href="{{ asset('resources/assets/css/lib/sweetalert/sweetalert.css') }}" rel="stylesheet">

        @if(Route::is('layout.index'))
            <!-- ./slotmachine css -->
            <link href="{{ asset('resources/assets/css/jquery.slotmachine.css') }}" rel="stylesheet">
        @endif

        <!-- ./dropzone css -->
        <link href="{{ asset('resources/assets/css/lib/dropzone/dropzone.css') }}" rel="stylesheet">

        <!-- Bootstrap Core CSS -->
        <link href="{{ asset('resources/assets/css/lib/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('resources/assets/css/lib/colorpicker/bootstrap-colorpicker.min.css') }}" rel="stylesheet">
        <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet"> -->

        <!-- Custom CSS -->
        <link href="{{ asset('resources/assets/css/helper.css') }}" rel="stylesheet">
        <link href="{{ asset('resources/assets/css/style.css') }}" rel="stylesheet">
        <link href="{{ asset('resources/assets/css/custom-style.css') }}" rel="stylesheet">

    </head>

    <body class="fix-header fix-sidebar">
        <!-- Preloader - style you can find in spinners.css -->
        <div class="preloader">
            <svg class="circular" viewBox="25 25 50 50">
    			<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
        </div>


        <!-- Main wrapper  -->
        <div id="main-wrapper">
            <!-- header header  -->
            <div class="header">
                <nav class="navbar top-navbar navbar-expand-md navbar-light">
                    <!-- Logo -->
                    <div class="navbar-header">
                        <a class="navbar-brand" href="index.html">
                            <!-- Logo icon -->
                            <b><img src="{{ asset('resources/assets/img/msw-logo.png') }}" alt="homepage" class="dark-logo" /></b>
                            <!--End Logo icon -->
                        </a>
                    </div>
                    <!-- End Logo -->
                    <div class="navbar-collapse">
                        <!-- toggle and nav items -->
                        <ul class="navbar-nav mr-auto mt-md-0">
                            <!-- This is  -->
                            <li class="nav-item m-l-45"> <a class="nav-link sidebartoggler hidden-sm-down text-muted  " href="javascript:void(0)"><i class="fa fa-bars"></i></a> </li>
                        </ul>
                        <!-- User profile and search -->
                        <ul class="navbar-nav my-lg-0">

                            <!-- Search -->
                            <li class="nav-item hidden-sm-down search-box"> <a class="nav-link hidden-sm-down text-muted  " href="javascript:void(0)"><i class="ti-search"></i></a>
                                <form class="app-search">
                                    <input type="text" class="form-control" placeholder="Search here"> <a class="srh-btn"><i class="ti-close"></i></a> </form>
                            </li>
                            <!-- Profile -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-muted  " href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{ asset('resources/assets/img/3.png') }}" alt="user" class="profile-pic" /></a>
                                <div class="dropdown-menu dropdown-menu-right animated zoomIn">
                                    <ul class="dropdown-user">
                                        <!-- <li><a href="#"><i class="ti-user"></i> Profile</a></li>
                                        <li><a href="#"><i class="ti-wallet"></i> Balance</a></li>
                                        <li><a href="#"><i class="ti-email"></i> Inbox</a></li>
                                        <li><a href="#"><i class="ti-settings"></i> Setting</a></li> -->
                                        <li><a href="#"><i class="fa fa-power-off"></i> Logout</a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
            <!-- End header header -->
            <!-- Left Sidebar  -->
            <div class="left-sidebar">
                <!-- Sidebar scroll-->
                <div class="scroll-sidebar">
                    <!-- Sidebar navigation-->
                    <nav class="sidebar-nav">
                        <ul id="sidebarnav">
                            <li class="nav-devider"></li>
                            <li class="nav-label">Main</li>
                            <!-- <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-tachometer"></i><span class="hide-menu">Dashboard <span class="label label-rounded label-primary pull-right">2</span></span></a>
                                <ul aria-expanded="false" class="collapse">
                                    <li><a href="index.html">Ecommerce </a></li>
                                    <li><a href="index1.html">Analytics </a></li>
                                </ul>
                            </li> -->
                            <li>
                                <a href="{{ route('promo.index') }}" aria-expanded="false">
                                    <i class="fa fa-tags"></i>
                                    <span class="hide-menu">Promo</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('prize.index') }}" aria-expanded="false">
                                    <i class="fa fa-gift"></i>
                                    <span class="hide-menu">Prize</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('records.index') }}" aria-expanded="false">
                                    <i class="fa fa-th-list"></i>
                                    <span class="hide-menu">Records</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('layout.index') }}" aria-expanded="false">
                                    <i class="fa fa-wpforms"></i>
                                    <span class="hide-menu">Layout</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <!-- End Sidebar navigation -->
                </div>
                <!-- End Sidebar scroll-->
            </div>
            <!-- End Left Sidebar  -->

        
            <!-- Page wrapper  -->
            <div class="page-wrapper">
                <!-- Bread crumb -->
                <!-- <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h3 class="text-primary">Promo</h3> </div>
                    <div class="col-md-7 align-self-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Promo</li>
                        </ol>
                    </div>
                </div> -->
                <!-- End Bread crumb -->
                <!-- Container fluid  -->
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- End Container fluid  -->
                <!-- footer -->
                <footer class="footer"> © 2018 All rights reserved.</footer>
                <!-- End footer -->
            </div>
            <!-- End Page wrapper  -->
        </div>
        <!-- End Wrapper -->


        <!-- All Jquery -->
        <!-- <script src="//code.jquery.com/jquery-1.11.0.min.js"></script> -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <!-- <script src="{{ asset('resources/assets/js/lib/jquery/jquery.min.js') }}"></script> -->
        
        <script src="{{ asset('resources/assets/js/lib/bootstrap/js/popper.min.js') }}"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <!-- Bootstrap JavaScript -->
        <!-- <script src="{{ asset('resources/assets/js/lib/bootstrap/js/bootstrap.min.js') }}"></script> -->
        <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->

        <!-- Bootstrap tether Core JavaScript -->

        <!-- slimscrollbar scrollbar JavaScript -->
        <script src="{{ asset('resources/assets/js/jquery.slimscroll.js') }}"></script>.

        <!-- datetimepicker -->
        <script src="{{ asset('resources/assets/js/jquery.datetimepicker.js') }}"></script>

        <!--Menu sidebar -->
        <script src="{{ asset('resources/assets/js/sidebarmenu.js') }}"></script>

        <!--stickey kit -->
        <script src="{{ asset('resources/assets/js/lib/sticky-kit-master/dist/sticky-kit.min.js') }}"></script>

        <!-- colorpicker -->
        <script src="{{ asset('resources/assets/js/lib/colorpicker/bootstrap-colorpicker.min.js') }}"></script>

        <!-- ./sweetalert -->
        <script src="{{ asset('resources/assets/js/lib/sweetalert/sweetalert.min.js') }}"></script>

        <!-- ./dropzone -->
        <script src="{{ asset('resources/assets/js/lib/dropzone/dropzone.js') }}"></script>

        <!--Custom JavaScript -->
        <script src="{{ asset('resources/assets/js/scripts.js') }}"></script>

        <!-- ./rty custom scripts -->
        <script src="{{ asset('resources/assets/js/custom.js') }}"></script>

        @if(Route::is('records.index'))
            <script src="{{ asset('resources/assets/js/dragdrop.js') }}"></script>
        @endif

        @if(Route::is('layout.index'))
            <script src="{{ asset('resources/assets/js/layout.js') }}"></script>
            <!-- <script src="{{ asset('resources/assets/js/machines/text-shuffler.js') }}"></script>
            <script src="{{ asset('resources/assets/js/machines/text-slot-machine.js') }}"></script> -->
            <script src="{{ asset('resources/assets/js/machines/word-slot-machine.js') }}"></script>
        @endif

        <!-- ./datatables -->
        <script src="{{ asset('resources/assets/js/lib/datatables/datatables.min.js') }}"></script>
        <script src="{{ asset('resources/assets/js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('resources/assets/js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js') }}"></script>
        <script src="{{ asset('resources/assets/js/lib/datatables/cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js') }}"></script>
        <script src="{{ asset('resources/assets/js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js') }}"></script>
        <script src="{{ asset('resources/assets/js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js') }}"></script>
        <script src="{{ asset('resources/assets/js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('resources/assets/js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js') }}"></script>
        <script src="{{ asset('resources/assets/js/lib/datatables/datatables-init.js') }}"></script>

        <!-- ./url -->
        <script>
            var url_promo = "{{ route('promo.index') }}";
            var url_prize = "{{ route('prize.index') }}";
            var url_records = "{{ route('records.index') }}";
            var url_assets = "{{ asset('resources/assets') }}";
        </script>

        @extends('layout.modal')
    </body>
</html>