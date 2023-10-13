@extends('layouts.app')

@section('content')
<div class="auth-wrap flex flex-col items-center justify-center bg-gray-100">
    <div class="flex flex-col bg-white shadow-md px-4 sm:px-6 md:px-8 lg:px-10 py-8 rounded-3xl w-50 max-w-md">
        <div class="font-medium self-center text-xl sm:text-3xl text-gray-800">
            {{ __('Register') }}
        </div>
        <div class="mt-4 self-center text-xl sm:text-sm text-gray-800">
            Enter your credentials to get access account
        </div>

        <div class="mt-10">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="flex flex-col mb-5">
                    <label for="name" class="mb-1 text-xs tracking-wide text-gray-600">
                        {{ __('Name') }}
                    </label>
                    <div class="relative">
                        <div
                            class="inline-flex items-center justify-center absolute left-0 top-0 h-full w-10 text-gray-400">
                            <i class="ri-user-line text-blue-500"></i>
                        </div>

                        <input
                            required id="name" type="text" name="name" placeholder="{{ __('Name') }}"
                            class="text-sm placeholder-gray-500 pl-10 pr-4 rounded-2xl border border-gray-400 w-full py-2 focus:outline-none focus:border-blue-400 @error('name') is-invalid @enderror"
                        />
                        @error('name')<span role="alert">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="flex flex-col mb-5">
                    <label for="email" class="mb-1 text-xs tracking-wide text-gray-600">
                        {{ __('Email Address') }}
                    </label>
                    <div class="relative">
                        <div
                            class="inline-flex items-center justify-center absolute left-0 top-0 h-full w-10 text-gray-400">
                            <i class="ri-mail-line text-blue-500"></i>
                        </div>

                        <input
                            id="email" type="text" name="email" required placeholder="{{ __('Email Address') }}"
                            class="text-sm placeholder-gray-500 pl-10 pr-4 rounded-2xl border border-gray-400 w-full py-2 focus:outline-none focus:border-blue-400 @error('email') is-invalid @enderror"
                        />

                        @error('email')<span role="alert">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="flex flex-col mb-5">
                    <label for="password" class="mb-1 text-xs tracking-wide text-gray-600">
                        {{ __('Password') }}
                    </label>
                    <div class="relative">
                        <div
                            class="inline-flex items-center justify-center absolute left-0 top-0 h-full w-10 text-gray-400">
                            <span><i class="ri-git-repository-private-line text-blue-500"></i></span>
                        </div>

                        <input
                            id="password" autocomplete="new-password" type="password" name="password" required
                            class="text-sm placeholder-gray-500 pl-10 pr-4 rounded-2xl border border-gray-400 w-full py-2 focus:outline-none focus:border-blue-400 @error('password') is-invalid @enderror"
                            placeholder="{{ __('Password') }}"
                        />
                        @error('password')<span role="alert">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="flex flex-col mb-5">
                    <label for="password-confirm" class="mb-1 text-xs tracking-wide text-gray-600">
                        {{ __('Confirm Password') }}
                    </label>
                    <div class="relative">
                        <div
                            class="inline-flex items-center justify-center absolute left-0 top-0 h-full w-10 text-gray-400">
                            <span><i class="ri-git-repository-private-line text-blue-500"></i></span>
                        </div>

                        <input
                            id="password-confirm"
                            type="password"
                            name="password_confirmation"
                            required
                            class="text-sm placeholder-gray-500 pl-10 pr-4 rounded-2xl border border-gray-400 w-full py-2 focus:outline-none focus:border-blue-400 @error('password-confirm') is-invalid @enderror"
                            placeholder="{{ __('Confirm Password') }}"
                        />
                    </div>
                </div>

                <div class="flex w-full">
                    <button
                        type="submit"
                        class="flex mt-2 items-center justify-center focus:outline-none text-white text-sm sm:text-base bg-blue-500 hover:bg-blue-600 rounded-2xl py-2 w-full transition duration-150 ease-in"
                    >
                        <span class="mr-2 uppercase">{{ __('Register') }}</span>
                        <span>
                            <svg
                                class="h-6 w-6"
                                fill="none"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="flex justify-center items-center mt-6">
        <a
            href="#"
            target="_blank"
            class="inline-flex items-center text-gray-700 font-medium text-xs text-center"
        >
            <span class="ml-2">
                You have an account?
                <a href="{{ route('login') }}" class="text-xs ml-2 text-blue-500 font-semibold">Login here</a>
            </span>
        </a>
    </div>
</div>

@endsection
