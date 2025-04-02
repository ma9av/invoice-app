@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="overflow: hidden;">
    <div class="col-lg-6 col-md-8 col-sm-10">
        <div class="card shadow-lg border-0 rounded-lg">
            <div class="card-header text-center  text-black">
                <h4>{{ __('Login') }}</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('Email Address') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success">{{ __('Login') }}</button>
                    </div>
                    
                    <div class="text-center mt-3">
                        @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                    </div>
                    
                    <div class="text-center mt-2">
                        <span>{{ __("Don't have an account?") }}</span>
                        <a href="{{ route('register') }}" class="text-success">{{ __('Register here') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
