<div class="absolute top-0 left-0 bg-gray-500/50 h-full w-full flex" id="detailsModal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true"
>
    <div class="mx-auto my-auto bg-white w-auto" role="document">
        <div class="h-100 p-2 shadow-lg">
            <div class="relative border-b border-black">
                <h5 class="text-lg" id="modal-title">Record Details</h5>
                <button onclick="closeModal()" type="button" class="absolute top-0 right-0" data-bs-dismiss="modal"
                        aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="flex justify-around items-center py-2">
                <img id="thumbnail" class="p-1 w-3/4"
                     src="https://img.discogs.com/D4sQeozP2N0syrTXlmPL8Z-AHfg=/fit-in/600x606/filters:strip_icc():format(jpeg):mode_rgb():quality(90)/discogs-images/R-3155658-1402218436-4768.jpeg.jpg">
                <div class="p-1 w-1/4">
                    <label><b>Artist</b></label>
                    <p id="artist" class="mb-2">Test</p>
                    <label><b>Title</b></label>
                    <p id="title" class="mb-2">sjfkashf</p>
                    <label><b>Genre</b></label>
                    <p id="genre" class="mb-2">afhbsajfnjak</p>
                    <p class="mb-2">Played <span id="timesPlayed">11</span> times</p>
                    <p class="mb-2">Last played on<br><span id="lastPlayedAt">2022-08-24</span></p>
                    <input id="releaseId" hidden value="">
                </div>
            </div>
            <div class="flex border-t border-black justify-between pt-2">
                <div class="">
                    <button type="button" class="p-4 bg-blue-500 rounded-lg" data-dismiss="modal">
                        Close
                    </button>
                    <a class="p-5 bg-yellow-500 rounded-lg" id="edit" onclick="turnOffLight()" href="">Edit</a>
                    <button type="button" class="p-4 bg-red-500 rounded-lg" onclick="deleteRecord()">Delete</button>
                </div>
                <div class="">
                    <button type="button" onclick="playRecord()" data-bs-dismiss="modal"
                            class="p-4 bg-blue-500 rounded-lg">
                        Play
                        Album
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
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

    $(function () {
        $('#detailsModal').on('hide.bs.modal', function (e) {
            turnOffLight()
        })
    })
</script>
