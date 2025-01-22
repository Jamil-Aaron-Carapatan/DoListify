@extends('layout.PmsTheme')

@section('title', 'Account Settings | DoListify: Modify Your Account Settings')

@section('content')
    <main id="main-content" class="main-content">
        <div class="rounded-2xl px-3 pb-5 pt-2 space-y-2">
            <h1 class="text-2xl text-large text-gray-500">Account / Settings</h1>
            <div class="space-y-5">
                <!-- Profile Section -->
                <div class="bg-white p-4 md:p-8 rounded-2xl shadow-md transition-all hover:shadow-xl">
                    <p class="text-2xl md:text-3xl text-large mb-4 md:mb-6 text-cyan-800">Profile Details</p>
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div class="flex sm:flex-row items-start sm:items-center gap-4 w-full">
                            @if (auth()->user()->avatar)
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Profile Picture"
                                    class="w-16 h-16 rounded-full object-cover shadow-md">
                            @else
                                <div
                                    class="w-16 h-16 rounded-full shadow-inner shadow-black bg-teal-500
                                            flex items-center justify-center shadow-inner-2xl">
                                    <span class="text-large w-16 h-16 flex text-white items-center justify-center ">
                                        {{ strtoupper(substr(auth()->user()->first_name, 0, 1) . substr(auth()->user()->last_name, 0, 1)) }}
                                    </span>
                                </div>
                            @endif
                            <div class="w-full sm:w-auto">
                                <p class="text-xl md:text-2xl font-bold text-cyan-800">{{ auth()->user()->first_name }}
                                    {{ auth()->user()->last_name }}</p>
                                <p class="text-sm md:text-normal text-gray-500 mb-1">{{ auth()->user()->email }}</p>
                                <p class="text-sm md:text-normal text-emerald-600">
                                    <i class="fa-solid fa-star mr-1"></i>
                                    Points: {{ auth()->user()->points ?? 200 }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <!-- Upload Form -->
                            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data"
                                class="flex flex-col sm:flex-row items-center gap-4">
                                @csrf
                                @method('POST')
                                <label class="flex items-center cursor-pointer">
                                    <input type="file" name="avatar" accept="image/*" class="hidden"
                                        onchange="this.form.submit()">
                                    <div
                                        class="w-full sm:w-auto whitespace-nowrap px-8 py-2 md:py-3 rounded-xl text-normal
                                             hover:from-indigo-700 hover:to-indigo-600 transition-all duration-300 
                                             shadow-md hover:shadow-lg gap-2 text-gray-600 border border-gray-300">
                                        <i class="fa-solid fa-arrow-up-from-bracket mr-2"></i>
                                        <span>Upload Photo</span>
                                    </div>
                                </label>
                            </form>
                            @if (auth()->user()->avatar)
                                <!-- Remove Photo Button -->
                                <form action="{{ route('profile.removeAvatar') }}" method="POST" id="removeavatarForm">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button type="submit" onclick="showRemoveAvatarConfirmation()"
                                    class="w-full sm:w-auto whitespace-nowrap px-8 py-2 md:py-3 rounded-xl text-normal
                            bg-red-500 text-white hover:bg-red-600 transition-all duration-300 
                            shadow-md hover:shadow-lg gap-2">
                                    <i class="fa-solid fa-trash mr-2"></i>
                                    <span>Remove Photo</span>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="border-t-2 grid grid-cols-1 lg:grid-cols-2 gap-6 pt-5">
                    <!-- Edit Name Section -->
                    <div class="bg-white col-span-1 p-6 rounded-2xl shadow-md">
                        <h2 class="text-2xl text-large text-gray-500 mb-4">Edit Name</h2>
                        <form id="nameForm" action="{{ route('name.update') }}" method="POST">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-medium text-gray-500">First Name</label>
                                    <input type="text" name="first_name"
                                        placeholder="{{ old('first_name', auth()->user()->first_name) }}"
                                        class="w-full p-2 border rounded-lg {{ $errors->has('first_name') ? 'border-red-500' : 'border-cyan-700' }}">
                                    @error('first_name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-medium text-gray-500">Last Name</label>
                                    <input type="text" name="last_name"
                                        placeholder="{{ old('last_name', auth()->user()->last_name) }}"
                                        class="w-full p-2 border rounded-lg {{ $errors->has('last_name') ? 'border-red-500' : 'border-cyan-700' }}">
                                    @error('last_name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="flex justify-end">
                                    <button type="button" onclick="showNameConfirmation()"
                                        class="px-4 py-2 rounded-lg font-medium text-sm
                                        bg-cyan-700 text-white hover:bg-cyan-600
                                        transition-all duration-300 shadow-md hover:shadow-lg">
                                        Update Name
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Password Change Section -->
                    <div class="bg-white col-span-1 p-6 rounded-2xl shadow-md">
                        <h2 class="text-2xl text-large text-gray-500 mb-4">Change Password</h2>
                        <form id="passwordForm" action="{{ route('password.update') }}" method="POST">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-medium text-gray-500">Current Password</label>
                                    <input type="password" name="current_password" placeholder="Enter your current password"
                                        class="w-full p-2 border rounded-lg {{ $errors->has('current_password') ? 'border-red-500' : 'border-cyan-700' }}">
                                    @error('current_password')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-medium text-gray-500">New Password</label>
                                    <input type="password" name="new_password"
                                        placeholder="At least 8 characters with letters and numbers"
                                        class="w-full p-2 border rounded-lg {{ $errors->has('new_password') ? 'border-red-500' : 'border-cyan-700' }}">
                                    @error('new_password')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-medium text-gray-500">Confirm New Password</label>
                                    <input type="password" name="new_password_confirmation"
                                        placeholder="Re-enter your new password"
                                        class="w-full p-2 border rounded-lg {{ $errors->has('new_password_confirmation') ? 'border-red-500' : 'border-cyan-700' }}">
                                    @error('new_password_confirmation')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="flex justify-end">
                                    <button type="button" onclick="showPasswordConfirmation()"
                                        class="px-4 py-2 rounded-lg font-medium text-sm
                                        bg-cyan-700 text-white hover:bg-cyan-600
                                        transition-all duration-300 shadow-md hover:shadow-lg">
                                        Update Password
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

        <div id="nameModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center">
            <div class="bg-white p-8 rounded-2xl shadow-lg max-w-md mx-auto animate-appear">
                <h3 class="text-xl font-bold mb-4">Confirm Name Update</h3>
                <p class="text-gray-600 mb-6">Are you sure you want to update your name?</p>
                <div class="flex justify-end gap-4">
                    <button onclick="hideNameModal()"
                        class="px-4 py-2 rounded-lg text-gray-600 transition-all hover:bg-gray-200">
                        Cancel
                    </button>
                    <button onclick="submitNameForm()"
                        class="px-4 py-2 rounded-lg bg-cyan-700 text-white hover:bg-cyan-600">
                        Confirm
                    </button>
                </div>
            </div>
        </div>
        <!-- Remove Confirmation Modal -->
        <div id="removeavatarModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center">
            <div class="bg-white p-8 rounded-2xl shadow-lg max-w-md mx-auto animate-appear">
                <h3 class="text-xl font-bold mb-4">Remove profile picture</h3>
                <p class="text-gray-600 mb-6">Are you sure you want to remove your profile picture?</p>
                <div class="flex justify-end gap-4">
                    <button onclick="hideavatarModal()"
                        class="px-4 py-2 rounded-lg text-gray-600 transition-all hover:bg-gray-200">
                        Cancel
                    </button>
                    <button onclick="saveavatarModal()"
                        class="px-4 py-2 rounded-lg bg-cyan-700 text-white hover:bg-cyan-600">
                        Confirm
                    </button>
                </div>
            </div>
        </div>

        <!-- Password Update Confirmation Modal -->
        <div id="passwordModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center">
            <div class="bg-white p-8 rounded-2xl shadow-lg max-w-md mx-auto animate-appear">
                <h3 class="text-xl font-bold mb-4">Confirm Password Update</h3>
                <p class="text-gray-600 mb-6">Are you sure you want to update your password?</p>
                <div class="flex justify-end gap-4">
                    <button onclick="hidePasswordModal()"
                        class="px-4 py-2 rounded-lg text-gray-600 transition-all hover:bg-gray-200">
                        Cancel
                    </button>
                    <button onclick="submitPasswordForm()"
                        class="px-4 py-2 rounded-lg bg-cyan-700 text-white transition-all hover:bg-cyan-600">
                        Confirm
                    </button>
                </div>
            </div>
        </div>
    </main>

    <script>
        function showRemoveAvatarConfirmation() {
            document.getElementById('removeavatarModal').style.display = 'flex';
        }

        function hideavatarModal() {
            document.getElementById('removeavatarModal').style.display = 'none';
        }

        function saveavatarModal() {
            document.getElementById('removeavatarForm').submit();
        }

        function showNameConfirmation() {
            document.getElementById('nameModal').style.display = 'flex';
        }

        function hideNameModal() {
            document.getElementById('nameModal').style.display = 'none';
        }

        function submitNameForm() {
            document.getElementById('nameForm').submit();
        }

        function showPasswordConfirmation() {
            document.getElementById('passwordModal').style.display = 'flex';
        }

        function hidePasswordModal() {
            document.getElementById('passwordModal').style.display = 'none';
        }

        function submitPasswordForm() {
            document.getElementById('passwordForm').submit();
        }
    </script>
@endsection
