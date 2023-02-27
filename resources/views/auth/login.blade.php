@extends('layout.guest')

@section('content')
    <div class="d-flex flex-center flex-column flex-column-fluid p-4 pb-lg-8">

        <a href="/" class="mb-12">
            <img alt="Logo" src="{{ asset('assets/media/logos/logo-pdp.jpeg') }}" class="h-40px" />
        </a>

        <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
            <form class="form w-100" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="text-center mb-10">
                    <h1 class="text-dark mb-3">Login</h1>
                </div>
                <!-- Session Status -->
                <x-auth-session-status :status="session('status')" />

                <!-- Validation Errors -->
                {{-- <x-auth-validation-errors :errors="$errors" /> --}}

                <div class="fv-row mb-10">
                    <label class="form-label fs-6 fw-bolder text-dark">Email</label>
                    <input id="email" class="form-control form-control-lg @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" placeholder="Masukan Alamat Email" autocomplete="email"
                        autofocus />
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="fv-row mb-10">
                    <div class="d-flex flex-stack mb-2">
                        <label class="form-label fw-bolder text-dark fs-6 mb-0">Password</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="link-primary fs-6 fw-bolder">
                                Lupa Password ?
                            </a>
                        @endif
                    </div>
                    <input id="password" class="form-control form-control-lg @error('password') is-invalid @enderror"
                        type="password" name="password" value="{{ old('password') }}" placeholder="Masukan Password"
                        autocomplete="current-password" />
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="text-center">
                    <button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
                        <span class="indicator-label">Masuk</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
