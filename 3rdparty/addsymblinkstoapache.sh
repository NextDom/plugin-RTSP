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
  sudo_prefix = "sudo";
fi

echo "### Autorisation de liens symboliques pour le serveur Web Apache ###"
cd "$(dirname "$0")"
if grep -q "Options FollowSymLinks" /etc/apache2/sites-available/000-default.conf ; then
  $sudo_prefix service apache2 reload
  echo "### Modification de la configuration d'Apache déjà effectuée ###"
else
  $sudo_prefix sed '/DocumentRoot \/var\/www\/html/r followLinks.txt'  /etc/apache2/sites-available/000-default.conf > /tmp/000-default_temp.conf
  $sudo_prefix mv /tmp/000-default_temp.conf /etc/apache2/sites-available/000-default.conf
  $sudo_prefix service apache2 reload
  echo "### Modification de la configuration d'Apache effectuée et appliquée ###"
fi
if grep -q "\-FollowSymLinks" /etc/apache2/conf-enabled/security.conf ; then
  $sudo_prefix sed -i "s|-FollowSymLinks| |g" /etc/apache2/conf-enabled/security.conf
  $sudo_prefix service apache2 reload
  echo "### Modification de la configuration de sécurité d'Apache effectuée et appliquée ###"
fi
