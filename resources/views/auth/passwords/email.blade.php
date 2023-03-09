@extends('layouts.app')

@section('content')
    <div class="d-flex flex-center flex-column flex-lg-row-fluid">
        <!--begin::Wrapper-->
        <div class="w-lg-500px p-10">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <!--begin::Form-->
            <form class="form w-100" method="POST" action="{{ route('password.email') }}" id="kt_sign_in_form">
                @csrf
                <!--begin::Heading-->
                <div class="text-center mb-11">
                    <h1 class="text-dark fw-bolder mb-3">{{ __('Reset Password') }}</h1>
                </div>

                <div class="separator separator-content my-14">
                    <span class="w-125px text-gray-500 fw-semibold fs-7"></span>
                </div>
                <div class="fv-row mb-8">
                   
                    <input type="text" placeholder="Email" name="email" autocomplete="off"
                        class="form-control bg-transparent @error('email') is-invalid @enderror" value="{{ old('email') }}"
                        required autofocus />
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="d-grid mb-10">
                    <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                        <!--begin::Indicator label-->
                        <span class="indicator-label">   {{ __('Send Password Reset Link') }} </span>
                        <!--end::Indicator label-->
                        <!--begin::Indicator progress-->
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        <!--end::Indicator progress-->
                    </button>
                </div>

            </form>
            <a class="navbar-brand" href="{{ url('/') }}">
                Back to Login
            </a>
            <!--end::Form-->
        </div>
        <!--end::Wrapper-->
    </div>
@endsection
