<ul class="" id="options-pills-tab" role="tablist">
    <li class="inline-block mr-2"
        role="presentation">
        <button class="p-4 raspi:p-1 rounded-lg" onclick="changeOptionTab('#pills-user-settings')"
                id="pills-user-settings-tab"
                type="button" role="option-tab" aria-controls="pills-playing"
                aria-selected="true">User Settings
        </button>
    </li>
    <li class="inline-block mr-2" role="presentation">
        <button class="p-4 raspi:p-1 bg-blue-500 rounded-lg text-white" onclick="changeOptionTab('#pills-sort-options')"
                id="pills-sort-options-tab"
                data-bs-toggle="pill"
                data-bs-target="#pills-collection"
                type="button" role="option-tab" aria-controls="pills-collection" aria-selected="false">Sort Options
        </button>
    </li>
    <li class="inline-block mr-2 @if(!\App\Models\UserSettings::query()->first()?->wled_ip) hidden @endif"
        id="lightsPill" role="presentation">
        <button class="p-4 raspi:p-1 bg-blue-500 rounded-lg text-white"
                onclick="changeOptionTab('#pills-light-segments')" id="pills-light-segments-tab" data-bs-toggle="pill"
                data-bs-target="#pills-stats"
                type="button" role="option-tab" aria-controls="pills-stats" aria-selected="false">Manage Light Segments
        </button>
    </li>
    <li class="inline-block mr-2" role="presentation">
        <button class="p-4 raspi:p-1 bg-blue-500 rounded-lg text-white"
                onclick="changeOptionTab('#pills-manage-genres')" id="pills-manage-genres-tab" data-bs-toggle="pill"
                data-bs-target="#pills-options"
                type="button" role="option-tab" aria-controls="pills-options" aria-selected="false">Manage Genres
        </button>
    </li>
</ul>
<div class="tab-content" id="pills-tabContent">
    <div id="pills-user-settings" role="option-panel"
         class=""
         aria-labelledby="pills-playing-tab">
        <livewire:user-settings/>
    </div>
    <div class="hidden" id="pills-sort-options" role="option-panel"
         aria-labelledby="pills-collection-tab">
        <livewire:sort-options/>
    </div>
    <div class="hidden" id="pills-light-segments" role="option-panel"
         aria-labelledby="pills-stats-tab">
        <livewire:manage-light-segments/>

    </div>
    <div class="hidden" id="pills-manage-genres" role="option-panel"
         aria-labelledby="pills-options-tab">
        <livewire:manage-genres/>
    </div>
</div>

<script>

    function changeOptionTab(pageId) {
        $("[role='option-panel']").addClass('hidden')
        $("[role='option-tab']").addClass('bg-blue-500')
        $("[role='option-tab']").addClass('text-white')
        $(pageId).toggleClass('hidden')
        $(pageId + '-tab').removeClass('bg-blue-500')
        $(pageId + '-tab').removeClass('text-white')
    }
</script>
