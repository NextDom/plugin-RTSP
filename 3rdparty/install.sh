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
touch /tmp/RTSP_dep
echo 0 > /tmp/RTSP_dep

if [[ $EUID -ne 0 ]]; then
  sudo_prefix=sudo;
fi
apacheDirectory=/var/www/html/core
nginxDirectory=/usr/share/nginx/www/jeedom
echo "############################################################################"
echo "# Installation in progress"
echo "############################################################################"
echo "############################################################################"
echo "# Update repository packages and install dependencies"
echo "############################################################################"
echo 5 > /tmp/RTSP_dep
$sudo_prefix apt-get update
echo 25 > /tmp/RTSP_dep
$sudo_prefix apt-get -y install tar wget
wget https://libav.org/releases/libav-12.3.tar.xz
tar xf libav-12.3.tar.xz
cd libav-12.3
./configure
./make
$sudo_prefix make install
cd /usr/bin
$sudo_prefix ln -s ../local/bin/avconv avconv
echo 50 > /tmp/RTSP_dep

echo "############################################################################"
echo "# Linking scripts"
echo "############################################################################"
$sudo_prefix ln -s $(dirname "$0")/rtsp.sh /usr/sbin/rtsp.sh
$sudo_prefix chmod 777 $(dirname "$0")/rtsp.sh
$sudo_prefix ln -s $(dirname "$0")/rtsp-wd.sh /usr/sbin/rtsp-wd.sh
$sudo_prefix chmod 777 $(dirname "$0")/rtsp-wd.sh

echo 75 > /tmp/RTSP_dep

echo "############################################################################"
echo "# Symbolic links for Apache"
echo "############################################################################"
if [ -d "$apacheDirectory" ]; then
  $sudo_prefix chmod 777 $(dirname "$0")/addsymblinkstoapache.sh
  $sudo_prefix $(dirname "$0")/addsymblinkstoapache.sh
fi

echo 100 > /tmp/RTSP_dep
rm /tmp/RTSP_dep
echo "############################################################################"
echo "# Installation finnished"
echo "############################################################################"
