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

/* * ***************************Includes********************************* */
require_once __DIR__ . '/../../../../core/php/core.inc.php';

class RTSP extends eqLogic
{

    public static function pull($eqLogicId = null)
    {
        if (self::$_eqLogics === null) {
            self::$_eqLogics = self::byType('RTSP');
        }
    }

    public static function dependancy_info()
    {
        $return                  = array();
        $return['log']           = 'RTSP_dep';
        $return['progress_file'] = '/tmp/RTSP_dep';
        $avconv                  = '/usr/bin/avconv';
        $rtsp                    = '/usr/sbin/rtsp.sh';
        $return['progress_file'] = '/tmp/RTSP_dep';
        if (is_file($avconv) && is_file($rtsp)) {
            $return['state'] = 'ok';
        } else {
            if (!is_file($avconv)) {
                exec('echo Avconv binary dependency not found : ' . $avconv . ' > ' . log::getPathToLog('RTSP_log') . ' 2>&1 &');
            } else {
                exec('echo RSTP script dependency not found : ' . $rtsp . ' > ' . log::getPathToLog('RTSP_log') . ' 2>&1 &');
            }
            $return['state'] = 'nok';
        }
        return $return;
    }

    public static function dependancy_install()
    {
        log::add('RTSP', 'info', 'Installation des dépéndances ffmpeg et libav-tools');
        $resource_path = realpath(dirname(__FILE__) . '/../../3rdparty');
        passthru('/bin/bash ' . $resource_path . '/install.sh ' . $resource_path . ' > ' . log::getPathToLog('RTSP_dep') . ' 2>&1 &');
    }

    public static function updateRTSP()
    {
        log::remove('RTSP_update');
        $cmd = '/bin/bash ' . dirname(__FILE__) . '/../../3rdparty/install.sh';
        $cmd .= ' >> ' . log::getPathToLog('RTSP_update') . ' 2>&1 &';
        exec($cmd);
    }

    public static function resetRTSP()
    {
        log::remove('RTSP_reset');
        $cmd = '/bin/bash ' . dirname(__FILE__) . '/../../3rdparty/reset.sh';
        $cmd .= ' >> ' . log::getPathToLog('RTSP_reset') . ' 2>&1 &';
        exec($cmd);
    }

    public static function followLinksRTSP()
    {
        log::remove('RTSP_followLinks');
        $cmd = '/bin/bash ' . dirname(__FILE__) . '/../../3rdparty/addsymblinkstoapache.sh';
        $cmd .= ' >> ' . log::getPathToLog('RTSP_followLinks') . ' 2>&1 &';
        exec($cmd);
    }

    public static function statusRTSP($serviceName)
    {
        log::remove('RTSP_status');
        $cmd = '/bin/bash ' . __DIR__ . '/../../3rdparty/status.sh ' . $serviceName;
        $cmd .= ' >> ' . log::getPathToLog('RTSP_status') . ' 2>&1 &';
        exec($cmd);
    }

    public static function logRTSP($serviceName, $folderLog)
    {
        log::remove('RTSP_log');
        $cmd = '/bin/bash ' . __DIR__ . '/../../3rdparty/log.sh ' . $serviceName . ' ' . $folderLog;
        $cmd .= ' >> ' . log::getPathToLog('RTSP_log') . ' 2>&1 &';
        exec($cmd);
    }

    /* 	public function postInsert() {
      $this->setCategory('securite', 1);
      $cmd = '/bin/bash ' .dirname(__FILE__) . '/../../3rdparty/create.sh ' . $this->getConfiguration('name') . ' ' . $this->getConfiguration('ip') . ' ' . $this->getConfiguration('path');
      $cmd .= ' >> ' . log::getPathToLog('RTSP_create') . ' 2>&1 &';
      exec('echo Name : ' . $this->getConfiguration('name') . ' IP : ' . $this->getConfiguration('ip') . ' URL : ' . $this->getConfiguration('url') . ' >> ' . log::getPathToLog('RTSP_create') . ' 2>&1 &');
      exec($cmd);
      $this->setConfiguration('cameraPath','snapshot_' . $this->getConfiguration('name') . '.jpg');
      } */

