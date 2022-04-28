<div class="absolute hidden top-0 left-0 bg-gray-500/50 items-center grid h-screen w-screen" role="dialog"
     id="imageModal">
    <div class="mx-auto my-auto bg-white w-1/2">
        <div class="h-1/4 p-2 shadow-lg">
            <div class="relative border-b border-black">
                <h5 class="text-lg" id="modal-title">Choose Image</h5>
                <button onclick="closeImageModal()" type="button" class="absolute top-0 right-0" aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="flex justify-around items-center py-2">
                <x-images></x-images>
            </div>
        </div>
    </div>
    <script>
        function closeImageModal() {
            $('#imageModal').toggleClass('hidden')
            $('#loadingSpinner').toggleClass('hidden')
            $('#image-carousel').toggleClass('hidden')
        }
    </script>
</div>

