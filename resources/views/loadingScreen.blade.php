<x-navbar></x-navbar>
<script lang="js">
    window.onload = () => {
        axios.get('/api/collection/build')
            .then(() => {
                window.location.replace("/collection/index")
            })
            .catch(error => {
                console.log(error);
            })
    }
</script>
<div class="text-center">
    <div class="spinner-border" role="status">
        <span class="sr-only">Loading...</span>
    </div>
    <div>
        <p>Building Collection</p>
    </div>
</div>

