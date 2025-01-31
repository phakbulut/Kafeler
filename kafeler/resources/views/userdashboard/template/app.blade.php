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
.custom-checkbox {
    width: 1.2em;
    height: 1.2em;
    margin-top: 0.25em;
    vertical-align: top;
    background-color: #fff;
    background-repeat: no-repeat;
    background-position: center;
    background-size: contain;
    border: 2px solid #dee2e6;
    border-radius: 0.35em;
    appearance: none;
    cursor: pointer;
    transition: all 0.2s ease;
}

.custom-checkbox:checked {
    background-color: #0d6efd;
    border-color: #0d6efd;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3e%3cpath fill='none' stroke='%23fff' stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='M6 10l3 3l6-6'/%3e%3c/svg%3e");
}

.custom-checkbox:hover:not(:checked) {
    border-color: #86b7fe;
    box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.25);
}

.custom-checkbox:focus {
    box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.25);
    outline: 0;
}

.form-check {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 40px; 
}

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
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    text: '{{ session('success') }}',
                    confirmButtonText: 'Tamam'
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Hata!',
                    text: '{{ session('error') }}',
                    confirmButtonText: 'Tamam'
                });
            @endif
            @if (session('message'))
                Swal.fire({
                    icon: 'error',
                    title: 'Hata!',
                    text: '{{ session('message') }}',
                    confirmButtonText: 'Tamam'
                });
            @endif
            @if ($errors->any())
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
