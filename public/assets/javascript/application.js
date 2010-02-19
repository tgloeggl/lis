function loadPage(controller, action, params) {
	new Ajax.Updater('main', 'http://localhost/lis/public/index.php/' + controller + '/' + action + '?' + params);
}

function updateStats() {
	// new
}
