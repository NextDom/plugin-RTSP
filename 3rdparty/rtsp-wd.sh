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

while true
do
  pid=$(ps -ax | grep "$1"  | grep 'ffmpeg' | cut -c-5)
#  echo "pid : $pid"

  if [ "$pid" !=  "" ]; then
    elapsed=$(ps -p $pid -o etimes | grep -v ELAPSED)
#    echo "elapsed : $elapsed"
  else
    elapsed=0
  fi

  if [ "$elapsed" -gt 20 ]; then
    kill -9 "$pid"
    echo "killed $pid was still running after $elapsed sec"
  fi
  
  sleep $2

done
