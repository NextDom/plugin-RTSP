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
