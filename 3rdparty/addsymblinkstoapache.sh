#!/bin/bash

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
