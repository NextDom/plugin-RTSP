
[![license](https://img.shields.io/github/license/NextDom/plugin-RTSP.svg)](./LICENSE) [![GitHub contributors](https://img.shields.io/github/contributors/NextDom/plugin-RTSP.svg)](../../graphs/contributors) [![GitHub release](https://img.shields.io/github/release/NextDom/plugin-RTSP.svg)](../../releases) [![Donate](https://img.shields.io/badge/Donate-PayPal-green.svg)](https://www.paypal.me/slobberbone)

### Master: [![Build Status](https://travis-ci.org/NextDom/plugin-RTSP.svg?branch=master)](https://travis-ci.org/NextDom/plugin-RTSP)  [![Coverage Status](https://coveralls.io/repos/github/NextDom/plugin-RTSP/badge.svg?branch=master)](https://coveralls.io/github/NextDom/plugin-RTSP?branch=master)

### Develop: [![Build Status](https://travis-ci.org/NextDom/plugin-RTSP.svg?branch=develop)](https://travis-ci.org/NextDom/plugin-RTSP)  [![Coverage Status](https://coveralls.io/repos/github/NextDom/plugin-RTSP/badge.svg?branch=develop)](https://coveralls.io/github/NextDom/plugin-RTSP?branch=develop)

# Présentation:

Ce plugin permet de mettre à disposition du plugin Caméra une url vers une capture d'un flux RTSP.

Le pugin Caméra ne gère plus le protocol RTSP par soucis de stabilité et surtout de charge de votre Jeedom.

Le plugin RTSP vient palier se manque en proposant une alternative peu consommatrice de ressource mais avec un résultat dégradé. En effet, les captures sont réalisées toutes les ~2/3 secondes environ et stockées en mémoire pendant ~2/3 secondes.

Le plugin se base sur la commande avconv fournie par la plupart des distributions GNU/Linux dont Debian sur laquelle repose Jeedom.

Ce plugin ne remplace en rien le plugin Camera, vous devez une fois le Flux RTSP créé, copier/coller l'URL de Capture dans un équipement Camera afin que celle-ci soit visible dans Jeedom.
