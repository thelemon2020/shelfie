<div id="accordion">
    <div class="card">
        <div class="card-header" id="headingUserSettings">
            <h5 class="mb-0">
                <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#collapseUserSettings"
                        aria-expanded="false"
                        aria-controls="collapseOne">
                    User Settings
                </button>
            </h5>
        </div>
        <div id="collapseUserSettings" class="collapse show" aria-labelledby="headingUserSettings"
             data-parent="#accordion">
            <div class="card-body">
                <livewire:user-settings/>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header" id="headingSort">
            <h5 class="mb-0">
                <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#collapseSort"
                        aria-expanded="false"
                        aria-controls="collapseSort">
                    Sort Settings
                </button>
            </h5>
        </div>
        <div id="collapseSort" class="collapse" aria-labelledby="headingSort" data-parent="#accordion">
            <div class="card-body">
                <livewire:sort-options/>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header" id="headingThree">
            <h5 class="mb-0">
                <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#collapseLights"
                        aria-expanded="false"
                        aria-controls="collapseLights"
                        @if(\App\Models\User::all()->first()->userSettings->wled_ip === null || \App\Models\User::all()->first()->userSettings->wled_ip === '')disabled @endif>
                    Manage Lights
                </button>
            </h5>
        </div>
        <div id="collapseLights" class="collapse" aria-labelledby="headingLights" data-parent="#accordion">
            <div class="card-body">
                <livewire:manage-light-segments/>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header" id="headingTwo">
            <h5 class="mb-0">
                <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#collapseGenres"
                        aria-expanded="false"
                        aria-controls="collapseGenres">
                    Manage Genres
                </button>
            </h5>
        </div>
        <div id="collapseGenres" class="collapse" aria-labelledby="headingGenres" data-parent="#accordion">
            <div class="card-body">
                <livewire:manage-genres/>
            </div>
        </div>
    </div>
</div>
