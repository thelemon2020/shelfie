#!/bin/bash

DESTDIR=/etc/wpa_supplicant/wpa_supplicant.conf

OUTPUT="country=us\nupdate_config=1\nctrl_interface=/var/run/wpa_supplicant\n
network={\nscan_ssid=1\n\nssid=\"$1\"\npsk=\"$2\"\n}\n"

{ echo "$3"; echo "$OUTPUT"; } | sudo -S tee $DESTDIR &>/dev/null

