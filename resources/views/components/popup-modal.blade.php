<div class="modal">
    {{ $button }}
    <div id={{ $modalId }} tabindex="-1" class="fixed hidden bg-black/70 top-0 left-0 right-0 z-50 overflow-x-hidden overflow-y-auto h-screen">
        <div class="relative w-full max-w-md max-h-full mx-auto mt-[100px]">
            <div class="relative bg-white rounded-lg shadow">
                <button class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 text-sm w-8 h-8 ml-auto inline-flex justify-center items-center" data-modal-hide={{ $modalId }}>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-6 text-center">
                    {{ $content }}
                    {{ $submit }}
                    <button data-modal-hide={{ $modalId }} class="text-gray-500 bg-white focus:ring-4 focus:outline-none focus:ring-gray-200 border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">No, cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
