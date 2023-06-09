@extends('layouts.app')

@section('content')
    <div class="d-flex flex-center flex-column flex-lg-row-fluid">
        <!--begin::Wrapper-->
        <div class="col-md-8 p-10">
            <!--begin::Form-->
            <form class="form w-100" method="POST" action="{{ route('login') }}" id="kt_sign_in_form">
                @csrf
                <!--begin::Heading-->
                <div class="text-center mb-11">
                    <h1 class="text-dark fw-bolder mb-3">Sign In</h1>
                </div>
                <!--end::Separator-->
                <!--begin::Input group=-->
                <div class="fv-row mb-8">
                    <input type="text" placeholder="Your Employee Code" name="email" autocomplete="off"  class="form-control form-control-lg bg-transparent @error('email') is-invalid @enderror" value="{{ old('email') }}"
                        required autofocus />
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <!--end::Input group=-->
                <div class="fv-row">
                    <!--begin::Password-->
                    {{-- <input type="password" placeholder="Password" name="password" autocomplete="off"
                                            class="form-control form-control-lg bg-transparent" /> --}}
                    <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror"
                        name="password" required autocomplete="current-password" placeholder="Your Employee Password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <!--end::Password-->
                </div>

                @if (Route::has('password.request'))
                    <a class="btn btn-link text-end my-2 d-block" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif

                <div class="d-grid mb-10">
                    <button type="submit" class="btn btn-success">
                      Sign In
                    </button>
                </div>

            </form>
            <!--end::Form-->
        </div>
        <!--end::Wrapper-->
    </div>
@endsection
