@extends('layout.Autheme')

@section('title', 'Forgot Your Password? | DoListify')

@section('content')
    <div id="forgotPasswordForm" class="space-y-6 w-10/12">
        <div>
            <h2 class="text-center text-3xl text-large text-cyan-800">Reset Password</h2>
            <p class="text-center text-medium mt-2 text-gray-400">
                Enter your email address to reset your password.
            </p>
        </div>
        <form id="emailResetpassForm" method="POST" action="{{ route('forgot.password.post') }}" novalidate>
            @csrf
            <div class="form-group mb-6">
                <div class="mt-1 relative">
                    <input id="email" type="email"
                        class="mt-1 shadow-cyan-800/75 @error('email') border-t border-l border-r border-red-500 @enderror appearance-none block w-full px-3 py-2 border-0 rounded-md shadow-md placeholder:text-medium placeholder:text-slate-400 hover:shadow-cyan-500 focus:outline-none focus:border-b-0 focus:shadow-cyan-500 transition-all ease-in-out delay-75"
                        name="email" value="{{ old('email') }}" placeholder="Email">

                    @error('email')
                        <span class="text-red-500 text-xs mt-1">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>
            <button type="submit"
                class="w-full flex justify-center text-large text-[16px] py-3 lg:py-3 xl:py-4 px-4 border shadow-cyan-800 border-transparent rounded-md shadow-md text-white bg-cyan-900 hover:bg-cyan-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-800/75">
                Reset Password
            </button>
        </form>
        <div class="text-center space-y-2" style="margin-buttom:100px;">
            <a id="backtoLogin" class="w-full mt-4 text-large text-base text-cyan-600 hover:text-cyan-500 cursor-pointer">
                Back to Login
            </a>
        </div>
    </div>
@include('modal.reusableModal')
@endsection
<script src="/storage/js/backtoLogin.js" defer></script>
