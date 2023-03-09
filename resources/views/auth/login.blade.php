@extends('layouts.app')

@section('content')
    <div class="d-flex flex-center flex-column flex-lg-row-fluid">
        <!--begin::Wrapper-->
        <div class="w-lg-500px p-10">
            <!--begin::Form-->
            <form class="form w-100" method="POST" action="{{ route('login') }}" id="kt_sign_in_form">
                @csrf
                <!--begin::Heading-->
                <div class="text-center mb-11">
                    <h1 class="text-dark fw-bolder mb-3">Sign In</h1>
                </div>
                <!--begin::Heading-->
                <!--begin::Separator-->
                <div class="separator separator-content my-14">
                    <span class="w-125px text-gray-500 fw-semibold fs-7"></span>
                </div>
                <!--end::Separator-->
                <!--begin::Input group=-->
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
                <!--end::Input group=-->
                <div class="fv-row mb-3">
                    <!--begin::Password-->
                    {{-- <input type="password" placeholder="Password" name="password" autocomplete="off"
                                            class="form-control bg-transparent" /> --}}
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" required autocomplete="current-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <!--end::Password-->
                </div>
                <!--end::Input group=-->
                <!--begin::Wrapper-->
                <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                    <div></div>
                    <!--begin::Link-->
                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                    {{-- <a href="#" class="link-primary">Forgot Password ?</a> --}}
                    <!--end::Link-->
                </div>
                <!--end::Wrapper-->
                <!--begin::Submit button-->
                <div class="d-grid mb-10">
                    <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                        <!--begin::Indicator label-->
                        <span class="indicator-label">Sign In</span>
                        <!--end::Indicator label-->
                        <!--begin::Indicator progress-->
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        <!--end::Indicator progress-->
                    </button>
                </div>

            </form>
            <!--end::Form-->
        </div>
        <!--end::Wrapper-->
    </div>
@endsection
