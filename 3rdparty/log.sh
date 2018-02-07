#!/bin/bash

if [[ $EUID -ne 0 ]]; then
  sudo_prefix=sudo;
fi
echo "########### Logs du service $1 ##########"
echo `$sudo_prefix cat $2/$1.log`
echo "########### Fin ##########"
