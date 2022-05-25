<div class="absolute hidden top-0 left-0 bg-gray-500/50 items-center grid h-screen w-screen" id="detailsModal"
     tabindex="-1"
     role="dialog"
     aria-labelledby="detailsModal"
     aria-hidden="true">
    <div class="mx-auto my-auto bg-white raspi:w-screen w-1/4">
        <div class="h-2/4 raspi:h-1/6 p-2 shadow-lg">
            <div id="detailsSection">
                <div class="relative border-b border-black">
                    <h5 class="text-lg" id="modal-title">Record Details</h5>
                    <button onclick="closeModal()" type="button" class="absolute top-0 right-0" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <div class="flex justify-around items-center py-2">
                    <img id="thumbnail" class="p-1 w-60">
                    <div class="p-1 w-2/4 raspi:flex">
                        <div class="px-2">
                            <label><b>Artist</b></label>
                            <p id="artist" class="mb-2"></p>
                            <label><b>Title</b></label>
                            <p id="title" class="mb-2"></p>
                            <label><b>Genre</b></label>
                            <p id="genre" class="mb-2"></p>
                        </div>
                        <div class="px-2">
                            <p class="mb-2">Released in <span id="releaseYear"></span></p>
                            <p class="mb-2">Played <span id="timesPlayed"></span> times</p>
                            <p class="mb-2">Last played on<br><span id="lastPlayedAt"></span></p>
                            <input id="releaseId" hidden value="">
                        </div>
                    </div>
                </div>
                <div class="flex border-t border-black justify-between pt-2">
                    <div class="">
                        <button type="button" class="p-4 bg-blue-500 rounded-lg text-white" onclick="closeModal()">
                            Close
                        </button>
                        <button class="p-4 bg-yellow-500 rounded-lg text-white" id="edit" onclick="openEditModal()"
                                href="">Edit
                        </button>
                        <button type="button" class="p-4 bg-red-500 rounded-lg text-white" onclick="deleteRecord()">
                            Delete
                        </button>
                    </div>
                    <div class="">
                        <button type="button" onclick="playRecord()" data-bs-dismiss="modal"
                                class="p-4 bg-blue-500 rounded-lg text-white">
                            Play
                            Album
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
    function openEditModal() {
        let releaseId = $('#releaseId').val()
        Livewire.emit('editRelease', releaseId)
        $('#detailsModal').toggleClass('hidden')
        $('#editModal').toggleClass('hidden')
    }

    function turnOffLight() {
        axios.get(`/api/lights/light/off`)
    }

    function playRecord() {
        let id = $('#releaseId').val()
        turnOffLight()
        axios.get(`/api/release/${id}/play`)
            .then((response) => {
                if (response.data.success === true) {
                    window.location.replace("/")
                }
            })
    }

    function deleteRecord() {
        turnOffLight()
        let id = $('#releaseId').val()
        axios.get(`/api/release/${id}/delete`)
            .then((response) => {
                if (response.data.message === 'success') {
                    location.reload()
                }
            })
    }

</script>
