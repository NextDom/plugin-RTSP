#!/bin/bash

if [[ $EUID -ne 0 ]]; then
  sudo_prefix=sudo;
fi
#chemin à renseigner (jusqu'au nom de fichier)
chemin_capture=/tmp/@@name@@.jpg

date_modif_snapshot=`stat -c %y $chemin_capture | cut -d' ' -f1,2 | cut -d'.' -f1`
date_modif_snapshot_timestamp=`date -d "$date_modif_snapshot" +%s`
timestamp_actuel=`date +%s`
difference_timestamp=$(( $timestamp_actuel - $date_modif_snapshot_timestamp ))

#indiquer à partir de combien de seconde le script va redemarer le service
difference_avant_action=500



if [ $difference_timestamp -gt $difference_avant_action ]

then $sudo_prefix service rtsp-service-@@name@@ restart

fi
