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
<div class="bg-blue-500 absolute bottom-0 w-full hidden" id="lightOptions">
    <h4 class="text-white text-center">LED Options</h4>
    <div class=" p-4 flex justify-around flex-shrink-0">
        <button class="text-white bg-blue-900 text-lg px-4 py-2 rounded" onclick="toggleLights()">On/Off</button>
        <button
            class="text-white bg-blue-900 text-lg px-4 py-2 rounded @if(!\App\Models\Release::query()->where('id', \Illuminate\Support\Facades\Cache::get('now-playing')) && !\App\Models\Plays::query()->latest()->get()->first()) disabled @endif"
            onclick="toggleNowPlayingLight()">Last Played
        </button>
        <button class="text-white bg-blue-900 text-lg px-4 py-2 rounded" onclick="lightSegments()">Segments</button>
        <div class="flex justify-center flex-col">
            <button class="text-white bg-blue-900 text-lg px-4 py-2 rounded" onclick="lightStrip()">Solid</button>
            <input type="color" id="stripColour">
        </div>
    </div>
    <input type="hidden" id="nowPlaying"
           value="{{!\App\Models\Release::query()->where('id', \Illuminate\Support\Facades\Cache::get('now-playing'))?? \App\Models\Plays::query()->latest()->get()->first()->release_id ?? null}}">
    <input type="hidden" id="nowPlayingLight" value="false">
</div>
