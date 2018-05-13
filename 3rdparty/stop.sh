#!/bin/bash

if [[ $EUID -ne 0 ]]; then
  sudo_prefix=sudo;
fi
echo "########### Arrêt du service ##########"
$sudo_prefix service rtsp-service-$1 stop
$sudo_prefix update-rc.d rtsp-service-$1 disable
echo "########### Fin ##########"
