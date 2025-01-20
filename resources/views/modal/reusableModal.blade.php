<div id="confirmationModal" class="fixed z-[999] inset-0 items-center justify-center hidden"
    style="margin-top: 0 !important" aria-labelledby="modalTitle" role="dialog" aria-modal="true">
    <!-- Background backdrop, show/hide based on modal state -->
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50" aria-hidden="true"></div>
    <div class="fixed inset-0 z-[999] w-screen overflow-y-auto animate-appear">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:items-center sm:p-0">
            <!-- Modal panel, show/hide based on modal state -->
            <div
                class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="flex flex-col items-start">
                        <div class="mt-3 sm:mt-0 ">
                            <h3 id="modalTitle" class="text-large text-lg text-cyan-800 text-center lg:text-start mb-4">Are you sure?</h3>
                            <p id="modalMessage" class="text-medium text-cyan-900 text-center lg:text-start mb-4">You can customize this
                                message.</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button id="confirmButton"
                        class="inline-flex w-full justify-center rounded-md px-3 py-2 bg-cyan-700 text-large text-sm text-white transition-all shadow-sm hover:bg-cyan-600 sm:ml-3 sm:w-auto">Confirm</button>
                    <button id="cancelButton"
                        class="mt-3 inline-flex w-full justify-center rounded-md  px-3 py-2 text-large text-sm text-gray-600 shadow-sm transition-all hover:bg-gray-200 sm:mt-0 sm:w-auto">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/storage/js/modal.js"></script>
