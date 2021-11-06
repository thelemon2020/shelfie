@livewireStyles()
<x-navbar></x-navbar>
<script>
    window.addEventListener('refreshPage', event => {
        location.reload()
    })
</script>
<body class="body-main">
@if(request()->query('message') === 'success')
    <div class="alert alert-success alert-dismissible fade show text-center">Record Updated Successfully
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
<div class="row">
    <div class="col-md-2">
        <a class="btn-primary btn m-2" href="{{route('collection.index')}}">Back</a>
    </div>
    <div class="col-md-8">
        <h1 class="text-center">Edit Release</h1>
    </div>
</div>
<livewire:edit :release="$release"/>
</body>
@livewireScripts()

