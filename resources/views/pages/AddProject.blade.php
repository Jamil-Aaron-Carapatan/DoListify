<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="/storage/elements/Icon.png" type="image/png">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/storage/css/dist/addproject.css" as="style">
    @extends('layout.PmsTheme')
    @section('title', 'Add Project | DoListify: Make a plan to success')
</head>

<body>
    @section('content')
        <div id="main-content" class="main-content">
            <div class="rounded-2xl px-2 pb-3  space-y-5">
                <div class="content-container">
                    <!-- Project Type Selection -->
                    <div class="animate-fade-in">
                        <label class="labels">Project Type</label>
                        <div class="flex gap-4">
                            <button type="button" data-type="personal" class="project-type-btn bg-cyan-800 text-white">
                                Personal Project&nbsp;&nbsp;<i class="fa-solid fa-user"></i>
                            </button>
                            <button type="button" data-type="team" class="project-type-btn bg-zinc-300/80 text-gray-700">
                                Team Project&nbsp;&nbsp;<i class="fas fa-users"></i>
                            </button>
                        </div>
                        <input type="hidden" name="type" id="projectType" value="personal">
                    </div>

                    <div id="personalForm" class="project-form animate-fade-in">
                        @include('pages.partials.personal')
                    </div>

                    <!-- Team Project Form -->
                    <div id="teamForm" class="project-form hidden animate-fade-in">
                        @include('pages.partials.team')
                    </div>
                </div>
            </div>
        </div>

    @endsection
</body>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Project Type Selection
        const projectTypeBtns = document.querySelectorAll('.project-type-btn');
        const projectTypeInput = document.getElementById('projectType');

        projectTypeBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                projectTypeBtns.forEach(btn => {
                    btn.classList.remove('bg-cyan-800', 'text-white');
                    btn.classList.add('bg-zinc-300/80', 'text-gray-700');
                });
                this.classList.remove('bg-zinc-300/80', 'text-gray-700');
                this.classList.add('bg-cyan-800', 'text-white');

                // Show/Hide Project Forms
                const projectForms = document.querySelectorAll('.project-form');
                projectForms.forEach(form => form.classList.add('hidden'));
                document.getElementById(`${this.dataset.type}Form`).classList.remove('hidden');

            });
        });

    });
</script>

</html>
