@extends('layout.Autheme')
@section('title', 'Verify Your DoListify Account')

@section('content')
    <div id="verificationForm" class="space-y-6 w-10/12">
        <div>
            <h2 class="text-center text-3xl font-bold text-cyan-800">Verify its you.</h2>
            <p class="text-center text-sm mt-2 font-normal text-gray-400">Please check your inbox and enter the verification
                code we sent to
                {{ $email }}.</p>
            </div>
            <form id="emailVerificationForm" class="" value="{{ route('auth.verifyLoginUser') }}" method="POST">
                @csrf
                <div class="form-group mb-6">
                    <div class="mt-1 relative">
                        <input type="text" id="verification_code" name="code" maxlength="6"
                            class="mb-2 shadow-cyan-800/75 appearance-none block w-full px-3 py-3 border-0 rounded-md shadow-md placeholder:text-medium placeholder:text-slate-400 hover:shadow-cyan-500 focus:outline-none focus:border-b-0 focus:shadow-cyan-500 transition-all ease-in-out delay-75"
                          placeholder="Enter 6-digit code">
                        <span class="error-message hidden text-xs text-red-500 mt-1"></span>
                    </div>
                </div>
                <button type="submit"
                    class=" w-full mb-2 flex text-large text-[16px] justify-center py-3 lg:py-3 xl:py-4 px-4 border shadow-cyan-800 border-transparent rounded-md shadow-md text-white bg-cyan-900 hover:bg-cyan-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-800/75 ">
                    Verify Email
                </button>
                <div class=" mb-4">
                    <button type="button" id="resendVerificationCode" class="text-cyan-600 hover:text-cyan-500 text-sm">
                        Resend Code
                    </button>

                </div>
                <div class="text-center">
                    <a id="backtoLogin" class="w-full text-cyan-600 text-sm hover:text-cyan-500 cursor-pointer">
                        Back to Login
                    </a>
                </div>
            </form>
        </div>
        @include('modal.reusableModal')
        <script src="/storage/js/backtoLogin.js"></script>
        <script src="/storage/js/verifyEmailLogin.js"></script>
        <script src="/storage/js/preventBack.js"></script>
    @endsection
