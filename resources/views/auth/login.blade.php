@extends('layout.Autheme')
@section('title', 'Login Your DoListify Account')

@section('content')
    <div id="loginForm" class="space-y-4 w-10/12">
        <div>
            <h1 class="text-center text-3xl text-large text-cyan-800">Welcome to DoListify</h1>
            <p class="text-center  mt-1.5 text-medium text-base text-gray-400 ">Please enter your details.</p>
        </div>
        <form method="POST" action="{{ route('auth.login.post') }}" class="space-y-5">
            @csrf
            <div class="mt-4 space-y-4">
                <div>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="mt-1 shadow-cyan-800/75  @error('email') border-t border-l border-r border-red-500 @enderror appearance-none block w-full px-3 py-2 border-0 rounded-md shadow-md placeholder:text-medium placeholder:text-slate-400 hover:shadow-cyan-500 focus:outline-none focus:border-b-0 focus:shadow-cyan-500 transition-all ease-in-out delay-75"
                        placeholder="Email">
                    @error('email')
                        <p class="text-red-500 text-[12px] text-medium mt-1">{{ $message }}</p>
                    @enderror
                    @if ($errors->has('credentials'))
                        <p class="text-red-500 text-[12px] text-medium mt-1">{{ $errors->first('credentials') }}</p>
                    @endif
                </div>
                <div>
                    <div class="relative">
                        <input type="password" name="password" id="password"
                            class="shadow-cyan-800/75 @error('password') border-t border-l border-r border-red-500 @enderror appearance-none block w-full px-3 py-2 border-0 rounded-md shadow-md placeholder:text-medium placeholder:text-slate-400 hover:shadow-cyan-500 focus:outline-none focus:border-b-0 focus:shadow-cyan-500 transition-all ease-in-out delay-75"
                            placeholder="Password" oninput="toggleEyeIcon()">
                        <span class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer" id="eyeIcon"
                            style="display: none;" onclick="togglePassword()">
                            <i class="fa-regular fa-eye-slash text-cyan-800" id="eyeIconClass"></i>
                            <!-- Initial class set to fa-eye-slash -->
                        </span>
                        @error('password')
                            <p class="text-red-500 text-xs text-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="text-sm">
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="terms_accepted" id="termsAccepted"
                        class="@error('terms_accepted') border-t border-l border-r border-red-500 @enderror h-3 w-3 text-cyan-600 focus:ring-cyan-500 border rounded" />
                    <span class="text-gray-600 text-[12px] text-medium">I Accept the <a onclick="OpenTermsCon()"
                            class="text-gray-600 text-[12px] text-medium hover:text-cyan-500 underline cursor-pointer">Terms
                            &
                            Conditions</a></span>
                </div>
                @error('terms_accepted')
                    <span class="text-red-500 text-[12px] text-medium" data-error="terms_accepted">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <button type="submit"
                    class="w-full flex text-large text-[16px] justify-center py-3 lg:py-3 xl:py-4 px-4 border shadow-cyan-800 border-transparent rounded-md shadow-md text-white bg-cyan-900 hover:bg-cyan-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-800/75">
                    Log In
                </button>
                <div class="">
                    <a href="{{ route('forgot.password') }}"
                        class="text-gray-600 text-[12px] text-medium hover:text-cyan-500 underline">
                        Forgot Password?
                    </a>
                </div>
            </div>
        </form>
        <div class="text-center">
            <span class="text-gray-600 text-sm text-medium">Don't have and account? </span> <a
                href="{{ route('register') }}"
                class="text-cyan-800 text-large underline hover:text-cyan-500 cursor-pointer text-sm">Sign
                up for free</a>
        </div>
    </div>
    <script src="/storage/js/gmailVerify.js"></script>
    <script>
        function OpenTermsCon() {
            document.getElementById('openTermsConModal').style.display = 'flex';
        }

        function hideTermsCon() {
            document.getElementById('openTermsConModal').style.display = 'none';
        }

        function acceptTermsCon() {
            document.getElementById('openTermsConModal').style.display = 'none'
            document.querySelector('input[name="terms_accepted"]').checked = true;
        }
        // Toggle the visibility of the password
        function togglePassword() {
            var passwordField = document.getElementById('password');
            var eyeIconClass = document.getElementById('eyeIconClass');
            if (passwordField.type === 'password') {
                passwordField.type = 'text'; // Show the password
                eyeIconClass.classList.remove('fa-eye-slash');
                eyeIconClass.classList.add('fa-eye'); // Change to open eye icon
            } else {
                passwordField.type = 'password'; // Hide the password
                eyeIconClass.classList.remove('fa-eye');
                eyeIconClass.classList.add('fa-eye-slash'); // Change to closed eye icon
            }
        }

        // Show the eye icon when the user starts typing
        function toggleEyeIcon() {
            var passwordField = document.getElementById('password');
            var eyeIcon = document.getElementById('eyeIcon');
            if (passwordField.value.length > 0) {
                eyeIcon.style.display = 'flex'; // Show the eye icon
            } else {
                eyeIcon.style.display = 'none'; // Hide the eye icon when password is empty
            }
        }
    </script>
@endsection
