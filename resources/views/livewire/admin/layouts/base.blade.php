<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? config('app.name', 'Laravel CMS') }}</title>

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/admin/images/favicon.ico') }}">

    <!-- Styles Css -->
    <link href="{{ asset('assets/admin/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/admin/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <link href="{{ asset('assets/admin/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- App Css-->
    <link href="{{ asset('assets/admin/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

    @livewireStyles
</head>
<style>
    .btn-xs {
        font-size: 11.5px;
    }

    .spinner-border-sm {
        width: 14px;
        height: 14px;
        border-width: 1px;
    }

    .spinner-border-xs {
        width: 10px;
        height: 10px;
        border-width: 1px;
    }

    .sinput {
        border: 1px solid #ced4da;
        border-radius: 4px;
        padding: 5px 7px;
        font-size: 12px;
    }

    .sinput:focus {
        border: 1px solid #a5a5a5;
        box-shadow: none;
        outline: none;
    }

    .search_cont {
        text-align: right;
    }

    .sort_cont {
        text-align: left;
    }

    @media screen and (max-width: 768px) {
        .search_cont {
            text-align: center;
        }

        .sort_cont {
            text-align: center;
        }
    }

    .nav_item_active {
        background: #1E2539;
    }

    .table tbody tr td {
        font-weight: normal;
    }

    #customSwitchSuccess {
        font-size: 15px;
    }

    .swal2-modal {
        font-size: 12px;
    }
    .btn:focus,
    .btn:active{
        outline: none !important;
        box-shadow: none;
    }
    .action-btn{
        height: 30px;
        width: 30px;
    }
</style>

<body data-sidebar="dark" data-layout-mode="light">

    <div id="layout-wrapper">

        @livewire('admin.layouts.inc.header')
        @livewire('admin.layouts.inc.sidebar')

        <div class="main-content">

            {{ $slot }}

        </div>

        @livewire('admin.layouts.inc.footer')
    </div>

    @livewire('admin.partials.profile-component')

    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets/admin/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/node-waves/waves.min.js') }}"></script>

    <!-- apexcharts -->
    <script src="{{ asset('assets/admin/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset('assets/admin/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js"></script>

    <!-- dashboard init -->
    <script src="{{ asset('assets/admin/js/pages/dashboard.init.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('assets/admin/js/app.js') }}"></script>

    <script>
        //Toastr Notification
        $(document).ready(function() {
            toastr.options = {
                "progressBar": true,
                "positionClass": "toast-bottom-left"
            };
        });
        window.addEventListener('success', event => {
            toastr.success(event.detail.message);
        });
        window.addEventListener('warning', event => {
            toastr.warning(event.detail.message);
        });
        window.addEventListener('error', event => {
            toastr.error(event.detail.message);
        });
        @if (Session::has('success'))
            toastr.success("{{ Session::get('success') }}");
        @endif

        //Delete conf.
        window.addEventListener('show_delete_confirmation', event => {
            $('#deleteDataModal').modal('show');
        });
        window.addEventListener('action_btn_click_error', event => {
            $('.delete_btn').html('<i class="bx bx-trash font-size-13 align-middle"></i>');
            $('#deleteDataModal').modal('hide');
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                html: 'Something went wrong! <br> Please try again.'
            });
        });
    </script>

    <script>
        window.addEventListener('reload_scripts', event => {
            $('.delete_btn').on('click', function(event) {
                $(this).html('<span class="spinner-border spinner-border-xs align-middle" role="status" aria-hidden="true"></span>');
            });
            $('.edit_btn').on('click', function(event) {
                $(this).html('<span class="spinner-border spinner-border-xs align-middle" role="status" aria-hidden="true"></span>');
            });
        });
        $(document).ready(function(){
            $('.delete_btn').on('click', function(event) {
                $(this).html('<span class="spinner-border spinner-border-xs align-middle" role="status" aria-hidden="true"></span>');
            });
            $('.edit_btn').on('click', function(event) {
                $(this).html('<span class="spinner-border spinner-border-xs align-middle" role="status" aria-hidden="true"></span>');
            });
        });
    </script>

    @stack('scripts')

    @livewireScripts
</body>

</html>
