@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@section('adminlte_css_pre')
    <link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@stop

@php( $login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login') )

@if (config('adminlte.use_route_url', false))
    @php( $login_url = $login_url ? route($login_url) : '' )
@else
    @php( $login_url = $login_url ? url($login_url) : '' )
@endif

@section('auth_header', '') {{-- We handle header in CSS/Before content --}}

@section('auth_body')
    {{-- Internal Logo --}}
    <div class="text-center mb-4">
        <img src="{{ asset('imagenes/logo-black.png') }}" alt="GIGI FASHION" style="height: 80px; width: auto; object-fit: contain;">
    </div>

    <form action="{{ $login_url }}" method="post">
        @csrf

        {{-- Email field --}}
        <div class="input-group mb-3">
            <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                   value="{{ old('email') }}" placeholder="{{ __('adminlte::adminlte.email') }}" autofocus>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
        </div>

        {{-- Password field --}}
        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                   placeholder="{{ __('adminlte::adminlte.password') }}">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
        </div>

        {{-- Remember Me --}}
        <div class="mb-3">
            <div class="icheck-primary">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">{{ __('adminlte::adminlte.remember_me') }}</label>
            </div>
        </div>

        {{-- Login Button --}}
        <div class="mb-3">
            <button type=submit class="btn btn-block btn-primary custom-btn-login">
               <i class="fas fa-sign-in-alt mr-2"></i> {{ __('adminlte::adminlte.sign_in') }}
            </button>
        </div>

        {{-- CONSOLIDATED ERROR MESSAGES AT THE BOTTOM --}}
        @if($errors->any())
            <div class="text-center mt-3">
                @foreach($errors->all() as $error)
                    <p class="text-danger font-weight-bold mb-1" style="font-size: 0.9rem;">
                        <i class="fas fa-exclamation-circle mr-1"></i> {{ $error }}
                    </p>
                @endforeach
            </div>
        @endif

    </form>
@stop

@section('auth_footer')
    {{-- Optionally add footer links here if needed later --}}
@stop

@section('adminlte_css')
<style>
    body {
        background-image: url(/imagenes/imagen1.jpg);
        background-position: center;
        background-attachment: fixed;
        background-size: cover;
        background-repeat: no-repeat;
    }

    .login-logo {
        display: none !important;
    }

    /* Card Styling */
    .login-card-body, .card {
        border-radius: 20px !important;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important;
        border: none !important;
    }
    .login-card-body {
        padding: 3rem 2.5rem !important;
    }

    /* Title "Iniciar Sesión" */
    .card-header { border: none !important; background: transparent !important; padding-top: 2rem !important;}
    .card-header .card-title {
        display: block !important;
        width: 100% !important;
        text-align: center !important;
        float: none !important;
        font-size: 1.6rem !important;
        font-weight: 800 !important;
        color: #000 !important;
        font-family: 'Inter', system-ui, sans-serif !important;
        letter-spacing: -0.5px !important;
    }

    /* Input Groups */
    .input-group {
        border: 1px solid #E2E8F0 !important;
        border-radius: 50px !important;
        background: #F8FAFC !important;
        overflow: hidden;
    }
    .input-group .form-control {
        border: none !important;
        background: transparent !important;
        box-shadow: none !important;
        padding-left: 1.5rem !important;
        height: 50px !important;
    }
    .input-group-append, .input-group-text {
        background: transparent !important;
        border: none !important;
        color: #94A3B8 !important;
    }
    .input-group-text {
        padding-right: 1.5rem !important;
    }

    /* Validation State - Prevent breaking the pill shape */
    .form-control.is-invalid {
        background-image: none !important;
        padding-right: 1.5rem !important;
    }

    /* Checkbox */
    .icheck-primary {
        margin-left: 0.5rem !important;
    }
    .icheck-primary label {
        font-weight: 500 !important;
        color: #475569 !important;
    }

    /* Button */
    .custom-btn-login {
        border-radius: 50px !important;
        font-weight: 600 !important;
        padding: 0.8rem 0 !important;
        background-color: #7D266E !important; /* The purple from the shop theme */
        border-color: #7D266E !important;
        transition: all 0.3s ease;
    }
    .custom-btn-login:hover {
        background-color: #631e58 !important;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(125, 38, 110, 0.3) !important;
    }

</style>
@stop