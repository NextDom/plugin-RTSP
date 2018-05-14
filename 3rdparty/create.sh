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
echo "########### Création/Mise à jour du service ##########"
if [ -f /etc/init.d/rtsp-service-$1 ]; then
    echo "Service already exist for $1, replace it"
    $sudo_prefix service rtsp-service-$1 stop
    $sudo_prefix update-rc.d -f rtsp-service-$1 remove
    $sudo_prefix rm -Rf /etc/init.d/rtsp-service-$1
    $sudo_prefix rm -Rf /usr/share/nginx/www/jeedom/plugins/RTSP/captures/snapshot_$1.jpg
    $sudo_prefix rm -Rf /var/www/html/plugins/RTSP/captures/snapshot_$1.jpg
    $sudo_prefix rm -Rf $2/snapshot_$1.jpg
fi
$sudo_prefix cp rtsp-service /etc/init.d/rtsp-service-$1

#cd /etc/init.d/
$sudo_prefix sed -i "s|\@\@name\@\@|$1|g" /etc/init.d/rtsp-service-$1
$sudo_prefix sed -i "s|\@\@targetFolder\@\@|$2|g" /etc/init.d/rtsp-service-$1
$sudo_prefix sed -i "s|\@\@protocole\@\@|$3|g" /etc/init.d/rtsp-service-$1
$sudo_prefix sed -i "s|\@\@ip\@\@|$4|g" /etc/init.d/rtsp-service-$1
$sudo_prefix sed -i "s|\@\@port\@\@|$5|g" /etc/init.d/rtsp-service-$1
$sudo_prefix sed -i "s|\@\@delay\@\@|$6|g" /etc/init.d/rtsp-service-$1
$sudo_prefix sed -i "s|\@\@url\@\@|$7|g" /etc/init.d/rtsp-service-$1
#$sudo_prefix sed -i "s|&|\\\&|g" /etc/init.d/rtsp-service-$1
#$sudo_prefix sed -i "s|?|\\\?|g" /etc/init.d/rtsp-service-$1
#$sudo_prefix sed -i "s|=|\\\=|g" /etc/init.d/rtsp-service-$1
$sudo_prefix sed -i "s|\@\@size\@\@|$8|g" /etc/init.d/rtsp-service-$1
$sudo_prefix sed -i "s|\@\@displayInfo\@\@|$9|g" /etc/init.d/rtsp-service-$1
$sudo_prefix sed -i "s|\@\@login\@\@|${10}|g" /etc/init.d/rtsp-service-$1
$sudo_prefix sed -i "s|\@\@password\@\@|${11}|g" /etc/init.d/rtsp-service-$1
$sudo_prefix sed -i "s|\@\@log\@\@| >/dev/null 2>\&1 < /dev/null \&|g" /etc/init.d/rtsp-service-$1
$sudo_prefix chmod +x /etc/init.d/rtsp-service-$1
$sudo_prefix update-rc.d rtsp-service-$1 defaults
$sudo_prefix systemctl daemon-reload
$sudo_prefix service rtsp-service-$1 start
echo "########### Fin ##########"
