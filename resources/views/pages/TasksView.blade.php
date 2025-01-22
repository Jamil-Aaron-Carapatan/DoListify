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
            @include('pages.partials.personalView', ['task' => $currentTask])
        </div>
    </div>
@endsection
<script>
    function switchTab(tab) {
        const descCont = document.getElementById('descriptionCont');
        const attCont = document.getElementById('attachmentCont');
        const descTab = document.getElementById('descriptionTab');
        const attTab = document.getElementById('attachmentTab');

        if (tab === 'description') {
            descCont.classList.remove('hidden');
            attCont.classList.add('hidden');
            descTab.classList.remove('bg-gray-200');
            descTab.classList.add('bg-white');
            attTab.classList.remove('bg-white');
            attTab.classList.add('bg-gray-200');
        } else {
            attCont.classList.remove('hidden');
            descCont.classList.add('hidden');
            attTab.classList.remove('bg-gray-200');
            attTab.classList.add('bg-white');
            descTab.classList.remove('bg-white');
            descTab.classList.add('bg-gray-200');
        }
    }
</script>
