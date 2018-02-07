#!/bin/bash
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
$sudo_prefix apt-get -y install libav-tools
echo 50 > /tmp/RTSP_dep

echo "############################################################################"
echo "# Linking scripts"
echo "############################################################################"
$sudo_prefix ln -s $(dirname "$0")/rtsp.sh /usr/sbin/rtsp.sh
$sudo_prefix chmod 777 $(dirname "$0")/rtsp.sh
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
