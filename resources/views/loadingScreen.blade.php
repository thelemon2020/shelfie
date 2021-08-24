<x-navbar></x-navbar>
<script lang="js">
    window.onload = () => {
        console.log("we are alive");
        axios.get('/api/collection/build')
            .then(() => {
                console.log("we got here");
                window.location.replace("/collection/index")
            })
            .catch(error => {
                console.log(error);
            })
    }
</script>
