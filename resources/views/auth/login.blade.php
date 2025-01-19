@extends('layout.Autheme')
@section('title', 'Login Your DoListify Account')

@section('content')
    <div id="loginForm" class="space-y-4 w-10/12">
        <div>
            <h1 class="text-center text-3xl font-bold text-cyan-800">Welcome to DoListify</h1>
            <p class="text-center  mt-1.5 font-normal text-gray-400 ">Please enter your details.</p>
        </div>
        <form method="POST" action="{{ route('auth.login.post') }}" class="space-y-6">
            @csrf
            <div class="mt-4 space-y-4">
                <div>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="mt-1 shadow-cyan-800/75  @error('email') border-t border-l border-r border-red-500 @enderror appearance-none block w-full px-3 py-2 border-0 rounded-md shadow-md placeholder:text-slate-300 hover:shadow-cyan-500 focus:outline-none focus:border-b-0 focus:shadow-cyan-500 transition-all ease-in-out delay-75"
                        placeholder="Email">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    @if ($errors->has('credentials'))
                        <p class="text-red-500 text-xs mt-1">{{ $errors->first('credentials') }}</p>
                    @endif
                </div>
                <div>
                    <div class="relative">
                        <input type="password" name="password"
                            class="shadow-cyan-800/75  @error('password') border-t border-l border-r border-red-500 @enderror appearance-none block w-full px-3 py-2 border-0 rounded-md shadow-md placeholder:text-slate-300 hover:shadow-cyan-500 focus:outline-none focus:border-b-0 focus:shadow-cyan-500 transition-all ease-in-out delay-75"
                            placeholder="Password">
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between text-sm">
                <div class="flex items-center">
                    <input type="checkbox" name="terms_accepted"
                        class="@error('terms_accepted') border-t border-l border-r border-red-500 @enderror h-3 w-3 text-cyan-600 focus:ring-cyan-500 border rounded" />
                    <label class="ml-2 text-sm text-gray-600">Terms & Conditions</label>
                </div>

                <a href="{{route('forgot.password')}}" class="text-gray-600 text-sm hover:text-cyan-500 underline">
                    Forgot Password?
                </a>
            </div>
            @error('terms_accepted')
                <span class="text-red-500 text-xs" data-error="terms_accepted">{{ $message }}</span>
            @enderror
            <button type="submit"
                class="w-full flex justify-center py-3 lg:py-3 xl:py-4 px-4 border shadow-cyan-800 border-transparent rounded-md shadow-md text-white bg-cyan-900 hover:bg-cyan-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-800/75">
                Log In
            </button>
        </form>
        <div class="text-center space-y-2" style="margin-buttom:100px;">
            <span class="text-gray-600 text-sm">Don't have and account? </span> <a href="{{ route('register') }}"
                class="text-cyan-800 underline hover:text-cyan-500 cursor-pointer text-sm">Sign
                up for free</a>
        </div>
    </div>
    <script src="/storage/js/gmailVerify.js"></script>
@endsection
