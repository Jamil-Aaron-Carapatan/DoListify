@extends('layout.PmsTheme')

@section('title', 'Tasks | DoListify: See Your Tasks')

@section('content')
    <div id="main-content" class="main-content">
        <div class="w-full flex items-center justify-between px-2 py-2">
            <a href="{{ url()->previous() }}"
                class="flex items-center gap-2 py-2 px-4 rounded-md bg-cyan-800 w-auto text-white hover:bg-cyan-700 transition-colors duration-200">
                <i class="fa-solid fa-arrow-left-long"></i>
            </a>
        </div>
        <div class="rounded-2xl mb-3 pb-4 lg:pb-0 bg-white shadow-md min-h-[calc(100vh-132px)] ">
            <!-- if Personal Project -->
            @include('pages.partials.teamView')
        </div>
        <div id="saveChangesModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center">
            <div class="bg-white p-8 rounded-2xl shadow-lg max-w-md mx-auto animate-appear">
                <h3 class="text-xl font-bold mb-4">Confirm Save Changes</h3>
                <p class="text-gray-600 mb-6">Are you sure you want to save changes?</p>
                <div class="flex justify-end gap-4">
                    <button onclick="hidesaveChanges()"
                        class="px-4 py-2 rounded-lg text-gray-600 transition-all hover:bg-gray-200">
                        Cancel
                    </button>
                    <button onclick="SubmitEditForm()"
                        class="px-4 py-2 rounded-lg bg-cyan-700 text-white hover:bg-cyan-600">
                        Confirm
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection