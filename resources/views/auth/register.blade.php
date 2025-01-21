@extends('layout.Autheme')
@section('title', 'Create Your DoListify Account')

@section('content')
    <div id="registerForm" class="space-y-6 w-10/12">
        <div>
            <h2 class="text-center text-3xl text-large text-cyan-800">Create Account</h2>
            <p class="text-center mt-2 text-medium text-gray-400">Please fill in your details</p>
        </div>
        <form id="registrationForm" action="{{ route('auth.register') }}" method="POST" class="space-y-4">
            @csrf
            <!-- First Name and Last Name -->
            <div class="flex space-x-4">
                <div class="w-1/2">
                    <div class="relative">
                        <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" norequired
                            class="shadow-cyan-800/75 @error('first_name') border-t border-l border-r border-red-500 @enderror appearance-none block w-full px-3 py-2 border-0 rounded-md shadow-md placeholder:text-medium placeholder:text-slate-400 hover:shadow-cyan-500 focus:outline-none focus:border-b-0 focus:shadow-cyan-500 transition-all ease-in-out delay-75"
                            placeholder="First Name">
                        @error('first_name')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="w-1/2">
                    <div class="relative">
                        <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" noreqiured
                            class="shadow-cyan-800/75 @error('last_name') border-t border-l border-r border-red-500 @enderror appearance-none block w-full px-3 py-2 border-0 rounded-md shadow-md placeholder:text-medium placeholder:text-slate-400 hover:shadow-cyan-500 focus:outline-none focus:border-b-0 focus:shadow-cyan-500 transition-all ease-in-out delay-75"
                            placeholder="Last Name">
                        @error('last_name')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <!-- Email -->
            <div class="form-group">
                <div class="relative">
                    <input type="email" id="email" name="email" value="{{ old('email') }}" norequired
                        class="shadow-cyan-800/75 @error('email') border-t border-l border-r border-red-500 @enderror appearance-none block w-full px-3 py-2 border-0 rounded-md shadow-md placeholder:text-medium placeholder:text-slate-400 hover:shadow-cyan-500 focus:outline-none focus:border-b-0 focus:shadow-cyan-500 transition-all ease-in-out delay-75"
                        placeholder="Email">
                    @error('email')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <!-- Password -->
            <div class="form-group">
                <div class="relative">
                    <input type="password" id="reg_password" name="password" required
                        class="shadow-cyan-800/75 @error('password') border-t border-l border-r border-red-500 @enderror appearance-none block w-full px-3 py-2 border-0 rounded-md shadow-md placeholder:text-medium placeholder:text-slate-400 hover:shadow-cyan-500 focus:outline-none focus:border-b-0 focus:shadow-cyan-500 transition-all ease-in-out delay-75"
                        placeholder="Password" oninput="checkPasswordStrength()">
                    <span class="absolute inset-y-0 right-0 pr-3 p-3 flex cursor-pointer" id="eyeIcon"
                        style="display: none;" onclick="togglePassword()">
                        <i class="fa-regular fa-eye-slash text-cyan-800" id="eyeIconClass"></i>
                    </span>
                    <div id="passwordStrengthBar" class="w-full h-1 mt-2 bg-gray-200 rounded-full">
                        <div id="passwordStrengthIndicator" class="h-full rounded-full"></div>
                    </div>
                    @error('password')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <!-- Confirm Password -->
            <div class="form-group">
                <div class="relative">
                    <input type="password" id="password_confirmation" name="password_confirmation" norequired
                        class="shadow-cyan-800/75 appearance-none block w-full px-3 py-2 border-0 rounded-md shadow-md placeholder:text-medium placeholder:text-slate-400 hover:shadow-cyan-500 focus:outline-none focus:border-b-0 focus:shadow-cyan-500 transition-all ease-in-out delay-75"
                        placeholder="Confirm password">
                </div>
            </div>
            <!-- Submit Button -->
            <div>
                <button type="submit"
                    class="mt-6  w-full flex text-large text-[16px] justify-center py-3 lg:py-3 xl:py-4 px-4 border shadow-cyan-800 border-transparent rounded-md shadow-md text-white bg-cyan-900 hover:bg-cyan-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-800/75 ">
                    Register
                </button>
            </div>
        </form>
        <div class="text-center space-y-2" style="margin-buttom:100px;">
            <a id="backtoLogin" class="w-full mt-4 text-large text-base text-cyan-600 hover:text-cyan-500 cursor-pointer">
                Back to Login
            </a>
        </div>
    </div>
    @include('modal.reusableModal')

    <script src="/storage/js/backtoLogin.js"></script>
    <script src="/storage/js/gmailVerify.js"></script>
    <script src="/storage/js/preventBack.js"></script>
    <script src="/storage/js/passStrength.js"></script>
@endsection
