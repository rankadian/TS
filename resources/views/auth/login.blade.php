@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@section('auth_header', 'Sign in to start your session')

@section('auth_body')
    <form action="{{ route('login') }}" method="POST">
        @csrf

        {{-- Email --}}
        <div class="input-group mb-3">
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}" placeholder="Email" required autofocus>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
            @error('email')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Password --}}
        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                placeholder="Password" required>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
            @error('password')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Remember Me --}}
        <div class="row">
            <div class="col-8">
                <div class="icheck-primary">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember">
                        Remember Me
                    </label>
                </div>
            </div>

            <div class="col-4">
                <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
        </div>
    </form>
@endsection

@section('auth_footer')
    @if (Route::has('password.request'))
        <p class="my-0">
            <a href="{{ route('password.request') }}">I forgot my password</a>
        </p>
    @endif
    <p class="my-0">
        <a href="{{ route('register') }}" class="text-center">Register a new membership</a>
    </p>
@endsection
