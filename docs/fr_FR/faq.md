# FAQ

### Est-ce que le plugin peut faire des captures plus régulière ?

Non, le plugin utilise une commande peu gourmande en ressource, pour celà une capture toute les 2 secondes environ est un bon compromis.

### Pouquoi modifier l'emplacement des captures ?

Par défaut, les captures sont faites sur /tmp qui est monté en ram, ceci permet de ne pas user prématurément votre carteSD. Si ce n'est pas le cas chez vous (première Mini+ ou DIY). Voici un tutorial pour monter un dossier en RAM :
Nous allons creer un point de montage sur /mnt/rtsp.

Il faut créer le dossier :

`sudo mkdir /mnt/rtsp`

Puis il faut changer les droits :

`sudo chmod 777 /mnt/rtsp`

Enfin un tmpfs se monte comme tous les points de montage sous linux,
avec la commande `mount` :

`sudo mount -t tmpfs -o size=16M tmpfs /mnt/rtsp`

Pour le monter automatiquement au démarrage il faut éditer le fichier
/etc/fstab et rajouter :

Exemple de ligne à rajouter:

`tmpfs /mnt/rtsp tmpfs defaults,size=16m 0 0`

Enfin, n'oubliez pas de spécifier /mnt/rtsp dans le plugin RTSP !

### Pourquoi le plugin est gratuit ?

Ce plugin est gratuit pour que chacun puisse en profiter simplement. Si vous souhaitez tout de même faire un don au développeur du plugin.

### Je n'ai pas de capture d'écran

Vérifier si l'url http(s)://votrenomdedomaine/snapshot_test.jpg affiche une image. Si vous faites F5, celle-ci se raffraichit-elle ? Si oui Le problème vient du plugin Caméra. Sinon, exposez votre problème sur le forum.

### Ma capture d'écran ne se raffraichit plus

Vérifier si l'url http(s)://votrenomdedomaine/snapshot_test.jpg affiche une image. Si vous faites F5, celle-ci se raffraichit-elle ? Si oui Le problème ne vient pas du plugin RTSP. Sinon, exposez votre problème sur le forum.

### Ma capture d'écran ne se raffraichit toujours pas

Se connecter en SSH et vérifier les commandes suivantes : `sudo service rtsp-service-{nomdevotreflusRTSP} status`. Puis : `sudo service rtsp-service-{nomdevotreflusRTSP} restart` selon le résultat.
