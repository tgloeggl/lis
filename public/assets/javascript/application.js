var dispatch_path = 'http://rona.virtuos.uos.de/lis/index.php';

function loadPage(controller, action, params) {
	new Ajax.Updater('main', dispatch_path + '/' + controller + '/' + action + '?' + params);
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

new Ajax.PeriodicalUpdater('stats', dispatch_path + '/default/stats',
	{ frequency: 10 });
	
new Ajax.PeriodicalUpdater('messages', dispatch_path + '/messages/stats',
	{ frequency: 10 });
