<div class="overflow-x-scroll">
    <script>
        window.addEventListener('reloadLightsComponent', event => {
            location.reload()
        })
    </script>
    <form wire:submit.prevent="submit">
        <div class="flex flex-row">
            @foreach($segments as $segment)
                <livewire:update-light-segments :segment="$segment" :wire:key="$segment->id"/>
            @endforeach
            <button type="button"
                    class="bg-blue-500 p-4 m-1 raspi:h-[65vh] raspi:w-[65vh] h-72 w-72 rounded rounded-lg text-white"
                    wire:click="createSegment">
                <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-6 w-6" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zM6 20h2a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z"/>
                </svg>
                <br>
                Add LED Segment
            </button>
        </div>
        <button type="submit"
                class="bg-blue-500 rounded p-4 raspi:p-1 rounded-md raspi:text-md text-lg mb-1 text-white">Update
        </button>
    </form>
</div>
