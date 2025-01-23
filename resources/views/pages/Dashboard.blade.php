@extends('layout.PmsTheme')

@section('title', 'Dashboard | DoListify')

@section('content')
    <main id="main-content" class="main-content">
        <div class="rounded-2xl px-4 pb-5 pt-2 space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- To-Do Widget -->
                <div class="bg-white rounded-2xl shadow-md ">
                    <div class="p-6 flex items-center justify-between border-b animate-fade-in">
                        <div>
                            <h3 class="text-xl  font-bold text-gray-800">To Do</h3>
                            <p class="text-3xl font-bold text-cyan-700">4</p>
                        </div>
                        <div class="bg-cyan-700 p-3 rounded-2xl">
                            <svg class="w-8 h-8 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                    </div>
                    <div class="p-4 flex items-center justify-center animate-fade-in">
                        <p class="text-sm text-center text-gray-500">Your tasks are ready for action!</p>
                    </div>
                </div>

                <!-- In Progress Widget -->
                <div class="bg-white rounded-2xl shadow-md">
                    <div class="p-6 flex items-center justify-between border-b animate-fade-in">
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">In Progress</h3>
                            <p class="text-3xl font-bold text-amber-400">6</p>
                        </div>
                        <div class="bg-amber-400 p-3 rounded-2xl">
                            <svg class="w-8 h-8 text-amber-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="p-4 flex items-center justify-center animate-fade-in">
                        <p class="text-sm text-center text-gray-500">Goodluck! to the task you are working on.</p>
                    </div>
                </div>

                <!-- Completed Widget -->
                <div class="bg-white rounded-2xl shadow-md">
                    <div class="p-6 flex items-center justify-between border-b animate-fade-in">
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">Completed</h3>
                            <p class="text-3xl font-bold text-emerald-600">5</p>
                        </div>
                        <div class="bg-emerald-600 p-3 rounded-2xl">
                            <svg class="w-8 h-8 text-emerald-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    </div>
                    <div class="p-4 flex items-center justify-center animate-fade-in">
                        <p class="text-sm text-center text-gray-500">Great job! Keep up the excellent work!</p>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Upcoming Deadlines</h3>
                    <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Task</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Due Date</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                </tr>
                            </thead>

                            <!-- Task 1 -->
                            <tr onclick="window.location=''" class="cursor-pointer hover:bg-slate-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">Car Engine Fabrication</div>
                                    <div class="text-xs text-gray-500">Fabricate new car engine</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">Jan 25, 2025</div>
                                    <div class="text-xs text-gray-400">09:30 AM</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-4 inline-flex text-xs leading-5 font-semibold rounded-full bg-cyan-700 text-cyan-500">
                                        To Do
                                    </span>
                                </td>
                            </tr>

                            <!-- Task 2 -->
                            <tr class="cursor-pointer hover:bg-slate-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">Car Frame Welding</div>
                                    <div class="text-xs text-gray-500">Weld the frame for a new sports car</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">Jan 27, 2025</div>
                                    <div class="text-xs text-gray-400">11:00 AM</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-4 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        On Going
                                    </span>
                                </td>
                            </tr>

                            <!-- Task 3 -->
                            <tr class="cursor-pointer hover:bg-slate-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">Suspension System Assembly
                                    </div>
                                    <div class="text-xs text-gray-500">Assemble suspension components</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">Feb 2, 2025</div>
                                    <div class="text-xs text-gray-400">01:00 PM</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-4 inline-flex text-xs leading-5 font-semibold rounded-full bg-cyan-700 text-cyan-500">
                                        To Do
                                    </span>
                                </td>
                            </tr>

                            <!-- Task 4 -->
                            <tr class="cursor-pointer hover:bg-slate-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">Paint Car Body</div>
                                    <div class="text-xs text-gray-500">Paint and finish car exterior</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">Feb 5, 2025</div>
                                    <div class="text-xs text-gray-400">02:30 PM</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-4 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        In Progress
                                    </span>
                                </td>
                            </tr>

                            <!-- Task 5 -->
                            <tr class="cursor-pointer hover:bg-slate-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">Test Drive & Quality Check
                                    </div>
                                    <div class="text-xs text-gray-500">Perform test drive and quality
                                        inspection</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">Feb 10, 2025</div>
                                    <div class="text-xs text-gray-400">10:00 AM</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-4 inline-flex text-xs leading-5 font-semibold rounded-full bg-cyan-700 text-cyan-500">
                                        To Do
                                    </span>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        </tbody>
                        </table>
                    </div>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Weekly Task Tasks for Points</h3>
                    <div class="bg-white rounded-2xl shadow-md p-2">
                        <div class="space-y-4">
                            <!-- Task 1: Complete 3 tasks -->
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-900">Complete 3 tasks</h3>
                                        <p class="text-xs text-gray-500">Earn 20 points</p>
                                    </div>
                                </div>
                                <button
                                    class="px-4 py-2 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700"
                                    onclick="openClaimModal('Complete 3 tasks')">
                                    Claim
                                </button>
                            </div>
                            <!-- Task 2: Log in for 5 consecutive days -->
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-900">Log in for 5 consecutive days</h3>
                                        <p class="text-xs text-gray-500">Earn 100 points</p>
                                    </div>
                                </div>
                                <button class="px-4 py-2 text-sm font-medium text-gray-500 bg-gray-200 rounded-lg"
                                    disabled>
                                    4/5
                                </button>
                            </div>
                            <!-- New Task 3: Guess the Quote -->
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="12" cy="12" r="9" stroke="#9333ea" stroke-width="2"/>
                                            <circle cx="12" cy="18" r="0.5" fill="#9333ea" stroke="#9333ea"/>
                                            <path d="M12 16V14.5811C12 13.6369 12.6042 12.7986 13.5 12.5V12.5C14.3958 12.2014 15 11.3631 15 10.4189V9.90569C15 8.30092 13.6991 7 12.0943 7H12C10.3431 7 9 8.34315 9 10V10" stroke="#9333ea" stroke-width="2"/>
                                            </svg>
                                            
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-900">Guess the Quote</h3>
                                        <p class="text-xs text-gray-500">Earn 30 points</p>
                                    </div>
                                </div>
                                <button
                                    class="px-4 py-2 text-sm font-medium text-white bg-purple-600 rounded-lg hover:bg-purple-700"
                                    onclick="openClaimModal('Guess the Quote')">
                                    Start
                                </button>
                            </div>
                            <!-- New Task 4: Can you suggest? -->
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="12" cy="8" r="3" stroke="#0d9488"
                                                stroke-width="2" stroke-linecap="round" />
                                            <path
                                                d="M15.2679 8C15.5332 7.54063 15.97 7.20543 16.4824 7.06815C16.9947 6.93086 17.5406 7.00273 18 7.26795C18.4594 7.53317 18.7946 7.97 18.9319 8.48236C19.0691 8.99472 18.9973 9.54063 18.7321 10C18.4668 10.4594 18.03 10.7946 17.5176 10.9319C17.0053 11.0691 16.4594 10.9973 16 10.7321C15.5406 10.4668 15.2054 10.03 15.0681 9.51764C14.9309 9.00528 15.0027 8.45937 15.2679 8L15.2679 8Z"
                                                stroke="#0d9488" stroke-width="2" />
                                            <path
                                                d="M5.26795 8C5.53317 7.54063 5.97 7.20543 6.48236 7.06815C6.99472 6.93086 7.54063 7.00273 8 7.26795C8.45937 7.53317 8.79457 7.97 8.93185 8.48236C9.06914 8.99472 8.99727 9.54063 8.73205 10C8.46683 10.4594 8.03 10.7946 7.51764 10.9319C7.00528 11.0691 6.45937 10.9973 6 10.7321C5.54063 10.4668 5.20543 10.03 5.06815 9.51764C4.93086 9.00528 5.00273 8.45937 5.26795 8L5.26795 8Z"
                                                stroke="#0d9488" stroke-width="2" />
                                            <path
                                                d="M16.8816 18L15.9013 18.1974L16.0629 19H16.8816V18ZM20.7202 16.9042L21.6627 16.5699L20.7202 16.9042ZM14.7808 14.7105L14.176 13.9142L13.0194 14.7927L14.2527 15.5597L14.7808 14.7105ZM19.8672 17H16.8816V19H19.8672V17ZM19.7777 17.2384C19.7707 17.2186 19.7642 17.181 19.7725 17.1354C19.7804 17.0921 19.7982 17.0593 19.8151 17.0383C19.8474 16.9982 19.874 17 19.8672 17V19C21.0132 19 22.1414 17.9194 21.6627 16.5699L19.7777 17.2384ZM17 15C18.6416 15 19.4027 16.1811 19.7777 17.2384L21.6627 16.5699C21.1976 15.2588 19.9485 13 17 13V15ZM15.3857 15.5069C15.7702 15.2148 16.282 15 17 15V13C15.8381 13 14.9028 13.3622 14.176 13.9142L15.3857 15.5069ZM14.2527 15.5597C15.2918 16.206 15.7271 17.3324 15.9013 18.1974L17.8619 17.8026C17.644 16.7204 17.0374 14.9364 15.309 13.8614L14.2527 15.5597Z"
                                                fill="#0d9488" />
                                            <path
                                                d="M9.21918 14.7105L9.7473 15.5597L10.9806 14.7927L9.82403 13.9142L9.21918 14.7105ZM3.2798 16.9041L4.22227 17.2384L4.22227 17.2384L3.2798 16.9041ZM7.11835 18V19H7.93703L8.09867 18.1974L7.11835 18ZM7.00001 15C7.71803 15 8.22986 15.2148 8.61433 15.5069L9.82403 13.9142C9.09723 13.3621 8.1619 13 7.00001 13V15ZM4.22227 17.2384C4.59732 16.1811 5.35842 15 7.00001 15V13C4.0515 13 2.80238 15.2587 2.33733 16.5699L4.22227 17.2384ZM4.13278 17C4.126 17 4.15264 16.9982 4.18486 17.0383C4.20176 17.0593 4.21961 17.0921 4.22748 17.1354C4.2358 17.181 4.22931 17.2186 4.22227 17.2384L2.33733 16.5699C1.85864 17.9194 2.98677 19 4.13278 19V17ZM7.11835 17H4.13278V19H7.11835V17ZM8.09867 18.1974C8.27289 17.3324 8.70814 16.206 9.7473 15.5597L8.69106 13.8614C6.96257 14.9363 6.356 16.7203 6.13804 17.8026L8.09867 18.1974Z"
                                                fill="#0d9488" />
                                            <path
                                                d="M12 14C15.5715 14 16.5919 16.5512 16.8834 18.0089C16.9917 18.5504 16.5523 19 16 19H8C7.44772 19 7.00829 18.5504 7.11659 18.0089C7.4081 16.5512 8.42846 14 12 14Z"
                                                stroke="#0d9488" stroke-width="2" stroke-linecap="round" />
                                        </svg>

                                    </div>
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-900">Collaborate on a New Project</h3>
                                        <p class="text-xs text-gray-500">Earn 50 points</p>
                                    </div>
                                </div>
                                <button class="px-4 py-2 text-sm font-medium text-gray-500 bg-gray-200 rounded-lg"
                                    disabled>
                                    1/2
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="claimModal" class="fixed inset-0 justify-center items-center bg-gray-800 bg-opacity-50 z-50 hidden">
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full">
                <h3 class="text-xl font-semibold text-center text-green-600">🎉 Congratulations! 🎉</h3>
                <p class="text-center text-gray-700 mt-2" id="modalMessage">You have successfully completed the task!</p>
                <div class="mt-4 flex justify-center">
                    <button onclick="closeClaimModal()"
                        class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </main>
@endsection
<script>
    // Function to open the claim modal and set the message
    function openClaimModal(taskName) {
        document.getElementById('modalMessage').innerText = `You have successfully completed the "${taskName}" task!`;
        document.getElementById('claimModal').classList.remove('hidden');
    }

    // Function to close the claim modal
    function closeClaimModal() {
        document.getElementById('claimModal').classList.add('hidden');
    }
</script>
