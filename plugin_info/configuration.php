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
include_file('core', 'authentification', 'php');
if (!isConnect()) {
    include_file('desktop', '404', 'php');
    die();
}
?>


<form class="form-horizontal">

  <div class="panel-body">
    <div class="form-group">
      <label class="col-sm-2 control-label">{{Configuration :}}</label>
      <div class="col-lg-4">
        <a class="btn btn-info" href=/index.php?v=d&m=RTSP&p=RTSP> {{Accès à la configuration}}</a>
      </div>
      <label class="col-sm-2 control-label">{{Apache Configuration :}}</label>
  		<?php
  		if (exec('sudo grep -R "FollowSymLinks" /etc/apache2/sites-available/000-default.conf') != "") {
  			echo '<div class="col-lg-1"><span class="label label-success">OK</span></div>';
  		} else {
  			echo '<div class="col-sm-4">
  				<a class="btn btn-danger" id="bt_followLinksRTSP"><i class="fa fa-check"></i> {{Autoriser les liens symboliques}}</a>
  			</div>';
  		}
  		?>
			<!-- <div class="col-sm-4">
				<a class="btn btn-danger" id="bt_followLinksRTSP"><i class="fa fa-check"></i> {{Autoriser les liens symboliques}}</a>
			</div> -->
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">{{Réparer :}}</label>
			<div class="col-sm-4">
				<a class="btn btn-danger" id="bt_resetRTSP"><i class="fa fa-check"></i> {{Forcer l'arrêt de tous les services RTSP}}</a>
			</div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label"></label>
      <div class="col-sm-4">
      </div>
      <label class="col-sm-2 control-label">{{Aide :}}</label>
      <div class="col-sm-4">
        <a class="btn btn-success" href="/plugins/RTSP/docs/fr_FR/index.html"><i class="fa fa-question-circle"></i> {{Documentation locale}}</a>
      </div>
    </div>
  </div>
</form>
<script>
  $('#bt_resetRTSP').on('click',function(){
  		bootbox.confirm('{{Etes-vous sûr de vouloir forcer l\'arrêt la totalité des services RTSP ?}}', function (result) {
  			if (result) {
  				$('#md_modal').dialog({title: "{{Reset}}"});
  				$('#md_modal').load('index.php?v=d&plugin=RTSP&modal=reset.RTSP').dialog('open');
  			}
  		});
  	});
    $('#bt_followLinksRTSP').on('click',function(){
    		bootbox.confirm('{{Etes-vous sûr de vouloir modifier la configuration d\'Apache ? Assurez-vous de bien utiliser celui-ci et non Nginx !}}', function (result) {
    			if (result) {
    				$('#md_modal').dialog({title: "{{Configuration Apache}}"});
    				$('#md_modal').load('index.php?v=d&plugin=RTSP&modal=followLinks.RTSP').dialog('open');
    			}
    		});
    	});
</script>
