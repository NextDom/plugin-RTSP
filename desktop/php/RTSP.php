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
sendVarToJS('eqType', 'RTSP');
$eqLogics = eqLogic::byType('RTSP');
?>

<div class="row row-overflow">
  <div class="col-lg-2 col-md-3 col-sm-4">
    <div class="bs-sidebar">
      <ul id="ul_eqLogic" class="nav nav-list bs-sidenav">
        <a class="btn btn-default eqLogicAction" style="width : 100%;margin-top : 5px;margin-bottom: 5px;" data-action="add"><i class="fa fa-plus-circle"></i> {{Ajouter un flux}}</a>
        <li class="filter" style="margin-bottom: 5px;"><input class="filter form-control input-sm" placeholder="{{Rechercher}}" style="width: 100%"/></li>
        <?php
foreach ($eqLogics as $eqLogic) {
	$opacity = ($eqLogic->getIsEnable()) ? '' : jeedom::getConfiguration('eqLogic:style:noactive');
	echo '<li class="cursor li_eqLogic" data-eqLogic_id="' . $eqLogic->getId() . '" style="' . $opacity . '"><a>' . $eqLogic->getHumanName(true) . '</a></li>';
}
?>
     </ul>
   </div>
 </div>

<div class="col-lg-10 col-md-9 col-sm-8 eqLogicThumbnailDisplay" style="border-left: solid 1px #EEE; padding-left: 25px;">
	<legend><i class="fa fa-cog"></i>  {{Gestion}}</legend>
	<div class="eqLogicThumbnailContainer">
		<div class="cursor eqLogicAction" data-action="gotoPluginConf" style="background-color : #ffffff; height : 140px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;">
			<center>
				<i class="fa fa-wrench" style="font-size : 5em;color:#767676;"></i>
			</center>
			<span style="font-size : 1.1em;position:relative; top : 23px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;color:#767676"><center>{{Configuration}}</center></span>
		</div>
	</div>
  <legend><i class="fa fa-table"></i>  {{Mes flux RTSP}}</legend>
  <div class="eqLogicThumbnailContainer">
    <div class="cursor eqLogicAction" data-action="add" style="background-color : #ffffff; height : 200px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;" >
     <center>
      <i class="fa fa-plus-circle" style="font-size : 7em;color:#94ca02;"></i>
     </center>
     <span style="font-size : 1.1em;position:relative; top : 23px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;color:#94ca02"><center>Ajouter</center></span>
  	</div>
	  <?php
		foreach ($eqLogics as $eqLogic) {
			$opacity = ($eqLogic->getIsEnable()) ? '' : jeedom::getConfiguration('eqLogic:style:noactive');
			echo '<div class="eqLogicDisplayCard cursor" data-eqLogic_id="' . $eqLogic->getId() . '" style="background-color : #ffffff; height : 200px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;' . $opacity . '" >';
			echo "<center>";
			echo '<img src="plugins/RTSP/doc/images/RTSP_icon.png" height="105" width="95" />';
			echo "</center>";
			echo '<span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;"><center>' . $eqLogic->getHumanName(true, true) . '</center></span>';
			echo '</div>';
		}
		?>
	</div>
</div>

