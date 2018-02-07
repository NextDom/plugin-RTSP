#!/bin/bash
apacheDirectory=/var/www/html/core
nginxDirectory=/usr/share/nginx/www/jeedom

touch $3/snapshot_$4.jpg
if [ -d "$apacheDirectory" ]; then
  ln -s $3/snapshot_$4.jpg /var/www/html/plugins/RTSP/captures/snapshot_$4.jpg
  chmod 666 /var/www/html/plugins/RTSP/captures/snapshot_$4.jpg
  chown www-data:www-data /var/www/html/plugins/RTSP/captures/snapshot_$4.jpg
fi

if [ -d "$nginxDirectory" ]; then
  ln -s $3/snapshot_$4.jpg /usr/share/nginx/www/jeedom/plugins/RTSP/captures/snapshot_$4.jpg
  chmod 666 /usr/share/nginx/www/jeedom/plugins/RTSP/captures/snapshot_$4.jpg
  chown www-data:www-data /usr/share/nginx/www/jeedom/plugins/RTSP/captures/snapshot_$4.jpg
fi

url=""
if [ ${10} != '' ]
then
  url="${10}:${11}@"
fi
complement=$(echo "$7" | sed 's/[\]//g')    # substitute to escape the ampersand
while sleep $6
do
if [ $9 -eq 1 ]
then
  datetime=$(echo $(date +%Y-%m-%dT%H\\:%M\\:%S))
  displayInfo="drawtext=fontfile=/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf: text='$datetime': fontcolor=black@0.8: x=50: y=60"
  /usr/bin/avconv -i $1://$url$2:$5$complement -s $8 -frames:v 1  -an -vf "$displayInfo" -y $3/snapshot_$4.jpg > $3/$4.log 2>&1
else
  /usr/bin/avconv -i $1://$url$2:$5$complement -s $8 -frames:v 1  -an -y $3/snapshot_$4.jpg > $3/$4.log 2>&1
fi
done
