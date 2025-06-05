<div id="success-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center transition-opacity duration-300 ease-in-out" aria-labelledby="successModalTitle" role="dialog" aria-modal="true">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm transition-opacity duration-500 ease-in-out modal-backdrop"></div>
    <!-- Modal Content -->
    <div class="relative bg-white rounded-lg shadow-xl max-w-lg w-full mx-4 transform transition-all duration-300 ease-in-out modal-content animate-slide-down">
        <div class="p-8">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-8 w-8 text-green-600 animate-pulse-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 id="successModalTitle" class="text-xl font-semibold text-gray-900">Success</h3>
                    <div class="mt-2 text-gray-600 text-sm">
                        <p id="success-message"></p>
                    </div>
                </div>
            </div>
            <div class="mt-6 flex justify-end">
                <button type="button" onclick="close_success()" class="inline-flex items-center px-4 py-2 bg-emerald-500 text-white rounded-md hover:bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors duration-200 text-sm">
                    OK
                </button>
            </div>
        </div>
    </div>
</div>

<div id="fail-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center transition-opacity duration-300 ease-in-out" aria-labelledby="errorModalTitle" role="dialog" aria-modal="true">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm transition-opacity duration-500 ease-in-out modal-backdrop"></div>
    <!-- Modal Content -->
    <div class="relative bg-white rounded-lg shadow-xl max-w-lg w-full mx-4 transform transition-all duration-300 ease-in-out modal-content animate-slide-down">
        <div class="p-8">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-8 w-8 text-red-600 animate-pulse-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 id="errorModalTitle" class="text-xl font-semibold text-gray-900">Error</h3>
                    <div class="mt-2 text-gray-600 text-sm">
                        <p id="fail-message"> session('error') </p>
                    </div>
                </div>
            </div>
            <div class="mt-6 flex justify-end">
                <button type="button" onclick="closeModal('errorModal')" class="inline-flex items-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200 text-sm">
                    OK
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function close_success()
    {
        document.getElementById('success-modal').classList.add('hidden');
    }

    function open_success(message)
    {
        document.getElementById('success-message').innerHTML = message;
        document.getElementById('success-modal').classList.remove('hidden');
    
        setTimeout(function () {
            close_success();
        }, 2000);
    }

    function close_fail()
    {
        document.getElementById('fail-modal').classList.add('hidden');
    }

    function open_fail(message)
    {
        document.getElementById('fail-message').innerHTML = message;
        document.getElementById('fail-modal').classList.remove('hidden');
    
        setTimeout(function () {
            close_fail();
        }, 2000);
    }

</script>