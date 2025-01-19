@extends('layout.Autheme')
@section('title', 'Successful Password Reset | DoListify')
@section('content')
    <div id="resetpassSuccess" class=" space-y-6 text-center" style="width: 100%;">
        <div class="py-8">
            <svg class="mx-auto h-16 w-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                <circle cx="24" cy="24" r="22" stroke-width="2" stroke="currentColor" fill="none" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 24l6 6 12-12" />
            </svg>
            <h2 class="mt-4 text-3xl font-bold text-cyan-800">Successful Password Reset</h2>
            <p class="mt-2 text-gray-600"> Your password has been successfully updated. You’re all set to sign in and continue your journey with us.</p>`
        </div>
        <a href="/DoListify/Login"
            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-white bg-black hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500">
            Click here to Login
        </a>
    </div>
@endsection
<script src="/storage/js/preventBack.js"></script>