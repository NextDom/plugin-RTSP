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
