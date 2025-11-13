@extends('layouts.front')

@section('title')

@section('content')
<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div class="d-flex justify-content-center mb-4">
        <img src="{{ asset('image/logodalang.png') }}" alt="DALANG Logo" style="height: 3rem;" />
    </div>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

<!-- Footer -->
<footer style="background-color: #299E63; color: white; padding: 40px 20px; text-align: center; font-family: 'Arial', sans-serif; margin-top: 60px;" 
    data-aos="fade-up" data-aos-duration="1000">
    <div style="max-width: 1100px; margin: 0 auto;">
        <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 30px;" 
            data-aos="fade-up" data-aos-delay="200">
            <div style="flex: 1; min-width: 250px; text-align: left;">
                <h3 style="font-size: 22px; font-weight: bold; margin-bottom: 10px;">Bank Sampah Induk Kota Bandung</h3>
                <p style="font-size: 16px;">Menginspirasi masyarakat Bandung untuk hidup lebih hijau melalui daur ulang dan pemanfaatan limbah.</p>
            </div>
            <div style="flex: 1; min-width: 200px;">
                <h4 style="font-size: 18px; font-weight: bold;">Hubungi Kami</h4>
                <p style="font-size: 16px; margin-top: 10px;">
                    Jl. Cicukang No.60, Bandung<br>
                    Telp: (022) 1234567<br>
                    Email: info@banksampahbdg.com
                </p>
            </div>
        </div>
        <hr style="margin: 30px 0; border-color: rgba(255, 255, 255, 0.3);" data-aos="fade-up" data-aos-delay="300">
        <p style="font-size: 14px;">&copy; {{ date('Y') }} Bank Sampah Induk Kota Bandung. All rights reserved.</p>
    </div>
</footer>
@endsection
