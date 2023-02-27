{{-- <x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                    autofocus />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Email Password Reset Link') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout> --}}

@extends('layout.guest')

@section('content')
    <div class="d-flex flex-center flex-column flex-column-fluid p-4 pb-lg-8">

        <a href="/" class="mb-12">
            <img alt="Logo" src="{{ asset('assets/media/logos/logo-pdp.jpeg') }}" class="h-40px" />
        </a>

        <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
            <form class="form w-100" method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="mb-10">
                    <h1 class="text-center text-dark mb-6">Lupa Password</h1>
                    <!-- Session Status -->
                    <x-auth-session-status :status="session('status')" />

                    <!-- Validation Errors -->
                    <x-auth-validation-errors :errors="$errors" />

                </div>
                <div class="fv-row mb-10">
                    <label class="form-label fs-6 fw-bolder text-dark">Email</label>
                    <input class="form-control form-control-lg form-control" type="email" name="email"
                        :value="old('email')" required autofocus />
                </div>
                <div class="text-center">
                    <button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
                        <span class="indicator-label">Berikutnya</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
