var dispatch_path = 'http://localhost/lis/public/index.php';

function loadPage(controller, action, params) {
	new Ajax.Updater('main', dispatch_path + '/' + controller + '/' + action + '?' + params);
}

function updateStats() {
	// new
}

function login() {
	window.location = dispatch_path + '/default/login/' + $('username').value + '/' + MD5($('password').value);
}
