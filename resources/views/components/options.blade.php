<div id="accordion">
    <div class="card">
        <div class="card-header" id="headingOne">
            <h5 class="mb-0">
                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false"
                        aria-controls="collapseOne">
                    User Settings
                </button>
            </h5>
        </div>
        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
            <div class="card-body">
                <livewire:user-settings/>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header" id="headingOne">
            <h5 class="mb-0">
                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseSort" aria-expanded="false"
                        aria-controls="collapseSort">
                    Sort Settings
                </button>
            </h5>
        </div>
        <div id="collapseSort" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
            <div class="card-body">
                <livewire:user-settings/>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header" id="headingThree">
            <h5 class="mb-0">
                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false"
                        aria-controls="collapseThree"
                        @if(\App\Models\User::all()->first()->userSettings->wled_ip === null || \App\Models\User::all()->first()->userSettings->wled_ip === '')disabled @endif>
                    Manage Lights
                </button>
            </h5>
        </div>
        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
            <div class="card-body">
                <livewire:manage-light-segments/>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header" id="headingTwo">
            <h5 class="mb-0">
                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false"
                        aria-controls="collapseTwo">
                    Manage Genres
                </button>
            </h5>
        </div>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
            <div class="card-body">
                <livewire:manage-genres/>
            </div>
        </div>
    </div>
</div>
