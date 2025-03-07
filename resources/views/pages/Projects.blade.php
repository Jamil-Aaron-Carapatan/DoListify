@extends('layout.PmsTheme')

@section('title', 'Projects | DoListify: See Your Projects')
<link rel="stylesheet" href="/storage/css/dist/addproject.css" as="style">
@section('content')
    <main id="main-content" class="main-content">
        <div class="rounded-2xl px-2 pb-5 space-y-3">
            <div class="buttons flex animate-fade-in">
                <div class="relative">
                    <button id="filterButton"
                        class="inline-flex items-center mt-4 px-6 py-2 bg-cyan-800
                        text-medium text-white rounded-md shadow-md
                        hover:bg-cyan-900 hover:shadow-lg transform hover:-translate-y-0.5
                        transition duration-300 ease-in-out focus:ring-2 focus:ring-cyan-700
                        focus:outline-none active:bg-cyan-950 group">
                        <span>Filter</span>
                        <svg class="ml-2 w-4 h-4 transition-transform duration-200 group-hover:rotate-180" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <form id="filterForm" action="{{ request()->url() }}" method="GET"
                        class="hidden absolute mt-2 w-64 bg-white rounded-lg shadow-lg z-50 border border-gray-200">
                        <div class="p-4 space-y-4">
                            <!-- Category Filter -->
                            <div>
                                <label class="block text-medium text-gray-700 mb-1">Category</label>
                                <select name="category" class="w-full rounded-md border border-gray-300 p-2 text-medium">
                                    <option value="">All Categories</option>
                                    <option value="Team" {{ request('category') == 'Team' ? 'selected' : '' }}>Team
                                    </option>
                                    <option value="Personal" {{ request('category') == 'Personal' ? 'selected' : '' }}>
                                        Personal</option>
                                </select>
                            </div>

                            <!-- Status Filter -->
                            <div>
                                <label class="block text-medium text-gray-700 mb-1">Status</label>
                                <select name="status" class="w-full rounded-md border border-gray-300 p-2 text-medium">
                                    <option value="">All Statuses</option>
                                    <option value="To Do" {{ request('status') == 'To Do' ? 'selected' : '' }}>To Do
                                    </option>
                                    <option value="Ongoing" {{ request('status') == 'Ongoing' ? 'selected' : '' }}>
                                        Ongoing</option>
                                    <option value="Done" {{ request('status') == 'Done' ? 'selected' : '' }}>Done
                                    </option>
                                </select>
                            </div>

                            <!-- Priority Filter -->
                            <div>
                                <label class="block text-medium text-gray-700 mb-1">Priority Level</label>
                                <select name="priority" class="w-full rounded-md border border-gray-300 p-2 text-medium">
                                    <option value="">All Priorities</option>
                                    <option value="High" {{ request('priority') == 'High' ? 'selected' : '' }}>High
                                    </option>
                                    <option value="Medium" {{ request('priority') == 'Medium' ? 'selected' : '' }}>
                                        Medium</option>
                                    <option value="Low" {{ request('priority') == 'Low' ? 'selected' : '' }}>Low
                                    </option>
                                </select>
                            </div>

                            <!-- Apply and Reset Buttons -->
                            <div class="flex space-x-2">
                                <a href="{{ request()->url() }}"
                                    class="flex-1 px-4 py-2 bg-gray-100 text-center text-medium text-gray-700 rounded-md hover:bg-gray-200 transition-colors">
                                    Reset
                                </a>
                                <button type="submit"
                                    class="flex-1 px-4 py-2 bg-zinc-700 text-medium text-white rounded-md hover:bg-zinc-800 transition-colors">
                                    Apply
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="mt-4 bg-white rounded-lg shadow-md overflow-hidden flex flex-col">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-cyan-800">
                            <tr>
                                <th class="px-6 py-3 text-left text-large text-sm text-white uppercase tracking-wider">
                                    Task Name
                                </th>
                                <th class="px-6 py-3 text-left text-large text-sm text-white uppercase tracking-wider">
                                    Category
                                </th>
                                <th class="px-6 py-3 text-left text-large text-sm text-white uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-large text-sm text-white uppercase tracking-wider">
                                    Priority
                                </th>
                                <th class="px-6 py-3 text-left text-large text-sm text-white uppercase tracking-wider">
                                    Due Date
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-zinc-200">
                            <!-- Example of Team Task -->
                            <tr class="hover:bg-teal-600/50 cursor-pointer" onclick="window.location='#'">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-medium font-semibold text-black">Complete Project Blueprint</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-medium text-black">Team</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap animate-fade-in">
                                    <span
                                        class="px-4 inline-flex text-medium text-xs leading-5 font-normal rounded-full bg-yellow-100 text-yellow-800">
                                        To Do
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap animate-fade-in">
                                    <span
                                        class="px-4 inline-flex text-medium text-xs leading-5 font-normal rounded-full bg-red-100 text-red-800">
                                        High
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-medium text-sm text-black">
                                    02-15-2025
                                </td>
                            </tr>
                            <!-- Example of Personal Task -->
                            <tr class="hover:bg-teal-600/50 cursor-pointer" onclick="window.location='#'">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-medium font-semibold text-black">Finish Fabrication for Client X</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-medium text-black">Personal</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap animate-fade-in">
                                    <span
                                        class="px-4 inline-flex text-medium text-xs leading-5 font-normal rounded-full bg-blue-100 text-blue-800">
                                        Ongoing
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap animate-fade-in">
                                    <span
                                        class="px-4 inline-flex text-medium text-xs leading-5 font-normal rounded-full bg-orange-100 text-orange-800">
                                        Medium
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-medium text-sm text-black">
                                    01-30-2025
                                </td>
                            </tr>
                            <!-- Another Personal Task -->
                            <tr class="hover:bg-teal-600/50 cursor-pointer" onclick="window.location='#'">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-medium font-semibold text-black">Prepare Welding Equipment</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-medium text-black">Personal</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap animate-fade-in">
                                    <span
                                        class="px-4 inline-flex text-medium text-xs leading-5 font-normal rounded-full bg-green-100 text-green-800">
                                        Done
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap animate-fade-in">
                                    <span
                                        class="px-4 inline-flex text-medium text-xs leading-5 font-normal rounded-full bg-green-100 text-green-800">
                                        Low
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-medium text-sm text-black">
                                    01-25-2025
                                </td>
                            </tr>
                            <!-- Example of Team Task -->
                            <tr class="hover:bg-teal-600/50 cursor-pointer" onclick="window.location='#'">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-medium font-semibold text-black">Collaborate on New Design</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-medium text-black">Team</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap animate-fade-in">
                                    <span
                                        class="px-4 inline-flex text-medium text-xs leading-5 font-normal rounded-full bg-blue-100 text-blue-800">
                                        Ongoing
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap animate-fade-in">
                                    <span
                                        class="px-4 inline-flex text-medium text-xs leading-5 font-normal rounded-full bg-orange-100 text-orange-800">
                                        Medium
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-medium text-sm text-black">
                                    02-10-2025
                                </td>
                            </tr>
                            <!-- Example of Personal Task -->
                            <tr class="hover:bg-teal-600/50 cursor-pointer" onclick="window.location='#'">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-medium font-semibold text-black">Submit Fabrication Report</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-medium text-black">Personal</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap animate-fade-in">
                                    <span
                                        class="px-4 inline-flex text-medium text-xs leading-5 font-normal rounded-full bg-green-100 text-green-800">
                                        Done
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap animate-fade-in">
                                    <span
                                        class="px-4 inline-flex text-medium text-xs leading-5 font-normal rounded-full bg-green-100 text-green-800">
                                        Low
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-medium text-sm text-black">
                                    01-23-2025
                                </td>
                            </tr>
                            <!-- Additional Team Task -->
                            <tr class="hover:bg-teal-600/50 cursor-pointer" onclick="window.location='#'">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-medium font-semibold text-black">Finalize Client Proposals</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-medium text-black">Team</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap animate-fade-in">
                                    <span
                                        class="px-4 inline-flex text-medium text-xs leading-5 font-normal rounded-full bg-yellow-100 text-yellow-800">
                                        To Do
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap animate-fade-in">
                                    <span
                                        class="px-4 inline-flex text-medium text-xs leading-5 font-normal rounded-full bg-red-100 text-red-800">
                                        High
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-medium text-sm text-black">
                                    02-20-2025
                                </td>
                            </tr>
                            <!-- Another Personal Task -->
                            <tr class="hover:bg-teal-600/50 cursor-pointer" onclick="window.location='#'">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-medium font-semibold text-black">Check Fabrication Stock</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-medium text-black">Personal</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap animate-fade-in">
                                    <span
                                        class="px-4 inline-flex text-medium text-xs leading-5 font-normal rounded-full bg-blue-100 text-blue-800">
                                        Ongoing
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap animate-fade-in">
                                    <span
                                        class="px-4 inline-flex text-medium text-xs leading-5 font-normal rounded-full bg-orange-100 text-orange-800">
                                        Medium
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-medium text-sm text-black">
                                    01-28-2025
                                </td>
                            </tr>
                            <!-- Another Team Task -->
                            <tr class="hover:bg-teal-600/50 cursor-pointer" onclick="window.location='#'">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-medium font-semibold text-black">Prepare Team Presentation</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-medium text-black">Team</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap animate-fade-in">
                                    <span
                                        class="px-4 inline-flex text-medium text-xs leading-5 font-normal rounded-full bg-yellow-100 text-yellow-800">
                                        To Do
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap animate-fade-in">
                                    <span
                                        class="px-4 inline-flex text-medium text-xs leading-5 font-normal rounded-full bg-red-100 text-red-800">
                                        High
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-medium text-sm text-black">
                                    02-18-2025
                                </td>
                            </tr>
                            <!-- Another Personal Task -->
                            <tr class="hover:bg-teal-600/50 cursor-pointer" onclick="window.location='#'">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-medium font-semibold text-black">Order Fabrication Tools</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-medium text-black">Personal</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap animate-fade-in">
                                    <span
                                        class="px-4 inline-flex text-medium text-xs leading-5 font-normal rounded-full bg-blue-100 text-blue-800">
                                        Ongoing
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap animate-fade-in">
                                    <span
                                        class="px-4 inline-flex text-medium text-xs leading-5 font-normal rounded-full bg-orange-100 text-orange-800">
                                        Medium
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-medium text-sm text-black">
                                    01-26-2025
                                </td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="pt-2 border-t text-medium text-sm text-gray-200">
                {{ $projects->links('pagination::custom-tailwind') }}
            </div>
            <!--
                        <div class="flex flex-col justify-center items-center">
                            <img src="/storage/icons/empty.svg" alt="Description of SVG" class="">
                            <h4 class="text-medium text-sm text-gray-400 text-center">Oops, looks like you don't have any tasks yet.
                                Ready to
                                create
                                one and get started?
                            </h4>
                            <a href="{{ route('addProject') }}"
                                class="inline-flex items-center mt-4 px-6 py-3 bg-zinc-900 text-medium text-sm text-white text-md font-medium rounded-full shadow hover:bg-zinc-800 transition ease-in-out">Create
                                Task</a>
                        </div> -->

        </div>
    </main>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterButton = document.getElementById('filterButton');
        const filterForm = document.getElementById('filterForm');

        // Toggle filter form
        filterButton.addEventListener('click', function(e) {
            e.stopPropagation();
            filterForm.classList.toggle('hidden');
        });

        // Close form when clicking outside
        document.addEventListener('click', function(e) {
            if (!filterButton.contains(e.target) && !filterForm.contains(e.target)) {
                filterForm.classList.add('hidden');
            }
        });

        // Prevent form from closing when clicking inside it
        filterForm.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    });
</script>
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
