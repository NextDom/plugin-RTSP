#!/bin/bash

if [[ $EUID -ne 0 ]]; then
  sudo_prefix=sudo;
fi
echo "########### Reset ##########"
echo Arrêt des services en cours :
echo `ls /etc/init.d/rtsp-service-*`
echo `$sudo_prefix service rtsp-service-* stop`
echo `$sudo_prefix service rtsp-service-* status`

echo PPID supprimés :
echo `ps -afe | grep avconv | awk '{print $3}'`
$sudo_prefix kill -9 `ps -afe | grep avconv | grep rtsp | awk '{print $3}'`

echo PID supprimés :
echo `ps aux | grep avconv | awk '{print $2}'`
$sudo_prefix kill -9 `ps aux | grep avconv | grep rtsp | awk '{print $2}'`

echo Pensez à activer à nouveau vos services
echo en sauvegardant les configurations que vous souhaitez relancer parmi :
echo `ls /etc/init.d/rtsp-service-*`

echo Services zombies, doit être vide :
echo `ps aux | grep avconv | grep rtsp`

echo "########### Fin ##########"
