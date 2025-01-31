<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kafe Yönetim Paneli</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 48px 0 0;
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
        }
        .content {
            margin-left: 200px;
            padding: 20px;
        }
        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }
            .content {
                margin-left: 0;
            }
        }
    </style>
       @yield('styles')
</head>
<body>
    <!-- Header -->
    @include('userdashboard.template.header')

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            @include('userdashboard.template.sidebar')

            <!-- Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 content">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Footer -->
    @include('userdashboard.template.footer')
    @yield('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    text: '{{ session('success') }}',
                    confirmButtonText: 'Tamam'
                });
            @endif
    
            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Hata!',
                    text: '{{ session('error') }}',
                    confirmButtonText: 'Tamam'
                });
            @endif
            @if(session('message'))
                Swal.fire({
                    icon: 'error',
                    title: 'Hata!',
                    text: '{{ session('message') }}',
                    confirmButtonText: 'Tamam'
                });
            @endif
            @if($errors->any())
                let errorMessages = {!! json_encode($errors->all()) !!};
                let errorText = errorMessages.join("\n");
    
                Swal.fire({
                    icon: 'error',
                    title: 'Hata!',
                    text: errorText,
                    confirmButtonText: 'Tamam'
                });
            @endif
        });
    </script>
    

</body>
</html>