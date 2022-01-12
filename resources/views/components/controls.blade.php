<script>
    function toggleLights() {
        axios.get(`/api/lights/toggle`)
    }

    function lightSegments() {
        axios.get(`/api/lights/segments`)
    }

    function lightStrip() {
        axios.get(`/api/lights/strip`, {
            params: {
                colour: $('#stripColour').value
            }
        })
    }
</script>
<div class="fixed-bottom" id="lightOptions">
    <div class="bg-primary p-4 text-center">
        <h4 class="text-white">LED Options</h4>
        <div class="container">
            <div class="row">
                <div class="col">
                    <button class="btn btn-primary border border-dark" onclick="toggleLights()">On/Off</button>
                </div>
                <div class="col">
                    <button class="btn btn-primary border border-dark" onclick="lightSegments()">Segments</button>
                </div>
                <div class="col">
                    <button class="btn btn-primary border border-dark" onclick="lightStrip()">Solid</button>
                </div>
            </div>
            <div class="row">
                <div class="col">
                </div>
                <div class="col">
                </div>
                <div class="col mt-1">
                    <input type="color" id="stripColour">
                </div>
            </div>
        </div>
    </div>
</div>
