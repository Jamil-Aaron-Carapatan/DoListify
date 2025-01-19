@extends('layout.PmsTheme')

@section('title', 'Leaderboard | DoListify: Achieve Your Goals')

@section('content')
    <main id="main-content" class="main-content">
        <div class="rounded-2xl px-2 pb-5 pt-2 space-y-5 ">
            <h2 class="text-2xl font-bold mb-6">Top Achievers</h2>
            <div class="overflow-x-auto rounded-xl">
                <table class="min-w-full bg-white rounded-xl overflow-hidden shadow-lg">
                    <thead class="bg-gradient-to-r from-teal-400 to-cyan-800">
                        <tr class="text-center whitespace-nowrap">
                            <th class="px-6 py-3 text-xs font-medium text-white uppercase tracking-wider">Rank</th>
                            <th class="px-6 py-3 text-xs font-medium text-white uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-xs font-medium text-white uppercase tracking-wider">Points
                            </th>
                            <th class="px-6 py-3 text-xs font-medium text-white uppercase tracking-wider">Tasks
                                Completed</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-purple-100">
                        <tr class="text-center hover:bg-indigo-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap"><span class="text-2xl">🥇</span> 1</td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-teal-800">John Doe</td>
                            <td class="px-6 py-4 whitespace-nowrap text-cyan-800">1500 ✨</td>
                            <td class="px-6 py-4 whitespace-nowrap text-green-600">42 ✅</td>
                        </tr>
                        <tr class="text-center hover:bg-indigo-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap"><span class="text-2xl">🥈</span> 2</td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-teal-800">Jane Smith</td>
                            <td class="px-6 py-4 whitespace-nowrap text-cyan-800">1350 ✨</td>
                            <td class="px-6 py-4 whitespace-nowrap text-green-600">38 ✅</td>
                        </tr>
                        <tr class="text-center hover:bg-indigo-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap"><span class="text-2xl">🥉</span> 3</td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-teal-800">Mike Johnson</td>
                            <td class="px-6 py-4 whitespace-nowrap text-cyan-800">1200 ✨</td>
                            <td class="px-6 py-4 whitespace-nowrap text-green-600">35 ✅</td>
                        </tr>
                        <tr class="text-center hover:bg-indigo-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">4</td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-teal-800">Charlize Laniel</td>
                            <td class="px-6 py-4 whitespace-nowrap text-cyan-800">1100 </td>
                            <td class="px-6 py-4 whitespace-nowrap text-green-600">30 ✅</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
@endsection
