#!/bin/bash

DESTDIR=/etc/wpa_supplicant/wpa_supplicant.conf

OUTPUT="country=us
       update_config=1
       ctrl_interface=/var/run/wpa_supplicant

       network={
        scan_ssid=1
        ssid=\"$1\"
        psk=\"$2\"
       }"

{ echo "$3"; echo "$OUTPUT"; } | sudo -S tee $DESTDIR &>/dev/null

