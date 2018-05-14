#!/bin/bash
#/*
# * This file is part of the NextDom software (https://github.com/NextDom or http://nextdom.github.io).
# * Copyright (c) 2018 NextDom - Slobberbone.
# *
# * This program is free software: you can redistribute it and/or modify
# * it under the terms of the GNU General Public License as published by
# * the Free Software Foundation, version 2.
# *
# * This program is distributed in the hope that it will be useful, but
# * WITHOUT ANY WARRANTY; without even the implied warranty of
# * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
# * General Public License for more details.
# *
# * You should have received a copy of the GNU General Public License
# * along with this program. If not, see <http://www.gnu.org/licenses/>.
# */
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
