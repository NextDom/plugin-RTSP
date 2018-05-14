<?php
/*
 * This file is part of the NextDom software (https://github.com/NextDom or http://nextdom.github.io).
 * Copyright (c) 2018 NextDom - Slobberbone.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, version 2.
 *
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */
require_once dirname(__FILE__) . '/../../../core/php/core.inc.php';
function RTSP_install() {
  $captures_path = dirname(__FILE__) . '/../captures';
  exec('rm -rf '. $captures_path . '/*');
  exec('../3rdparty/addsymblinkstoapache.sh');
/*
    $cron = cron::byClassAndFunction('RTSP', 'pull');
    if (!is_object($cron)) {
        $cron = new cron();
        $cron->setClass('RTSP');
        $cron->setFunction('pull');
        $cron->setEnable(1);
        $cron->setDeamon(0);*/
      //  $cron->setSchedule('*/5 * * * *');
      /*  $cron->save();
    }
    */
}

function RTSP_update() {
  exec('../3rdparty/reset.sh');
  $captures_path = dirname(__FILE__) . '/../captures';
  exec('rm -rf '. $captures_path . '/*');
  exec('../3rdparty/addsymblinkstoapache.sh');
  /*  $cron = cron::byClassAndFunction('RTSP', 'pull');
    if (!is_object($cron)) {
        $cron = new cron();
        $cron->setClass('RTSP');
        $cron->setFunction('pull');
        $cron->setEnable(1);
        $cron->setDeamon(0); */
      //  $cron->setSchedule('*/5 * * * *');
      /*  $cron->save();
    }
    $cron->stop(); */
}

function RTSP_remove() {
  exec('../3rdparty/reset.sh');
  $captures_path = dirname(__FILE__) . '/../captures';
  exec('rm -rf '. $captures_path . '/*');
  /*  $cron = cron::byClassAndFunction('RTSP', 'pull');
    if (is_object($cron)) {
        $cron->remove();
    }
    */
}
?>
