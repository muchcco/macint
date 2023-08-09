<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Starter Page | Hyper - Responsive Bootstrap 5 Admin Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description">
        <meta content="Coderthemes" name="author">
        <!-- App favicon -->
        {{-- <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico')}}"> --}}

        <!-- App css -->
        <link href="{{ asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/css/app.min.css')}}" rel="stylesheet" type="text/css" id="light-style">
        <link href="{{ asset('assets/css/app-dark.min.css')}}" rel="stylesheet" type="text/css" id="dark-style">


        <link href="{{ asset('https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css')}}" rel="stylesheet" type="text/css" id="dark-style">        
        <link href="{{ asset('https://cdn.jsdelivr.net/npm/sweetalert2@11.7.20/dist/sweetalert2.min.css')}}" rel="stylesheet">

        {{-- preoad button --}}
        <link rel="stylesheet" href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css')}}">

        @yield('estilo')

        <style>
            .txt-mid {
                margin-left: 50px;
            }

            table thead, tr, th {
                padding: .5em !important;
                margin: .2em !important;
            }

            table tbody, tr, td {
                padding: .5em !important;
                margin: .2em !important;
                vertical-align: middle !important;
            }

            .hasError{
                border: 1px solid #f00 !important;
            }

            .nobtn{
                background: none !important;
                border: none !important;
                margin: 0 !important;
                padding: 0 !important;
                cursor: pointer;            
                color: blue;
                font-size: 1em;
            }

            .nobtn:hover{   
                text-decoration: underline; 
            }

        </style>

    </head>

    <body class="loading" data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>
        <!-- Begin page -->
        <div class="wrapper">
            <!-- ========== Left Sidebar Start ========== -->
            
            @include('secciones.sidebar')

            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="content">
                    <!-- Topbar Start -->
                    
                    @include('secciones.header')

                    <!-- end Topbar -->

                    <!-- Start Content-->
                    <div class="container-fluid">
                        
                        <!-- start page title -->
                        <div class="row">
                            @yield('main')
                        </div>     
                        <!-- end page title --> 
                        
                    </div> <!-- container -->

                </div> <!-- content -->

                <!-- Footer Start -->
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <script>document.write(new Date().getFullYear())</script> © Hyper - Coderthemes.com
                            </div>
                            <div class="col-md-6">
                                <div class="text-md-end footer-links d-none d-md-block">
                                    <a href="javascript: void(0);">About</a>
                                    <a href="javascript: void(0);">Support</a>
                                    <a href="javascript: void(0);">Contact Us</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- end Footer -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->


        <!-- Right Sidebar -->

        {{-- <div class="rightbar-overlay"></div> --}}
        <!-- /End-bar -->


        <!-- bundle -->
        <script src="{{ asset('assets/js/vendor.min.js')}}"></script>
        <script src="{{ asset('assets/js/app.min.js')}}"></script>
        <script src="{{ asset('https://cdn.jsdelivr.net/npm/toastify-js')}}"></script>
        <script src="{{ asset('https://cdn.jsdelivr.net/npm/sweetalert2@11.7.20/dist/sweetalert2.all.min.js')}}"></script>

        @yield('script')
        
    </body>
</html>
