<script>

    function toggleLights() {
        axios.get(`/api/lights/toggle`)
    }

    function lightSegments() {
        axios.get(`/api/lights/segments`)
    }

    function lightStrip() {
        axios.get(`/api/lights/strip`, {
            params: {
                colour: $('#stripColour').val()
            }
        })
    }

    function toggleNowPlayingLight() {
        console.log($('#nowPlayingLight').val())
        if ($('#nowPlayingLight').val() === 'false') {
            let id = $('#nowPlaying').val()
            axios.get(`/api/lights/light/${id}/on`)
            $('#nowPlayingLight').val('true')
        } else {
            axios.get(`/api/lights/light/off`)
            $('#nowPlayingLight').val('false')
        }
    }

</script>
<div class="fixed-bottom collapse" id="lightOptions">
    <div class="bg-primary p-4 text-center">
        <h4 class="text-white">LED Options</h4>
        <div class="container">
            <div class="row">
                <div class="col">
                    <button class="btn btn-primary border border-dark" onclick="toggleLights()">On/Off</button>
                </div>
                <div class="col">
                    <button
                        class="btn btn-primary border border-dark @if(!$nowPlaying && !\App\Models\Plays::query()->latest()->get()->first()) disabled @endif"
                        onclick="toggleNowPlayingLight()">Last Played
                    </button>
                </div>
                <div class="col">
                    <button class="btn btn-primary border border-dark" onclick="lightSegments()">Segments</button>
                </div>
                <div class="col">
                    <button class="btn btn-primary border border-dark" onclick="lightStrip()">Solid</button>
                </div>
            </div>
            <div class="row">
                <div class="col">
                </div>
                <div class="col">
                </div>
                <div class="col">
                </div>
                <div class="col mt-1">
                    <input type="color" id="stripColour">
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="nowPlaying"
           value="{{$nowPlaying->id ?? \App\Models\Plays::query()->latest()->get()->first()->release_id ?? null}}">
    <input type="hidden" id="nowPlayingLight" value="false">
</div>