    public function preUpdate()
    {
        if ($this->getConfiguration('ip') == '') {
            throw new \Exception(__('Le champs Adresse IP ne peut être vide', __FILE__));
        }
        if ($this->getConfiguration('port') == '') {
            throw new \Exception(__('Le champs Port ne peut être vide', __FILE__));
        }
        if (!$this->getConfiguration('delay') == '') {
            if (!preg_match("#[0-9]$#", $this->getConfiguration('delay'))) {
                throw new \Exception(__('Le champs Délai ne peut contenir autre chose que des chiffres', __FILE__));
            }
        }
        // Si la chaîne contient des caractères spéciaux
        if (!preg_match("#[0-9]$#", $this->getConfiguration('port'))) {
            throw new \Exception(__('Le champs Port ne peut contenir autre chose que des chiffres', __FILE__));
        }
        if ($this->getConfiguration('url') == '') {
            throw new \Exception(__('Le champs Complément URL ne peut être vide', __FILE__));
        }
        // Si l'url' ne commence pas par /
        if (substr($this->getConfiguration('url'), 0, 1) !== "/") {
            throw new \Exception(__('Le champs Complément URL doit commencer par un /', __FILE__));
        }
        // Si l'url' ne commence pas par /
        if ($this->getConfiguration('capturePath') !== '' && substr($this->getConfiguration('capturePath'), 0, 1) !== "/") {
            throw new \Exception(__('Le champs Emplacement des captures doit commencer par un /', __FILE__));
        }
        if ($this->getConfiguration('name') === '') {
            throw new \Exception(__('Le champs Nom ne peut être vide', __FILE__));
        }
        // Si la chaîne contient des caractères spéciaux
        if (!preg_match("#[a-zA-Z0-9_-]$#", $this->getConfiguration('name'))) {
            throw new \Exception(__('Le champs Nom ne peut contenir de caractères spéciaux', __FILE__));
        }
        // Si la chaîne contient des caractères spéciaux
        if (preg_match("/\\s/", $this->getConfiguration('name'))) {
            throw new \Exception(__('Le champs Nom ne peut contenir d\'espaces', __FILE__));
        }
        if ($this->getConfiguration('size') == '') {
            throw new \Exception(__('Le champs résolution ne peut être vide', __FILE__));
        }

    }


    public function preSave()
    {
        if ($this->getConfiguration('delay') == '') {
            $this->setConfiguration('delay', 2);
        }
        if ($this->getConfiguration('targetFolder') == '') {
            $this->setConfiguration('targetFolder', '/tmp');
        }
        if (!$this->getConfiguration('lastName') == '') {
            if ($this->getConfiguration('name') !== $this->getConfiguration('lastName')) {
                exec('echo Remove Service Name : ' . $this->getConfiguration('lastName') . ' >> ' . log::getPathToLog('RTSP_delete') . ' 2>&1 &');
                $cmd = '/bin/bash ' . dirname(__FILE__) . '/../../3rdparty/delete.sh ' . $this->getConfiguration('lastName');
                $cmd .= ' >> ' . log::getPathToLog('RTSP_delete') . ' 2>&1 &';
                exec($cmd);
                sleep(2);
                $this->setConfiguration('lastName', $this->getConfiguration('name'));
                exec('echo Setting Last Service Name : ' . $this->getConfiguration('lastName') . ' >> ' . log::getPathToLog('RTSP_delete') . ' 2>&1 &');
            }
        }
        if ($this->getIsEnable()) {
            $this->setConfiguration('cameraPath', 'plugins/RTSP/captures/snapshot_' . $this->getConfiguration('name') . '.jpg');
        }
        $this->setConfiguration('serviceName', $this->getConfiguration('name'));
        $this->setConfiguration('folderLog', $this->getConfiguration('targetFolder'));
    }

