<header class="navbar navbar-expand navbar-light bg-white shadow-sm">
    <div class="container-fluid">
        <!-- Logo -->
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <img src="https://via.placeholder.com/40" alt="Logo" width="40" height="40" class="rounded-circle">
            Kafe Yönetim Paneli
        </a>

        <!-- Sağ Taraf -->
        <div class="d-flex align-items-center">
            <span class="me-3 text-muted">Hoş geldin, {{ Auth::user()->name }}</span>
            <img src="{{ Auth::user()->avatar ? asset('storage/avatars/' . Auth::user()->avatar) : asset('images/default-avatar.png') }}" 
            alt="Avatar" class="rounded-circle" width="40" height="40">
               </div>
    </div>
</header>