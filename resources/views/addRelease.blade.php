@livewireStyles()
<x-navbar></x-navbar>
<script>
    window.addEventListener('refreshPage', event => {
        location.reload()
    })
</script>
<body class="body-main">
<div class="row">
    <div class="col-md-2">
        <a class="btn-primary btn m-2" href="{{route('collection.index')}}">Back</a>
    </div>
    <div class="col-md-8">
        <h1 class="text-center">Add Release</h1>
    </div>
</div>
<livewire:edit/>
</body>
@livewireScripts()

