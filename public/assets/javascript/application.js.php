var dispatch_path = '<?= Config::get('web_path') ?>/index.php';

function loadPage(controller, action, params) {
	new Ajax.Updater('main', dispatch_path + '/' + controller + '/' + action + params);
}

function updateStats() {
	// new
}

function login() {
	window.location = dispatch_path + '/default/login/' + $('username').value + '/' + MD5($('password').value);
}

function build(planet_id, building_id) {
	new Ajax.Updater('main', dispatch_path + '/planets/build/' + planet_id + '/' + building_id);
}

function checkLoginEnter(e) {
	var keyID = (window.event) ? event.keyCode : e.keyCode;
	if (keyID == 13) { login(); }
}

function switchIt(id) {
	if ($(id).visible()) {
		new Effect.BlindUp(id, { duration: 0.2 });
	} else {
		new Effect.BlindDown(id, { duration: 0.2 });
	}
}

new Ajax.PeriodicalUpdater('stats', dispatch_path + '/default/stats', { frequency: 10 });
new Ajax.PeriodicalUpdater('messages', dispatch_path + '/messages/stats', { frequency: 10 });

function debug(text) {
	$('debug').innerHTML += '<br>' + text;
}


var Message = {
	error: function(text) {
		if (!$('message_area')) {
			$('body').innerHTML += '<div id="message_area" class="messages"></div>';
		}

		$('message_area').innerHTML += '<div class="error" style="position: relative">' + text
			+ '<div class="close_message" onClick="this.parentNode.fade()">&nbsp;X&nbsp;</div>'
			+	'</div>';
	},

	question: function(text, controller, action, params) {
		$('body').innerHTML += '<div id="question" class="question">' + text
			+ '<br><br><button onClick="loadPage(\''+ controller +'\', \''+  action +'\', \''+ params +'\');$(\'question\').remove()">Ja</button>'
			+ '&nbsp; &nbsp; &nbsp; <button onClick="$(\'question\').remove()">Abbrechen</button>'
			+ '</div>';
	}
}

