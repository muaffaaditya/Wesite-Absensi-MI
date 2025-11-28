@extends('layouts.app')

@section('title', 'Login | MI-Al Ihsan')

@section('footer-class', 'fixed-bottom')

@section('content')
<div class="min-h-screen d-flex align-items-center justify-content-center p-4">

    <div class="card shadow-lg border-0 rounded-3" style="width: 100%; max-width: 420px;">
        <div class="card-body p-5">
            <div class="text-center mb-4">
                <h3 class="card-title fw-bold">Login Akun</h3>
                <p class="text-muted">Gunakan NUPTK dan password Anda.</p>
            </div>
            
            <form action="{{ route('login') }}" method="POST" id="loginForm">
                @csrf
                
                {{-- Input NUPTK --}}
                <div class="mb-3">
                    <label for="identity_number" class="form-label">NUPTK</label>
                    <input type="text" 
                           class="form-control @error('identity_number') is-invalid @enderror" 
                           id="identity_number" 
                           name="identity_number" 
                           required autofocus>
                    @error('identity_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Input Password dengan icon di dalam field --}}
                <div class="mb-3 position-relative">
                    <label for="password" class="form-label">Password</label>
                    <div class="position-relative">
                        <input type="password" 
                               class="form-control pe-5 @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password" 
                               required>
                        <i class="fas fa-eye position-absolute top-50 end-0 translate-middle-y me-3 text-muted" 
                           id="togglePassword" 
                           style="cursor: pointer;"></i>
                    </div>
                    @error('password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Opsi Ingat Saya --}}
                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label text-muted" for="remember">
                        Ingat Saya
                    </label>
                </div>

                {{-- Tombol Login --}}
                <div class="d-grid">
                    <button type="submit" 
                            class="btn btn-dark fw-bold shadow-sm text-uppercase tracking-wider">
                        <i class="fas fa-sign-in-alt me-2"></i>
                        Login
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Script Toggle Password --}}
<script>
document.getElementById('togglePassword').addEventListener('click', function () {
    const passwordInput = document.getElementById('password');
    const toggleIcon = this;
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.replace('fa-eye', 'fa-eye-slash');
        toggleIcon.classList.add('text-dark');
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.replace('fa-eye-slash', 'fa-eye');
        toggleIcon.classList.remove('text-dark');
    }
});
</script>

{{-- Script Ingat Saya (localStorage) --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('loginForm');
    const remember = document.getElementById('remember');
    const nuptk = document.getElementById('identity_number');
    const password = document.getElementById('password');

    // Isi otomatis jika ada data tersimpan
    if (localStorage.getItem('rememberMe') === 'true') {
        nuptk.value = localStorage.getItem('savedNuptk') || '';
        password.value = localStorage.getItem('savedPassword') || '';
        remember.checked = true;
    }

    // Simpan data saat login
    form.addEventListener('submit', function() {
        if (remember.checked) {
            localStorage.setItem('rememberMe', 'true');
            localStorage.setItem('savedNuptk', nuptk.value);
            localStorage.setItem('savedPassword', password.value);
        } else {
            localStorage.removeItem('rememberMe');
            localStorage.removeItem('savedNuptk');
            localStorage.removeItem('savedPassword');
        }
    });
});
</script>

{{-- Styling tambahan --}}
<style>
    input.form-control {
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
        transition: all 0.2s ease;
    }
    input.form-control:focus {
        border-color: #adb5bd !important;
        box-shadow: none !important;
        outline: none !important;
    }
    .form-control.pe-5 {
        padding-right: 2.5rem !important;
    }
    .btn-dark {
        transition: all 0.3s ease;
    }
    .btn-dark:hover {
        background-color: #343a40;
        transform: scale(1.02);
    }
</style>
@endsection
