<div>
    @if(session('success'))
        <div id="successModal" class="fixed inset-0 z-50 flex items-center justify-center transition-opacity duration-300 ease-in-out" aria-labelledby="successModalTitle" role="dialog" aria-modal="true">
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
                                <p>{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end">
                        <button type="button" onclick="closeModal('successModal')" class="inline-flex items-center px-4 py-2 bg-emerald-500 text-white rounded-md hover:bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors duration-200 text-sm">
                            OK
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div id="errorModal" class="fixed inset-0 z-50 flex items-center justify-center transition-opacity duration-300 ease-in-out" aria-labelledby="errorModalTitle" role="dialog" aria-modal="true">
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
                                <p>{{ session('error') }}</p>
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
    @endif

    <script>
        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            const modalContent = modal.querySelector('.modal-content');
            const modalBackdrop = modal.querySelector('.modal-backdrop');

            // Animate content out
            modalContent.classList.remove('animate-slide-down');
            modalContent.classList.add('animate-slide-up');

            // Animate backdrop out with delay
            setTimeout(() => {
                modalBackdrop.classList.add('opacity-0');
            }, 100);

            // Hide modal after animations
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 400);
        }

        document.addEventListener('DOMContentLoaded', () => {
            const modals = ['successModal', 'errorModal'];
            modals.forEach(modalId => {
                const modal = document.getElementById(modalId);
                if (modal) {
                    modal.classList.remove('hidden');
                    setTimeout(() => {
                        const modalContent = modal.querySelector('.modal-content');
                        const modalBackdrop = modal.querySelector('.modal-backdrop');
                        modalBackdrop.classList.remove('opacity-0');
                        modalContent.classList.add('animate-slide-down');
                    }, 10);
                }
            });
        });
    </script>

    <style>
        /* Slide Down Animation for Modal Content */
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-slide-down {
            animation: slideDown 0.3s ease-out forwards;
        }

        /* Slide Up Animation for Modal Content */
        @keyframes slideUp {
            from { opacity: 1; transform: translateY(0); }
            to { opacity: 0; transform: translateY(-20px); }
        }
        .animate-slide-up {
            animation: slideUp 0.3s ease-in forwards;
        }

        /* Pulse Animation for Icon */
        @keyframes pulseIcon {
            0%, 100% { transform: scale(1); }
            50% {Stripe transform: scale(1.2); }
        }
        .animate-pulse-icon {
            animation: pulseIcon 1.5s ease-in-out infinite;
        }
    </style>
</div>