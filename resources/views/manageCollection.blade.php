<x-navbar></x-navbar>
@livewireStyles
<script>
    window.addEventListener('keypress', event => {
        let element = event.target;
        element.dispatchEvent(new Event('input'));
    })
</script>
<body>
<div>
    <a class="btn btn-primary m-2" href="{{route('collection.index')}}">Return to Collection</a>
</div>
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
        <div id="collapseTwo" class="collapse" aria-labelledby="headingThree" data-parent="#accordion"
             @if(\App\Models\User::all()->first()->userSettings->wled_ip === null)disabled @endif>
            <div class="card-body">
                @if(\App\Models\User::all()->first()->userSettings->sort_method == 'genre')
                    <livewire:manage-genres/>
                @endif
            </div>
        </div>
    </div>
</div>

</body>

@livewireScripts
