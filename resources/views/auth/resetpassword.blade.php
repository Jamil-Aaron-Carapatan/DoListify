@extends('layout.Autheme')
@section('title', 'Reset Your Password | DoListify')

@section('content')
    <div id="verificationForm" class="space-y-6 w-10/12">
        <div>
            <h2 class="text-center text-3xl font-bold text-cyan-800">Reset Your Password</h2>
            <p class="text-center mt-2 font-normal text-gray-400">To finish the password reset process, kindly create a new one and confirm it.</p>
        </div>
        <form action="reset.password.post" method="POST" class="space-y-6">
            @csrf
            <div class="form-group mb-6">
                <input type="hidden" name="token" value="{{ request()->token }}">
                <div class="mt-4 space-y-4">
                    <input type="password" name="password"
                        class="mt-1 shadow-cyan-800/75 @error('password') border-t border-l border-r border-red-500 @enderror appearance-none block w-full px-3 py-2 border-0 rounded-md shadow-md placeholder:text-slate-400 hover:shadow-cyan-500 focus:outline-none focus:border-b-0 focus:shadow-cyan-500 transition-all ease-in-out delay-75"
                        placeholder="New Password" required>
                    <input
                        class="mt-1 shadow-cyan-800/75 @error('') border-t border-l border-r border-red-500 @enderror appearance-none block w-full px-3 py-2 border-0 rounded-md shadow-md placeholder:text-slate-400 hover:shadow-cyan-500 focus:outline-none focus:border-b-0 focus:shadow-cyan-500 transition-all ease-in-out delay-75"
                        type="password" name="password_confirmation" placeholder="Confirm Password" required>
                </div>
            </div>
            <button type="submit"class="w-full flex justify-center py-3 lg:py-3 xl:py-4 px-4 border shadow-cyan-800 border-transparent rounded-md shadow-md text-white bg-cyan-900 hover:bg-cyan-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-800/75" class="">Reset Password</button>
        </form>
    </div>
    @include('modal.reusableModal')
    <script src="/storage/js/backtoLogin.js"></script>
    <script src="/storage/js/verifyEmailLogin.js"></script>
    <script src="/storage/js/preventBack.js"></script>
@endsection