    public function postSave()
    {
        foreach (eqLogic::byType('RTSP') as $RTSP) {
            $RTSP->getInformations();
        }
        if ($this->getIsEnable()) {
            //$URL = str_replace("/","\\/",$this->getConfiguration('url'));
            //$URL = str_replace("&","\\&",$URL);

            $URL = escapeshellarg($this->getConfiguration('url'));
            $URL = str_replace("&", "\&", $URL);
            $URL = str_replace("?", "\?", $URL);
            $cmd = '/bin/bash ' . dirname(__FILE__) . '/../../3rdparty/create.sh ' . $this->getConfiguration('name') . ' ' . str_replace("/", "\\/", rtrim($this->getConfiguration('targetFolder'), "/")) . ' ' . $this->getConfiguration('protocole', 'rtsp') . ' ' . $this->getConfiguration('ip') . ' ' . $this->getConfiguration('port') . ' ' . $this->getConfiguration('delay') . ' ' . $URL . ' ' . $this->getConfiguration('size') . ' ' . $this->getConfiguration('displayInfo') . ' ' . $this->getConfiguration('login') . ' ' . $this->getConfiguration('password');
            $cmd .= ' >> ' . log::getPathToLog('RTSP_create') . ' 2>&1 &';
            exec('echo Create/Update Service Name : ' . $this->getConfiguration('name') . ' Protocole : ' . $this->getConfiguration('protocole', 'rtsp') . ' IP : ' . $this->getConfiguration('ip') . ' Emplacement : ' . str_replace("/", "\\/", rtrim($this->getConfiguration('targetFolder'), "/")) . ' Port : ' . $this->getConfiguration('port') . ' Delay : ' . $this->getConfiguration('delay') . ' Size : ' . $this->getConfiguration('size') . ' URL : ' . $URL . ' Horodatage : ' . $this->getConfiguration('displayInfo') . ' ' . ' Utilisateur : ' . $this->getConfiguration('login') . ' >> ' . log::getPathToLog('RTSP_create') . ' 2>&1 &');
            exec($cmd);
        } else {
            $cmd = '/bin/bash ' . dirname(__FILE__) . '/../../3rdparty/stop.sh ' . $this->getConfiguration('name');
            $cmd .= ' >> ' . log::getPathToLog('RTSP_status') . ' 2>&1 &';
            exec($cmd);
        }
    }

    public function preRemove()
    {
        $cmd = '/bin/bash ' . dirname(__FILE__) . '/../../3rdparty/delete.sh ' . $this->getConfiguration('name');
        $cmd .= ' >> ' . log::getPathToLog('RTSP_delete') . ' 2>&1 &';
        exec('echo Delete Service Name : ' . $this->getConfiguration('name') . ' >> ' . log::getPathToLog('RTSP_delete') . ' 2>&1 &');
        exec($cmd);
    }

    /**
     *
     * @return string|object
     */
    public function getInformations()
    {
        $state = null;
        foreach ($this->getCmd() as $cmd) {
            $ip   = $this->getConfiguration('ip');
            $name = $this->getConfiguration('name');
            $sudo = exec("\$EUID");

            if ($sudo == "0") {
                $state = exec("/etc/init.d/rtsp-service-$name status");
            } else {
                $state = exec("sudo /etc/init.d/rtsp-service-$name status");
            }

            $cmd->event($state);
        }
        if (is_object($state)) {
            return $state;
        } else {
            return '';
        }
    }

}

class RTSPCmd extends cmd
{

    public function execute($_options = null)
    {
        $name = $this->getConfiguration('name');

        $state = exec("/etc/init.d/rtsp-service-$name status");

        if (is_object($state)) {
            return $state;
        } else {
            return '';
        }
    }

}
