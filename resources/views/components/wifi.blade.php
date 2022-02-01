<div class="modal fade" id="wifiModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">Connect To Wifi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-auto">
                        <label for="ssid">Wifi Network Name</label>
                        <br>
                        <input type="text" class="form-control" name="ssid" id="wifi_ssid">
                    </div>
                    <div class="col-auto">
                        <label for="SSID">Wifi Password</label>
                        <br>
                        <input type="password" class="form-control" name="wifi_password" id="wifi_password">
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="mr-auto">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                    </div>
                    <div class="align-self-end">
                        <button type="button" onclick="connect()" data-bs-dismiss="modal" class="btn btn-primary">
                            Connect
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

</script>