<div class="col-lg-10 col-md-9 col-sm-8 eqLogic" style="border-left: solid 1px #EEE; padding-left: 25px;display: none;">
  <form class="form-horizontal">
    <fieldset>
      <legend><i class="fa fa-arrow-circle-left eqLogicAction cursor" data-action="returnToThumbnailDisplay"></i> {{Général}}  <i class='fa fa-cogs eqLogicAction pull-right cursor expertModeVisible' data-action='configure'></i></legend>
      <div class="form-group">
        <label class="col-sm-3 control-label">{{Nom de l'équipement RTSP}}</label>
        <div class="col-sm-3">
          <input type="text" class="eqLogicAttr form-control" data-l1key="id" style="display : none;" />
          <input type="text" class="eqLogicAttr form-control" data-l1key="name" placeholder="{{Nom de l'équipement RTSP}}"/>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label" >{{Objet parent}}</label>
        <div class="col-sm-3">
          <select id="sel_object" class="eqLogicAttr form-control" data-l1key="object_id">
            <option value="">{{Aucun}}</option>
            <?php
foreach (jeeObject::all() as $object) {
	echo '<option value="' . $object->getId() . '">' . $object->getName() . '</option>';
}
?>
         </select>
       </div>
     </div>
     <div class="form-group">
       <label class="col-sm-3 control-label">{{Catégorie}}</label>
       <div class="col-sm-8">
        <?php
foreach (jeedom::getConfiguration('eqLogic:category') as $key => $value) {
	echo '<label class="checkbox-inline">';
	echo '<input type="checkbox" class="eqLogicAttr" data-l1key="category" data-l2key="' . $key . '" />' . $value['name'];
	echo '</label>';
}
?>
     </div>
   </div>
   <div class="form-group">
    <label class="col-sm-3 control-label" >{{Activer}}</label>
    <div class="col-sm-9">
			<input type="checkbox" class="eqLogicAttr" data-l1key="isEnable" checked/>
   </div>
 </div>
</fieldset>
</form>
<div class="col-sm-6">
    <form class="form-horizontal">
        <fieldset>
            <legend>{{Paramètres}}</legend>
						<div class="form-group">
							<label class="col-sm-3 control-label">{{Assistant}}</label>
							<div class="col-sm-3">
								<a class="btn btn-infos" id="bt_infoCamera"><i class="fa fa-info"></i> {{Trouver les informations de ma Camera}}
								</a>
							</div>
						</div>
					 <div class="form-group">
					  <label class="col-sm-3 control-label">{{Protocole}}</label>
						<div class="col-sm-3">
								<select class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="protocole">
										<option value='rtsp'>RTSP</option>
										<option value='http'>HTTP</option>
								</select>
						</div>
						<label class="col-sm-3 control-label">{{Adresse IP}}</label>
						<div class="col-sm-3">
							<input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="ip"/>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label">{{Port}}</label>
						<div class="col-sm-3">
							<input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="port"/>
						</div>
						<label class="col-sm-3 control-label">{{Complément url (chemin)}}</label>
						<div class="col-sm-3">
							<input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="url"/>
						</div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">{{Nom de la caméra}}</label>
					  <div class="col-sm-3">
					    <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="name"/>
					  </div>
						<label class="col-sm-3 control-label">{{Résolution en pixels}}</label>
					  <div class="col-sm-3">
              <select type="text" class="eqLogicAttr configuration form-control" data-l1key="configuration" data-l2key="size" >
                <option value="640x480">640 x 480</option>
                <option value="800x600">800 x 600</option>
                <option value="1024x768">1024 x 768</option>
                <option value="1280x720">1280 x 720</option>
                <option value="1920x1080">1920 x 1080</option>
                <option value="3840x2160">3840 x 2160</option>
              </select>
						</div>
					</div>
        </fieldset>
    </form>
</div>

<div class="col-sm-6">
    <form class="form-horizontal">
        <fieldset>
            <legend>{{Options}}</legend>

						<div class="form-group">
						  <label class="col-sm-3 control-label">{{Délai (en seconde)}}</label>
						  <div class="col-sm-3">
						    <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="delay" placeholder="{{Rafraichissement (s)}}"/> 2 secondes par défaut
						  </div>
							<label class="col-sm-3 control-label">{{Horodatage}}</label>
						  <div class="col-sm-3">
								<input type="checkbox" class="eqLogicAttr" data-l1key="configuration" data-l2key="displayInfo" checked/>
							</div>
						</div>
						<div class="form-group">
						  <label class="col-sm-3 control-label">{{Emplacement des captures}}</label>
						  <div class="col-sm-3">
						    <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="targetFolder" placeholder="{{/tmp}}"/> ne modifier que si vous savez ce que vous faites
						  </div>
						</div>
						<div class="form-group">
						  <label class="col-sm-3 control-label">{{Nom d'utilisateur}}</label>
						  <div class="col-sm-3">
						    <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="login"/>
						  </div>
						  <label class="col-sm-3 control-label">{{Mot de passe}}</label>
						  <div class="col-sm-3">
						    <input type="password" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="password"/>
						  </div>
						</div>
        </fieldset>
    </form>
</div>
<span id="cameraPath_url" class="eqLogicAttr" data-l1key="configuration" data-l2key="cameraPath" style="display:none;"></span>
<span id="serviceName" class="eqLogicAttr" data-l1key="configuration" data-l2key="serviceName" style="display:none;"></span>
<span id="folderLog" class="eqLogicAttr" data-l1key="configuration" data-l2key="folderLog" style="display:none;"></span>
<div class="col-sm-6">
    <form class="form-horizontal">
        <fieldset>
            <legend>{{Résultat}}</legend>

						<div class="form-group">
						  <label class="col-sm-3 control-label">{{URL de capture (pour le plugin camera)}}</label>
						  <div class="col-sm-3">
						    <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="cameraPath" readonly/>
								URL de capture à copier/coller dans votre équipement Caméra
						  </div>
						</div>
        </fieldset>
    </form>
</div>
<div class="col-sm-6">
    <form class="form-horizontal">
        <fieldset>
            <legend>{{Test}}</legend>
						<div class="form-group">
						  <label class="col-sm-3 control-label">{{Aperçu de la capture}}</label>
							<div class="row">
							<div class="col-sm-3">
						  	<img name="capture_visu" src="" width="200" height="150"/>
							</div>
							<div class="col-sm-2">
								<a class="btn btn-infos" id="bt_refreshCapture"><i class="fa fa-refresh"></i> {{Rafraîchir}}</a>
							</div>
							<div class="col-sm-2">
								<a class="btn btn-infos" id="bt_serviceStatus"><i class="fa fa-check"></i> {{Status}}</a>
							</div>
							<div class="col-sm-1">
								<a class="btn btn-infos" id="bt_serviceLog"><i class="fa fa-commenting-o"></i> {{Logs}}</a>
							</div>
						</div>
						</div>
        </fieldset>
    </form>
</div>

<table id="table_cmd" class="table table-bordered table-condensed">
  <thead>
    <tr>
    <!--  <th style="max-width : 200px;">{{Nom}}</th><th>{{Type}}</th><th>{{Action}}</th>-->
    </tr>
  </thead>
  <tbody>
  </tbody>
</table>

<form class="form-horizontal">
  <fieldset>
    <div class="form-actions">
      <a class="btn btn-danger eqLogicAction" data-action="remove"><i class="fa fa-minus-circle"></i> {{Supprimer}}</a>
      <a class="btn btn-success eqLogicAction" data-action="save"><i class="fa fa-check-circle"></i> {{Sauvegarder}}</a>
    </div>
  </fieldset>
</form>

</div>
</div>

<?php include_file('desktop', 'RTSP', 'js', 'RTSP');?>
<?php include_file('core', 'plugin.template', 'js');?>

<script>
	$("#cameraPath_url" ).change(function(){
			var text = $("#cameraPath_url").text();
			document.capture_visu.src=text;
 	});
	$("#bt_refreshCapture").click(function(){
			var text = $("#cameraPath_url").text();
			document.capture_visu.src="plugins/RTSP/doc/images/RTSP_icon.png";
			setTimeout("reloadCapture()", 1000);
	});
	function reloadCapture(){
		var text = $("#cameraPath_url").text();
		if(text.indexOf('?') > 0){
    	text += '&t='+(new Date()).getTime();
    }else{
      text += '?t='+(new Date()).getTime();
    }
		document.capture_visu.src=text;
	}
	$("#bt_serviceStatus").click(function(){
			$('#md_modal').dialog({title: "{{Service Status}}"});
			$('#md_modal').load('index.php?v=d&plugin=RTSP&modal=status.RTSP').dialog('open');
  });
	$("#bt_serviceLog").click(function(){
			$('#md_modal').dialog({title: "{{Logs}}"});
			$('#md_modal').load('index.php?v=d&plugin=RTSP&modal=log.RTSP').dialog('open');
  });
	$("#bt_infoCamera").click(function(){
			$('#md_modal').dialog({title: "{{Assistant Informations Camera}}"});
			$('#md_modal').load('index.php?v=d&plugin=RTSP&modal=assistant.RTSP').dialog('open');
  });
</script>
