#!/bin/bash
cd "$(dirname "$0")"

if [[ $EUID -ne 0 ]]; then
  sudo_prefix=sudo;
fi
echo "########### Suppression du service ##########"
if [ -f /etc/init.d/rtsp-service-$1 ]; then
    $sudo_prefix service rtsp-service-$1 stop
    $sudo_prefix update-rc.d rtsp-service-$1 remove
    $sudo_prefix systemctl daemon-reload
    $sudo_prefix rm -Rf /etc/init.d/rtsp-service-$1
    $sudo_prefix rm -Rf /usr/share/nginx/www/jeedom/snapshot_$1.jpg
fi
echo "########### Fin ##########"
