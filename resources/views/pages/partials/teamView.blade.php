<!-- Project Info Card -->
<div class="p-4 block lg:hidden">
    <div class="bg-gradient-to-br from-cyan-600 to-cyan-800 rounded-xl p-4 text-white space-y-4">
        <div class="flex items-center justify-between animate-fade-in">
            <h2 class="text-large text-3xl">Project Title</h2>
            <span class="px-3 py-1 bg-cyan-800 rounded-full text-sm">Project Type</span>
        </div>
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div class="space-y-2">
                <div class="flex items-center gap-2">
                    <i class="fas fa-user"></i>
                    <span>Created by: Creator Name</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Due: Jan 01, 2025</span>
                </div>
            </div>
            <div class="space-y-2">
                <div class="flex items-center gap-2">
                    <i class="fas fa-flag"></i>
                    <span>Priority: High</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fas fa-info-circle"></i>
                    <span>Status: To Do</span>
                </div>
                <span class="flex items-center">Team:
                    <div class="flex -space-x-3 ml-2">
                        <div class="relative group">
                            <img src="path/to/avatar.jpg"
                                alt="Profile Picture"
                                class="w-8 h-8 rounded-full object-cover border-2 border-white shadow-md cursor-pointer hover:z-10 transition-transform hover:scale-110">
                        </div>
                        <div class="w-8 h-8 rounded-full bg-cyan-700 text-white flex items-center justify-center text-xs font-medium border-2 border-white">
                            +3
                        </div>
                    </div>
                </span>
            </div>
        </div>
    </div>
</div>

<div id="ViewTaskTeam" class="grid grid-cols-1 lg:grid-cols-5 gap-2 px-4 lg:p-4">
    <div class="col-span-3 space-y-2">
        <div class="bg-cyan-900 rounded-2xl p-4 text-white min-h-[100vh-84px] flex flex-col">
            <div class="space-y-4 flex-grow">
                <div class="flex justify-between items-center border-b border-cyan-700 pb-4 animate-fade-in">
                    <h5 class="text-2xl text-large tracking-wide">Task Name</h5>
                    <div class="flex items-center gap-2 bg-cyan-700/50 px-4 py-2 rounded-lg whitespace-nowrap">
                        <i class="fas fa-star text-yellow-300"></i>
                        <span class="text-yellow-300 font-bold">+50 pts</span>
                    </div>
                </div>

                <div>
                    <div class="flex">
                        <button onclick="switchTab('description')" id="descriptionTab"
                            class="w-auto px-4 text-normal text-black py-1.5 bg-white rounded-t-2xl"><i
                                class="fas fa-file-alt mr-2"></i>Description</button>
                        <button onclick="switchTab('attachment')" id="attachmentTab"
                            class="w-auto px-4 text-normal text-black py-1.5 bg-gray-200 rounded-t-2xl"><i
                                class="fas fa-paperclip mr-2"></i>Attachments</button>
                    </div>
                    <div id="descriptionCont" class="bg-white rounded-2xl rounded-tl-none p-4">
                        <div class="border rounded-md p-4 min-h-[200px] lg:min-h-[300]">
                            <p class="text-normal text-black">Task Description</p>
                        </div>
                    </div>
                    <div id="attachmentCont" class="hidden bg-white rounded-2xl rounded-tl-none p-4">
                        <div class="border rounded-md p-4 min-h-[200px] lg:min-h-[300]">
                            <form method="POST" enctype="multipart/form-data" class="space-y-4">
                                <div class="flex items-center justify-center w-full">
                                    <label
                                        class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <i class="fas fa-cloud-upload-alt text-2xl text-gray-500 mb-2"></i>
                                            <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click
                                                    to upload</span> or drag and drop</p>
                                            <p class="text-xs text-gray-500">PDF, DOC, Images (MAX. 10MB)</p>
                                        </div>
                                        <input type="file" name="attachment" class="hidden" />
                                    </label>
                                </div>
                                <button type="submit"
                                    class="w-full px-4 py-2 text-white bg-cyan-600 rounded-lg hover:bg-cyan-700">
                                    <i class="fas fa-upload mr-2"></i> Upload File
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full flex justify-end gap-3 mt-2">
                <button class="whitespace-nowrap px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all duration-200 flex items-center gap-2 shadow-lg hover:shadow-xl">
                    <i class="fas fa-play"></i>
                    <span class="hidden lg:inline">Start Task</span>
                </button>
                <button class="whitespace-nowrap px-4 py-2 bg-cyan-600 text-white rounded-lg opacity-50 transition-all duration-200 cursor-not-allowed flex items-center gap-2"
                    disabled>
                    <i class="fas fa-check"></i>
                    <span>Mark as done</span>
                </button>
            </div>
        </div>
    </div>

    <div class="col-span-2 space-y-2">
        <div class="bg-gradient-to-br from-cyan-600 to-cyan-800 rounded-xl hidden lg:block p-4 text-white space-y-4">
            <div class="flex items-center justify-between animate-fade-in">
                <h2 class="text-large text-3xl">Project Title</h2>
                <span class="px-3 py-1 bg-cyan-800 rounded-full text-sm">Project Type</span>
            </div>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div class="space-y-2">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-user"></i>
                        <span>Created by: Creator Name</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Due: Jan 01, 2025</span>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-flag"></i>
                        <span>Priority: High</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-info-circle"></i>
                        <span>Status: To Do</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-neutral-300 rounded-xl shadow p-4 min-h-[400px]">
            <div class="flex gap-3 border-b border-gray-400 pb-3">
                <img src="path/to/avatar.jpg" alt="Profile Picture"
                    class="w-10 h-10 rounded-full mr-3">
                <div class="flex-1">
                    <textarea class="w-full rounded-lg border-gray-200 border p-3 text-sm resize-none focus:ring-0 focus:border-gray-300"
                        placeholder="Include any additional details..." rows="1"></textarea>
                    <div class="flex items-center gap-2 mt-2">
                        <button class="text-gray-700 hover:text-gray-500">
                            <i class="fas fa-smile"></i>
                        </button>
                        <button class="text-gray-700 hover:text-gray-500">
                            <i class="fas fa-paperclip"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="flex flex-col items-center justify-center h-[300px] text-gray-500/90 opacity-70">
                <i class="fas fa-comments text-4xl mb-3 animate-bounce"></i>
                <p class="text-xl font-semibold">No comments yet!</p>
                <p class="text-sm mt-2">Be the first one to start the conversation 😊</p>
            </div>
        </div>
    </div>
</div>
