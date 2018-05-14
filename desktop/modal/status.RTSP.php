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
if (!isConnect('admin')) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
?>
<div id='div_statusRTSPAlert' style="display: none;"></div>
<a class="btn btn-warning pull-right" data-state="1" id="bt_RTSPLogStopStart"><i class="fa fa-pause"></i> {{Pause}}</a>
<input class="form-control pull-right" id="in_RTSPLogSearch" style="width : 300px;" placeholder="{{Rechercher}}" />
<br/><br/><br/>
<pre id='pre_RTSPstatus' style='overflow: auto; height: 90%;with:90%;'></pre>


<script>
	$.ajax({
		type: 'POST',
		url: 'plugins/RTSP/core/ajax/RTSP.ajax.php',
		data: {
			action: 'statusRTSP',
			serviceName: $("#serviceName").text()
		},
		dataType: 'json',
		global: false,
		error: function (request, status, error) {
			handleAjaxError(request, status, error, $('#div_statusRTSPAlert'));
		},
		success: function () {
			 jeedom.log.autoupdate({
			       log : 'RTSP_status',
			       display : $('#pre_RTSPstatus'),
			       search : $('#in_RTSPLogSearch'),
			       control : $('#bt_RTSPLogStopStart'),
           		});
		}
	});
</script>
