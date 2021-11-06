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
</body>
<livewire:manage-genres/>
@livewireScripts
