<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — PPKD Hotel</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Lora:ital,wght@0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body class="login-body">

<div class="login-bg">
    <div class="login-bg-shape login-bg-shape-1"></div>
    <div class="login-bg-shape login-bg-shape-2"></div>
</div>

<div class="login-wrapper">
    <div class="login-card">

        {{-- Logo --}}
        <div class="login-logo">
            <img src="{{ asset('images/ppkd-logo.jpg') }}" alt="Logo PPKD"
                 onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
            <div class="login-logo-fallback" style="display:none;">
                <i class="fas fa-hotel"></i>
            </div>
        </div>

        <h1 class="login-title">Login Resepsionis</h1>
        <p class="login-subtitle">Silakan login untuk mengakses sistem reservasi<br>Hotel PPKD Jakarta Pusat</p>

        {{-- Error Alert --}}
        @if($errors->any())
        <div class="login-alert">
            <i class="fas fa-exclamation-circle"></i>
            <span>{{ $errors->first('email') }}</span>
        </div>
        @endif

        @if(session('error'))
        <div class="login-alert">
            <i class="fas fa-exclamation-circle"></i>
            <span>{{ session('error') }}</span>
        </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('login.post') }}" method="POST" class="login-form">
            @csrf

            <div class="login-field">
                <label class="login-label">
                    <i class="fas fa-envelope"></i> Alamat Email
                </label>
                <input type="email" name="email" class="login-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
                    placeholder="nama@email.com" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="login-field">
                <label class="login-label">
                    <i class="fas fa-lock"></i> Password
                </label>
                <div class="login-input-wrap">
                    <input type="password" name="password" id="passwordInput"
                        class="login-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
                        placeholder="••••••••" required>
                    <button type="button" class="login-eye" onclick="togglePassword()">
                        <i class="fas fa-eye" id="eyeIcon"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="login-btn">
                <i class="fas fa-sign-in-alt"></i> Login
            </button>
        </form>
<!-- 
        <div class="login-hint">
            <i class="fas fa-info-circle"></i>
            Default: <strong>admin@ppkdhotel.com</strong> / <strong>admin123</strong>
        </div> -->

    </div>
</div>

<div class="login-footer">
    &copy; {{ date('Y') }} PPKD Hotel Jakarta Pusat. All rights reserved.
</div>

<script>
function togglePassword() {
    const input = document.getElementById('passwordInput');
    const icon  = document.getElementById('eyeIcon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'fas fa-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'fas fa-eye';
    }
}
</script>
</body>
</html>
