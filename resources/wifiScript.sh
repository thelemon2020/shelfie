#!/bin/bash
DESTDIR=/etc/wpa_supplicant/wpa_supplicant.conf

OUTPUT="country=us\n\
update_config=1\n\
ctrl_interface=/var/run/wpa_supplicant\n\n\
network={\n\
 scan_ssid=1\n\
 ssid=\\\"$1\\\"\n\
 psk=\\\"$2\\\"\n\
}"

printf "$3\n" | sudo -S sh -c "printf \"%b\" \"$OUTPUT\" > \"$DESTDIR\""
printf "$3\n" | sudo -S wpa_cli reconnect
sleep 20
if [[ "$(ping -c 1 8.8.8.8 | grep '100% packet loss' )" != "" ]]; then
            exit 1
        else
            exit 0
        fi
