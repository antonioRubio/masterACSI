function route (handle, pathname) {
	console.log('A punto de rutear una petción para ' + pathname);
	if (typeof handle[pathname] === 'function') {
		return handle[pathname]();
	} else {
		console.log("No existe manejador para la petición " + pathname);
		return "404 Not found";
	};
}

exports.route = route;