var Shipdesign = {
	sizes     : new Array(),
	drives    : new Array(),
	modules   : new Array(),
	init_done : 0,
	can_build : true,

	updateDrive: function() {
		Shipdesign.init();
		$('drive_carboxin').innerHTML = Shipdesign.drives[$F('drive')]['carboxin'];
		$('drive_detrogen').innerHTML = Shipdesign.drives[$F('drive')]['detrogen'];
		$('drive_radium').innerHTML   = Shipdesign.drives[$F('drive')]['radium'];
	},

	updateModules: function() {
		Shipdesign.init();

		// get all modules from form
		var mod = $$('input.module');

		var carboxin = detrogen = radium = credits = armor = weight =  0;
		var damage = new Array();
		for (var i = 1; i<= 10; i++) {
			damage[i] = 0;
		}

		// set data for ship-size only

		// initialize data for ship-size costs
		armor    = Shipdesign.sizes[$F('size')]['armor'];
		weight   = Shipdesign.sizes[$F('size')]['weight'];
		carboxin = Shipdesign.sizes[$F('size')]['carboxin'];
		detrogen = Shipdesign.sizes[$F('size')]['detrogen'];
		radium   = Shipdesign.sizes[$F('size')]['radium'];
		credits  = Shipdesign.sizes[$F('size')]['credits'];

		for(var i = 0; i  < mod.length; i++){
			id = mod[i].id;
			if (mod[i].value < 0) mod[i].value = 0;
			armor    += Shipdesign.modules[id]['armor']    * mod[i].value;
			weight   += Shipdesign.modules[id]['weight']   * mod[i].value;
			carboxin += Shipdesign.modules[id]['carboxin'] * mod[i].value;
			detrogen += Shipdesign.modules[id]['detrogen'] * mod[i].value;
			radium   += Shipdesign.modules[id]['radium']   * mod[i].value;
			credits  += Shipdesign.modules[id]['credits']  * mod[i].value;

			for (var j = Shipdesign.modules[id]['range']; j > 0; j--) {
				damage[j] += (Shipdesign.modules[id]['attack'] * mod[i].value);
			}
		}

		var max_dmg = 0;
		for (var i = 1; i <= 10; i++) {
			max_dmg = Math.max(max_dmg, damage[i]);
		}

		for (var i = 1; i <= 10; i++) {
			$('dmg_' + i).innerHTML = damage[i];
			if (damage[i] > 0) {
				var color = Math.floor(150 / (max_dmg / damage[i])) + 50;
				$('dmg_' + i).style.backgroundColor = 'rgb(0, '+ color +', 0)';
			} else {
				$('dmg_' + i).style.backgroundColor = '#660000';
			}
		}

		$('whole_weight').innerHTML  = weight;
		$('armor').innerHTML         = armor;
		$('cost_carboxin').innerHTML = carboxin;
		$('cost_detrogen').innerHTML = detrogen;
		$('cost_radium').innerHTML   = radium;
		$('cost_credits').innerHTML  = credits;

		if (weight > Shipdesign.sizes[$F('size')]['tonnage']) {
			// debug('Ship to heavy: '+ weight +'/'+ Shipdesign.sizes[$F('size')]['tonnage']);
			Shipdesign.can_build = false;
		} else {
			Shipdesign.can_build = true;
		}
	},

	build: function() {
		if (!$('ship_name').value) {
			Message.error('Sie müssen dem Schiffstyp einen Namen geben');
			return false;
		}

		if (!Shipdesign.can_build) {
			Message.error('Sie haben zuviele Module in das Schiff eingebaut, es ist zu schwer! Wir haben nicht die Technologie ein so großes Schiff zu bauen!');
			return false;
		}

		$('shipdesigner').request({
			onComplete: function() {
				loadPage('design', '', '');
			}
		});	
		return false;
		// document.shipdesigner.submit();
	},

	init: function() {
		if (Shipdesign.init_done == 0) {
			var zw = new Array();
			<? foreach (Tech::getShipsizes() as $size): ?>
			zw[<?= $size['shipsize_id'] ?>] = new Array();
			zw[<?= $size['shipsize_id'] ?>]['tonnage']  = <?= $size['tonnage'] ?>;
			zw[<?= $size['shipsize_id'] ?>]['weight']   = <?= $size['weight'] ?>;
			zw[<?= $size['shipsize_id'] ?>]['armor']    = <?= $size['armor'] ?>;
			zw[<?= $size['shipsize_id'] ?>]['carboxin'] = <?= $size['carboxin'] ?>;
			zw[<?= $size['shipsize_id'] ?>]['detrogen'] = <?= $size['detrogen'] ?>;
			zw[<?= $size['shipsize_id'] ?>]['radium']   = <?= $size['radium'] ?>;
			zw[<?= $size['shipsize_id'] ?>]['credits']  = <?= $size['credits'] ?>;
			<? endforeach ?>
			Shipdesign.sizes = zw;

			zw = new Array();
			<? foreach (Tech::getDrives() as $drive): ?>
			zw[<?= $drive['drive_id'] ?>] = new Array();
			zw[<?= $drive['drive_id'] ?>]['carboxin'] = '<?= $drive['carboxin'] ?>';
			zw[<?= $drive['drive_id'] ?>]['detrogen'] = '<?= $drive['detrogen'] ?>';
			zw[<?= $drive['drive_id'] ?>]['radium']   = '<?= $drive['radium'] ?>';
			<? endforeach ?>
			Shipdesign.drives = zw;

			zw = new Array();
			<? foreach (Tech::getModules() as $module): ?>
			zw[<?= $module['module_id'] ?>] = new Array();
			zw[<?= $module['module_id'] ?>]['weight']   = '<?= $module['weight'] ?>';
			zw[<?= $module['module_id'] ?>]['armor']    = '<?= $module['armor'] ?>';
			zw[<?= $module['module_id'] ?>]['carboxin'] = '<?= $module['carboxin'] ?>';
			zw[<?= $module['module_id'] ?>]['detrogen'] = '<?= $module['detrogen'] ?>';
			zw[<?= $module['module_id'] ?>]['radium']   = '<?= $module['radium'] ?>';
			zw[<?= $module['module_id'] ?>]['credits']  = '<?= $module['credits'] ?>';
			zw[<?= $module['module_id'] ?>]['attack']   = '<?= $module['attack'] ?>';
			zw[<?= $module['module_id'] ?>]['armor']    = '<?= $module['armor'] ?>';
			zw[<?= $module['module_id'] ?>]['range']    = '<?= $module['range'] ?>';
			zw[<?= $module['module_id'] ?>]['cargo']    = '<?= $module['cargo'] ?>';
			<? endforeach ?>
			Shipdesign.modules = zw;

	 	}
		
		Shipdesign.init_done = 1;
	}
}
