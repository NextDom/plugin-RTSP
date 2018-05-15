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

try {
    require_once __DIR__ . '/../../../../core/php/core.inc.php';
    include_file('core', 'authentification', 'php');

    if (!isConnect('admin')) {
        throw new \Exception(__('401 - Accès non autorisé', __FILE__));
    }
    if (init('action') == 'updateRTSP') {
        RTSP::updateRTSP();
        ajax::success();
    }

    if (init('action') == 'resetRTSP') {
        RTSP::resetRTSP();
        ajax::success();
    }

    if (init('action') == 'statusRTSP') {
        RTSP::statusRTSP(init('serviceName'));
        ajax::success();
    }

    if (init('action') == 'followLinksRTSP') {
        RTSP::followLinksRTSP(init('serviceName'));
        ajax::success();
    }

    if (init('action') == 'logRTSP') {
        RTSP::logRTSP(init('serviceName'), init('folderLog'));
        ajax::success();
    }

    throw new \Exception(__('Aucune methode correspondante à : ', __FILE__) . init('action'));
} catch (\Exception $e) {
    ajax::error(display\Exception($e), $e->getCode());
}
 
