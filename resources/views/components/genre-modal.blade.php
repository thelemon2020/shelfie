<div class="absolute hidden top-0 left-0 bg-gray-500/50 items-center grid h-screen w-screen" id="genreModal"
     tabindex="-1"
     role="dialog"
     aria-labelledby="genreModal"
     aria-hidden="true">
    <div class="mx-auto my-auto bg-white raspi:w-2/4 w-2/12">
        <div class="h-2/4 p-2 shadow-lg">
            <div class="relative">
                <h5 id="modal-title">Add Genre</h5>
                <button onclick="closeGenreModal()"
                        type="button" class="absolute top-0 right-0" aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <livewire:genres/>
            </div>
        </div>
    </div>
    <script>
        function closeGenreModal() {
            $('#genreModal').toggleClass('hidden')
        }
    </script>
</div>
