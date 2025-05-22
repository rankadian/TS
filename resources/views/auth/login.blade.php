@extends('adminlte::master')

@section('adminlte_css')
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-box {
            width: 400px;
            margin: 0 auto;
        }

        .login-card-body {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 3rem 2.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: none;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo-circle {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #4285f4 0%, #34a853 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            box-shadow: 0 4px 15px rgba(66, 133, 244, 0.3);
            transition: all 0.3s ease;
        }

        .logo-circle:hover {
            transform: scale(1.05);
        }

        .logo-circle .fas {
            color: white;
            font-size: 2rem;
        }

        .login-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .login-subtitle {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            color: #6c757d;
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .form-control {
            border: 1px solid #e1e5e9;
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .form-control::placeholder {
            color: #adb5bd;
        }

        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 8px;
            color: white;
            padding: 12px;
            font-weight: 500;
            width: 100%;
            transition: all 0.3s ease;
            margin-bottom: 1rem;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .forgot-link {
            color: #667eea;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .forgot-link:hover {
            color: #764ba2;
            text-decoration: none;
        }

        .footer-text {
            text-align: center;
            margin-top: 2rem;
            color: #6c757d;
        }

        .footer-text strong {
            color: #333;
        }

        .copyright {
            color: #adb5bd;
            font-size: 0.8rem;
            margin-top: 0.5rem;
        }

        .input-group {
            margin-bottom: 1.5rem;
        }

        .input-group .form-control {
            border-right: none;
        }

        .input-group-text {
            background: white;
            border-left: none;
            border-color: #e1e5e9;
            color: #6c757d;
        }

        .invalid-feedback {
            display: block;
            color: #dc3545;
            font-size: 0.8rem;
            margin-top: 0.25rem;
        }
    </style>
@endsection

@section('body')
    <div class="login-page">
        <div class="login-box">
            <div class="card login-card-body">
                <!-- Logo Section -->
                <div class="logo-container">
                    <div class="logo-circle">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h4 class="login-title">Sign In</h4>
                    <p class="login-subtitle">Tracer Study Information System Malang State Polytechnic - TSPM</p>
                </div>

                <!-- Login Form -->
                <form action="{{ route('login') }}" method="POST">
                    @csrf

                    {{-- Username/Email Field --}}
                    <div class="form-group">
                        <label class="form-label">Username/Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}" placeholder="Username/Email" required autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    {{-- Password Field --}}
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                            placeholder="Password" required>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    {{-- Login Button --}}
                    <button type="submit" class="btn btn-login">
                        <i class="fas fa-sign-in-alt me-2"></i>Login
                    </button>

                    {{-- Forgot Password Link --}}
                    <div class="text-center">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-link">
                                Batal
                            </a>
                        @endif
                    </div>

                    {{-- Hidden Remember Me --}}
                    <input type="hidden" name="remember" value="1">
                </form>
            </div>

            <!-- Footer Text -->
            <div class="footer-text">
                <p class="mb-1">
                    <strong>TSPM</strong> - Tracer Study of Malang State Polytechnic.
                </p>
                <p class="copyright mb-0">
                    Copyright 2025
                </p>
            </div>
        </div>
    </div>
@endsection