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
ifup --force wlan0
sleep 20
echo ifconfig wlan0 | grep -q "inet addr:"
