@livewireStyles()
<x-navbar></x-navbar>
<script>
    window.addEventListener('refreshPage', event => {
        location.reload()
    })
</script>
<div class="row">
    <div class="col-2">
        <a class="btn-primary btn m-2" href="{{route('collection.index')}}">Back</a>
    </div>
    <div class="col-8">
        <h1 class="text-center">Add Release</h1>
    </div>
</div>
<livewire:edit/>
@livewireScripts()
