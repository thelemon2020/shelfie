@livewireStyles()
<x-navbar></x-navbar>
<script>
    window.addEventListener('refreshPage', event => {
        location.reload()
    })
    window.addEventListener('keypress', event => {
        let element = event.target;
        element.dispatchEvent(new Event('input'));
    })
</script>
<body>
<div class="row">
    <div class="col-md-2">
        <a class="btn-primary btn m-2" href="{{route('home')}}">Back</a>
    </div>
    <div class="col-md-8">
        <h1 class="text-center">Add Release</h1>
    </div>
</div>
<livewire:edit/>
</body>
@livewireScripts()

