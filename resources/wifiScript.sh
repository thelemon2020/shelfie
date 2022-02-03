#!/bin/bash

DESTDIR=/etc/wpa_supplicant/wpa_supplicant.conf

OUTPUT="country=us\n\
update_config=1\n\
ctrl_interface=/var/run/wpa_supplicant\n\\n\
network={\n\
scan_ssid=1\n\
ssid=\"$1\"\n\
psk=\"$2\"\n\
}"

wpa_cli terminate
echo -e "$3\n" | sudo -S sh -c "echo -e \"$OUTPUT\" > \"$DESTDIR\""
echo -e "$3\n" | sudo -S wpa_supplicant -B -i wlan0 -c /etc/wpa_supplicant/wpa_supplicant.conf
